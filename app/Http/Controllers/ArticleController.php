<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->get();
        return view('backend.articles.index', compact('articles'));
    }

    public function create()
    {
        return view('backend.articles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'hero_photo' => 'nullable|image|max:2048',
            'author' => 'sometimes|max:100'
        ]);

        $data = $request->all();

        if ($request->hasFile('hero_photo')) {
            $photo = $request->file('hero_photo');
            $filename = uniqid() . '.' . $photo->getClientOriginalExtension();
            $photo->storeAs('public/assets/images/articles', $filename);
            $data['hero_photo'] = $filename;
        }

        $data['author'] = $data['author'] ?? 'Haid Tracker - Team';

        Article::create($data);
        return redirect()->route('articles.index')->with('status', 'Article created successfully');
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);
        return view('backend.articles.edit', compact('article'));
    }

    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'hero_photo' => 'nullable|image|max:2048',
            'author' => 'sometimes|max:100'
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
        return redirect()->route('articles.index')->with('status', 'Article updated successfully');
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);

        if ($article->hero_photo) {
            Storage::delete('public/assets/images/articles/' . $article->hero_photo);
        }

        $article->delete();
        return redirect()->route('articles.index')->with('status', 'Article deleted successfully');
    }

    public function preview($id)
    {
        $article = Article::findOrFail($id);
        return view('backend.articles.preview', compact('article'));
    }
}
