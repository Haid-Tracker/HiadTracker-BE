<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\CategoryArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index()
    {
        // $articles = Article::latest()->get();
        $articles = Article::latest()->with('categories')->get();
        return view('backend.articles.index', compact('articles'));
    }

    public function create()
    {
        $categories = CategoryArticle::all();
        return view('backend.articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'hero_photo' => 'nullable|image|max:2048',
            'author' => 'sometimes|max:100',
            'categories' => 'array|exists:category_article,id',
        ]);

        $data = $request->all();

        if ($request->hasFile('hero_photo')) {
            $photo = $request->file('hero_photo');
            $filename = uniqid() . '.' . $photo->getClientOriginalExtension();
            $photo->storeAs('public/assets/images/articles', $filename);
            $data['hero_photo'] = $filename;
        }

        $data['author'] = $data['author'] ?? 'Haid Tracker - Team';

        $article = Article::create($data);

        if ($request->has('categories')) {
            $article->categories()->attach($request->input('categories'));
        }

        return redirect()->route('admin.articles.index')->with('status', 'Article created successfully');
    }

    public function edit($id)
    {
        $article = Article::with('categories')->findOrFail($id);
        $categories = CategoryArticle::all();
        return view('backend.articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'hero_photo' => 'nullable|image|max:2048',
            'author' => 'sometimes|max:100',
            'categories' => 'array|exists:category_article,id',
        ]);

        $data = $request->all();

        if ($request->hasFile('hero_photo')) {
            if ($article->hero_photo) {
                Storage::delete('public/assets/images/articles/' . $article->hero_photo);
            }

            $photo = $request->file('hero_photo');
            $filename = uniqid() . '.' . $photo->getClientOriginalExtension();
            $photo->storeAs('public/assets/images/articles', $filename);
            $data['hero_photo'] = $filename;
        }

        $data['author'] = $data['author'] ?? 'Haid Tracker - Team';

        $article->update($data);

        if ($request->has('categories')) {
            $article->categories()->sync($request->input('categories'));
        }
        return redirect()->route('admin.articles.index')->with('status', 'Article updated successfully');
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);

        if ($article->hero_photo) {
            Storage::delete('public/assets/images/articles/' . $article->hero_photo);
        }

        $article->delete();
        return redirect()->route('admin.articles.index')->with('status', 'Article deleted successfully');
    }

    public function preview($id)
    {
        $article = Article::findOrFail($id);
        return view('backend.articles.preview', compact('article'));
    }
}
