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
        $clients = User::where('is_admin', false)->where('active', true)->get();
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
            $orders = Order::groupBy('product_id')
                ->selectRaw('count(*) as total, sum(price*quantity) as price, product_id')
                ->get();
            $products = $user->products()->pluck('name', 'id');
            $data['client'] = ['orders' => $orders, 'products' => $products];
            return view('home')->with($data);
        }

        return view('home')->with($data);
    }
}
