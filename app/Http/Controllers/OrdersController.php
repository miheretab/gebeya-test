<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Order;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class OrdersController extends Controller
{
    public function byClient(Request $request) {
        $productIds = Product::where('user_id', Auth::user()->id)->pluck('id')->toArray();
        $orders = Order::whereIn('product_id', $productIds)->orderBy('created_at', 'desc')->paginate(10);

        return view('orders.by-client')->with(compact('orders'));
    }

    public function view(Request $request, $id) {
        $order = Order::findOrFail($id);

        return view('orders.view')->with(compact('order'));
    }

    public function complete(Request $request, $id) {
        $order = Order::findOrFail($id);
        $order->status = 'completed';
        $order->save();

        return redirect('/client-orders');
    }

    public function index() {
        $cart = session('cart', ['orders' => [], 'customer' => null]);

        return view('orders.index')->with(compact('cart'));
    }

    public function addToCart(Request $request, $id, $categoryId = null) {
        $product = Product::where('slug', $id)->firstOrFail();

        $cart = session('cart', ['orders' => [], 'customer' => null]);
        $orders = $cart['orders'];
        $customer = isset($cart['customer']) ? $cart['customer'] : null;
        $quantity = $request->input('quantity');

        if ($quantity <= 0) {
            $status = "Invalid Quantity";
            return redirect()->back()->with(compact('status'));
        }

        if ($product->quantity > 0 && $product->quantity >= $quantity) {
            $product->quantity = $product->quantity - $quantity;
            $product->save();
            $status = "Added to cart successfully";
        } else if ($product->quantity > 0) {
            $quantity = $product->quantity;
            $product->quantity = 0;
            $product->save();
            $status = "You got last ones and added to cart successfully";
        } else {
            $quantity = 0;
            $status = "Sold out";
        }

        if (isset($orders[$id])) {
            $orders[$id]['quantity'] += $quantity;
        } else {
            $orders[$id] = ['quantity' => $quantity, 'product' => $product];
        }

        session(['cart' => compact('orders', 'customer')]);

        return redirect()->back()->with(compact('status'));
    }

    public function updateCart(Request $request) {
        $input = $request->all();
        $cart = session('cart', ['orders' => [], 'customer' => null]);
        $orders = $cart['orders'];
        $customer = isset($cart['customer']) ? $cart['customer'] : null;

        $status = "";
        foreach ($input['quantity'] as $id => $quantity) {
            $product = Product::where('slug', $id)->first();

            if ($quantity < 0) {
                $status = "Invalid Quantity";
                continue;
            }

            $diffQuantity = $quantity - $orders[$id]['quantity'];
            if ($diffQuantity == 0) {
                continue;
            }

            if ($product->quantity > 0 && $product->quantity >= $diffQuantity) {
                $product->quantity = $product->quantity - $diffQuantity;
                $product->save();
                $status = "Cart updated successfully";
            } else if ($product->quantity > 0) {
                $quantity = $orders[$id]['quantity'] + $product->quantity;
                $product->quantity = 0;
                $product->save();
                $status = "You got last ones and cart updated successfully";
            } else if ($product->quantity == 0 && $diffQuantity < 0) {
                $product->quantity = -$diffQuantity;
                $product->save();
                $status = "Cart updated successfully";
            } else {
                $quantity = $orders[$id]['quantity'];
                $status = "Sold out";
            }

            if ($quantity > 0) {
                $orders[$id]['quantity'] = $quantity;
            } else {
                unset($orders[$id]);
            }
        }

        session(['cart' => compact('orders', 'customer')]);

        return redirect('/orders')->with(compact('status'));
    }

    public function removeFromCart(Request $request, $id, $categoryId = null) {
        $product = Product::where('slug', $id)->firstOrFail();

        $cart = session('cart', ['orders' => [], 'customer' => null]);
        $orders = $cart['orders'];
        $customer = isset($cart['customer']) ? $cart['customer'] : null;

        if (isset($orders[$id])) {
            $product->quantity = $product->quantity + $orders[$id]['quantity'];
            $product->save();
            $status = "Removed from cart successfully";
            unset($orders[$id]);
        }

        session(['cart' => compact('orders', 'customer')]);

        return redirect()->back()->with(compact('status'));
    }

    public function checkout(Request $request) {
        $cart = session('cart', ['orders' => [], 'customer' => null]);

        if ($request->isMethod('post')) {
            $orders = $cart['orders'];
            $customer = isset($cart['customer']) ? $cart['customer'] : null;
            $input = $request->all();

            if (!$customer) {
                $customer = Customer::create($input);
            } else {
                $customer->update($input);
            }

            foreach ($orders as $order) {
                $orderInput['customer_id'] = $customer->id;
                $orderInput['price'] = $order['product']->price;
                $orderInput['product_id'] = $order['product']->id;
                $orderInput['quantity'] = $order['quantity'];
                Order::create($orderInput);

            }

            $success = true;
            session(['cart' => ['orders' => [], 'customer' => $customer]]);
            $cart['customer'] = $customer;

            return view('orders.checkout')->with(compact('cart', 'success'));
        }

        return view('orders.checkout')->with(compact('cart'));
    }

}
