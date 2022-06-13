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
        $orders = Order::whereIn('product_id', $productIds)->get();

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
        $product = Product::findOrFail($id);

        $cart = session('cart', ['orders' => [], 'customer' => null]);
        $orders = $cart['orders'];
        $customer = isset($cart['customer']) ? $cart['customer'] : null;
        $quantity = $request->input('quantity');

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

        if ($categoryId) {
            return redirect('/store/'.$product->user_id.'/'.$categoryId)->with(compact('status'));
        } else {
            return redirect('/store/'.$product->user_id)->with(compact('status'));
        }
    }

    public function updateToCart(Request $request, $id) {
        $product = Product::findOrFail($id);

        $cart = session('cart');
        $orders = $cart['orders'];
        $customer = isset($cart['customer']) ? $cart['customer'] : null;
        $quantity = $request->input('quantity');

        $diffQuantity = $quantity - $orders[$id]['quantity'];
        if ($diffQuantity == 0) {
            return redirect('/orders')->with(compact('cart'));
        }

        if ($product->quantity > 0 && $product->quantity >= $diffQuantity) {
            $product->quantity = $product->quantity - $diffQuantity;
            $product->save();
            $status = "Cart updated successfully";
        } else if ($product->quantity > 0) {
            $product->quantity = 0;
            $product->save();
            $status = "You got last ones and cart updated successfully";
        } else {
            $status = "Sold out";
        }

        $orders[$id]['quantity'] = $quantity;

        session(['cart' => compact('orders', 'customer')]);
        $cart['orders'] = $orders;

        return redirect('/orders')->with(compact('cart', 'status'));
    }

    public function removeFromCart(Request $request, $id, $categoryId = null) {
        $product = Product::findOrFail($id);

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

        if ($categoryId) {
            return redirect('/store/'.$product->user_id.'/'.$categoryId)->with(compact('status'));
        } else {
            return redirect('/store/'.$product->user_id)->with(compact('status'));
        }
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

            return view('orders.checkout')->with(compact('cart', 'success'));
        }

        return view('orders.checkout')->with(compact('cart'));
    }
}
