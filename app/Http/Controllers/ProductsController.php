<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class ProductsController extends Controller
{
    public function index(Request $request) {
        $products = Product::where('user_id', Auth::user()->id)->get();

        return view('products.index')->with(compact('products'));
    }

    public function store(Request $request, $clientId) {
        $client = User::findOrFail($clientId);
        if ($client->is_admin || !$client->active) {
            return redirect('/');
        }

        $cart = session('cart');
        $products = Product::where('user_id', $clientId)->orderBy('created_at', 'desc')->get();

        return view('products.store')->with(compact('products', 'client', 'cart'));
    }

    public function storeByCategory(Request $request, $clientId, $categoryId) {
        $category = Category::findOrFail($categoryId);
        $client = User::findOrFail($clientId);
        if ($client->is_admin) {
            return redirect('/');
        }

        $cart = session('cart');
        $products = $category->products()->orderBy('created_at', 'desc')->get();

        return view('products.store')->with(compact('products', 'client', 'category', 'cart'));
    }

    public function add(Request $request) {
        if ($request->isMethod('post')) {
            $input = $request->all();

            $validation = [
                'name' => 'required',
                'price' => 'required|numeric',
                'quantity' => 'required|numeric',
            ];

            $validator = Validator::make($input, $validation);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $user = Auth::user();
            $input['user_id'] = $user->id;
            Product::create($input);
            return redirect('/products');
        }

        return view('products.add');
    }

    public function edit(Request $request, $id = null) {
        $product = Product::findOrFail($id);

        if ($product->user_id != Auth::user()->id) {
            return redirect()->back()->with(['status' => 'Unauthorized']);
        }

        if ($request->isMethod('post')) {
            $input = $request->all();

            $validation = [
                'name' => 'required',
                'price' => 'required|numeric',
                'quantity' => 'required|numeric',
            ];

            $validator = Validator::make($input, $validation);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $product->update($input);

            return redirect('/products');
        }

        return view('products.edit', compact('product'));
    }

    public function assign(Request $request, $id) {
        $product = Product::findOrFail($id);
        $categories = Category::where('user_id', Auth::user()->id)->get();
        $assignedIds = $product->categories()->pluck('category_id')->toArray();

        if ($request->isMethod('post')) {
            $input = $request->all();
            $product->categories()->detach();
            foreach ($input['categories'] as $categoryId) {
                $product->categories()->attach($categoryId);
            }

            return redirect('/products');
        }

        return view('products.assign', compact('product', 'categories', 'assignedIds'));
    }

    public function remove(Request $request, $id) {
        $product = Product::findOrFail($id);

        $product->categories()->detach();

        $product->delete();
        return redirect('/products');
    }

}
