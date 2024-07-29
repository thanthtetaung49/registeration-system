<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index () {
        $categories = Category::orderBy('id', 'desc')->paginate(5);

        return Inertia::render('EventPage/Category/Category', ['categories' => $categories]);
    }

    // submit category
    public function submitCategory(Request $request)
    {
        Category::create($request->validate([
            'category_name' => ['required']
        ]));

        return to_route('category.index');
    }
}
