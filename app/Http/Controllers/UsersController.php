<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class UsersController extends Controller
{
    public function index(Request $request) {
        $users = User::where('is_admin', true)->get();

        return view('users.index')->with(compact('users'));
    }

    public function add(Request $request) {
        if ($request->isMethod('post')) {
            $input = $request->all();

            $validator = Validator::make($input, [
                'email' => 'required|unique:users',
                'name' => 'required',
                'password' => 'required|same:password_confirmation'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $input['is_admin'] = true;
            User::create($input);
            return redirect('/users');
        }

        return view('users.add');
    }

    public function edit(Request $request, $id = null) {
        $user = Auth::user();
        if ($id) {
            $user = User::findOrFail($id);
        }

        if ($request->isMethod('post')) {
            $input = $request->all();

            //check if admin or not
            if (!Auth::user()->is_admin && Auth::user()->id != $id) {
                return redirect('/profile-edit');
            }

            if (empty($input['password'])) {
                unset($input['password']);
            }

            $validation = [
                'email' => 'required|unique:users',
                'name' => 'required',
                'password' => 'same:password_confirmation'
            ];

            //if email doesn't change
            if ($user && $user->email == $input['email']) {
                $validation = ['email' => 'required'];
            }

            $validator = Validator::make($input, $validation);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $user->update($input);
            if (!Auth::user()->is_admin) {
                return redirect('/profile');
            } else {
                return redirect('/users');
            }
        }

        return view('users.edit', compact('user'));
    }

    public function clients(Request $request) {
        $users = User::where('is_admin', false)->get();

        return view('users.clients')->with(compact('users'));
    }

    public function switchActive(Request $request, $id) {
        $user = User::findOrFail($id);
        $user->active = !$user->active;
        $user->save();
        return redirect('/clients');
    }

    public function remove(Request $request, $id) {
        $user = User::findOrFail($id);

        $user->categories()->each(function($category) {
            $category->products()->detach();
        });

        $user->categories()->delete();
        $user->products()->delete();
        $user->delete();
        return redirect('/clients');
    }

    public function profile(Request $request) {
        $user = Auth::user();

        return view('users.profile')->with(compact('user'));
    }

    public function impersonate(Request $request, $id) {
        $user = User::find($id);

        $status = '';
        // Guard against self impersonate
        if($user->id != Auth::user()->id) {
            Auth::user()->setImpersonating($user->id);
            return redirect('/home');
        } else {
            $status = 'Impersonate disabled for this user.';
        }

        return redirect()->back()->with(compact('status'));
    }

    public function stopImpersonate(Request $request) {
        Auth::user()->stopImpersonating();

        $status = 'Welcome back!';

        return redirect('clients')->with(compact('status'));
    }
}
