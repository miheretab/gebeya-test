<?php

namespace App\Http\Controllers;

use App\Category;
use App\Order;
use App\Product;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function home()
    {
        $cart = session('cart');

        $products = Product::whereNotNull('image')->where('quantity', '>', 0)
        ->with(['user' => function ($query) {
            $query->where('active', true);
        }])->orderBy('created_at', 'desc')->paginate(9);

        $categories = Category::where('active', true)->get();
        return view('landing')->with(compact('products', 'cart', 'categories'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $data = [];
        $user = \Auth::user();
        if($user->isImpersonating()) {
            $impersonateUser = User::find($request->session()->get('impersonate'));
            $data = ['impersonateUser' => $impersonateUser];
            $user = $impersonateUser;
        }

        if (!$user->is_admin) {
            $products = $user->products()->pluck('name', 'id');

            $orders = Order::groupBy('product_id')
                ->selectRaw('sum(quantity) as total, sum(price*quantity) as price, product_id')
                ->whereIn('product_id', array_keys($products->toArray()))
                ->get();

            $data['client'] = ['orders' => $orders, 'products' => $products];
            return view('home')->with($data);
        }

        return view('home')->with($data);
    }
}
