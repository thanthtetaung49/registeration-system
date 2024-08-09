<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->paginate(20);

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

    public function edit(Category $category)
    {
        return Inertia::render('EventPage/Category/CategoryEdit', ['category' => $category]);
    }

    public function update(Category $category, Request $request)
    {
        $category->update($request->validate([
            'category_name' => ['required']
        ]));
        return to_route('category.index');
    }

    public function view(Category $category)
    {
        return Inertia::render('EventPage/Category/CategoryView', ['category' => $category]);
    }

    public function delete(Category $category)
    {
        $category->delete();
        return to_route('category.index');
    }
}
