<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class CategoriesController extends Controller
{
    public function index(Request $request) {
        $categories = Category::where('user_id', Auth::user()->id)->get();

        return view('categories.index')->with(compact('categories'));
    }

    public function add(Request $request) {
        if ($request->isMethod('post')) {
            $input = $request->all();

            $validator = Validator::make($input, [
                'name' => 'required'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $user = Auth::user();
            $input['user_id'] = $user->id;
            Category::create($input);
            return redirect('/categories');
        }

        return view('categories.add');
    }

    public function edit(Request $request, $id) {
        $category = Category::findOrFail($id);

        if ($category->user_id != Auth::user()->id) {
            return redirect()->back()->with(['status' => 'Unauthorized']);
        }

        if ($request->isMethod('post')) {
            $input = $request->all();

            $validator = Validator::make($input, [
                'name' => 'required'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $category->update($input);
            return redirect('/categories');
        }

        return view('categories.edit', compact('category'));
    }

    public function remove(Request $request, $id) {
        $category = Category::findOrFail($id);

        $category->products()->detach();

        $category->delete();
        return redirect('/categories');
    }

    public function switchActive(Request $request, $id) {
        $category = Category::findOrFail($id);

        if ($category->user_id != Auth::user()->id) {
            return redirect()->back()->with(['status' => 'Unauthorized']);
        }

        $category->update(['active' => !$category->active]);
        return redirect('/categories');
    }
}
