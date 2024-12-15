<?php

namespace App\Http\Controllers;

use App\Models\CategoryArticle;
use Illuminate\Http\Request;

class CategoryArticleController extends Controller
{
    public function index()
    {
        $categories = CategoryArticle::all();
        return view('backend.category-article.index', compact('categories'));
    }

    public function create()
    {
        return view('backend.category-article.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:category_article|max:255',
        ]);

        CategoryArticle::create($request->all());
        return redirect()->route('category-article.index')
            ->with('status', 'Category created successfully');
    }

    public function edit($id)
    {
        $category = CategoryArticle::findOrFail($id);
        return view('backend.category-article.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = CategoryArticle::findOrFail($id);

        $request->validate([
            'name' => 'required|max:255|unique:category_article,name,' . $id,
        ]);

        $category->update($request->all());
        return redirect()->route('category-article.index')
            ->with('status', 'Category updated successfully');
    }

    public function destroy($id)
    {
        $category = CategoryArticle::findOrFail($id);
        $category->delete();
        return redirect()->route('category-article.index')
            ->with('status', 'Category deleted successfully');
    }
}
