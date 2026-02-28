<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Media;
use App\Traits\HandlesMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    use HandlesMedia;

    public function index()
    {
        $articles = Article::latest()->paginate(10);
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        $media = Media::latest()->get();
        return view('admin.articles.create', compact('media'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'published_at' => 'nullable|date',
            'media_id' => 'nullable|exists:media,id',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);

        $article = Article::create($data);
        
        // Auto generate excerpt if not provided
        if (empty($data['excerpt'])) {
            $data['excerpt'] = Str::limit(strip_tags($request->content), 150);
        }

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('articles', 'public');
            $article->image = $imagePath;
            $article->save();

            $this->attachMedia($article, $request->file('image'), 'articles');
        } elseif ($request->filled('media_id')) {
            $media = Media::findOrFail($request->media_id);
            $article->image = $media->filepath;
            $article->save();

            $this->attachExistingMedia($article, $media->id);
        }

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil ditambahkan.');
    }

    public function edit(Article $article)
    {
        $media = Media::latest()->get();
        return view('admin.articles.edit', compact('article', 'media'));
    }

    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'published_at' => 'nullable|date',
            'media_id' => 'nullable|exists:media,id',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);

        // Auto generate excerpt if not provided
        if (empty($data['excerpt'])) {
            $data['excerpt'] = Str::limit(strip_tags($request->content), 150);
        }

        if ($request->hasFile('image')) {
            if ($article->image && str_starts_with($article->image, 'articles/') && Storage::disk('public')->exists($article->image)) {
                Storage::disk('public')->delete($article->image);
            }
            $article->mediaUsage()->delete();

            $imagePath = $request->file('image')->store('articles', 'public');
            $data['image'] = $imagePath;
            $article->fill($data)->save();

            $this->attachMedia($article, $request->file('image'), 'articles');
        } elseif ($request->filled('media_id')) {
            $media = Media::findOrFail($request->media_id);

            if ($article->image && str_starts_with($article->image, 'articles/') && Storage::disk('public')->exists($article->image)) {
                Storage::disk('public')->delete($article->image);
            }
            $article->mediaUsage()->delete();

            $data['image'] = $media->filepath;
            $article->fill($data)->save();

            $this->attachExistingMedia($article, $media->id);
        } else {
            $article->update($data);
        }

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Article $article)
    {
        if ($article->image) {
            if (Storage::disk('public')->exists($article->image)) {
                Storage::disk('public')->delete($article->image);
            }

            $article->mediaUsage()->delete();
        }
        
        $article->delete();

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dihapus.');
    }
}
