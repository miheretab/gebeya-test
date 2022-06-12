<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $data = [];
        if(\Auth::user()->isImpersonating()) {
            $impersonateUser = User::find($request->session()->get('impersonate'));
            $data = ['impersonateUser' => $impersonateUser];
        }
        return view('home')->with($data);
    }
}
