<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\Promo;
use App\Traits\HandlesMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PromoController extends Controller
{
    use HandlesMedia;

    public function index()
    {
        $promos = Promo::latest()->paginate(10);
        return view('admin.promos.index', compact('promos'));
    }

    public function create()
    {
        $mediaItems = Media::all(); 
        return view('admin.promos.create', compact('mediaItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'content' => 'nullable|string',
            'price' => 'nullable|numeric',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'media_id' => 'nullable|exists:media,id',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);

        $promo = Promo::create($data);

        if ($request->filled('media_id')) {
            $media = Media::findOrFail($request->media_id);

            $this->attachExistingMedia($promo, $media->id);
            $data['image'] = $media->filepath;
            $promo->update($data);
        } elseif ( $request->hasFile('image')) {
             $imagePath = $request->file('image')->store('promos', 'public');
             $data['image'] = $imagePath;
             $promo->save();

             $this->attachMedia($promo, $request->file('image'), 'promos');
        } else {
            $promo->fill($data)->save();
        }

        return redirect()->route('admin.promos.index')->with('success', 'Promo berhasil ditambahkan.');
    }

    public function edit(Promo $promo)
    {
        $mediaItems = Media::all(); 
        return view('admin.promos.edit', compact('promo', 'mediaItems'));
    }

    public function update(Request $request, Promo $promo)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'content' => 'nullable|string',
            'price' => 'nullable|numeric',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'media_id' => 'nullable|exists:media,id',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);

        $promo = Promo::findOrFail($promo->id);

        if ($request->hasFile('image')) {
            if ($promo && Storage::disk('public')->exists($promo->image)) {
            Storage::disk('public')->delete($promo->image);

            DB::table('media_usages')->where('model_type', get_class($promo))
                ->where('model_id', $promo->id)
                ->delete();
            }
            $imagePath = $request->file('image')->store('promos', 'public');
            $data['image'] = $imagePath;
            $promo->fill($data)->save();

            $this->attachMedia($promo, $request->file('image'), 'promos');
        } elseif ($request->filled('media_id')) {
            $media = Media::find($request->media_id);
            if ($media) {
                $data['image'] = $media->file_path;
            }
        }
        $promo->update($data);
        
        return redirect()->route('admin.promos.index')->with('success', 'Promo berhasil diperbarui.');
    }

    public function destroy(Promo $promo)
    {
        $promo = Promo::findOrFail($promo->id);

            if (Storage::disk('public')->exists($promo->image)) {
                Storage::disk('public')->delete($promo->image);

                DB::table('media_usages')->where('model_type', get_class($promo))
                    ->where('model_id', $promo->id)
                    ->delete();
            }

        $promo->delete();

        return redirect()->route('admin.promos.index')->with('success', 'Promo berhasil dihapus.');
    }
}
