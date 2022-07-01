<?php

namespace App\Http\Controllers;

use App\Order;
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
        $clients = User::where('is_admin', false)->where('active', true)->paginate(10);
        return view('landing')->with(compact('clients'));
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
        if(\Auth::user()->isImpersonating()) {
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
