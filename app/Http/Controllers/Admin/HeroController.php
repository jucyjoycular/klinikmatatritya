<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hero;
use App\Models\Media;
use App\Traits\HandlesMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class HeroController extends Controller
{
    use HandlesMedia;

    public function edit()
    {
        $hero = Hero::first();
        $mediaItems = Media::latest()->get();
        return view('admin.hero.edit', compact('hero', 'mediaItems'));
    }

    public function update(Request $request, Hero $hero)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'button_text' => 'nullable',
            'button_link' => 'nullable',
            'background' => 'nullable|image|mimes:jpg,png,webp',
            'media_id' => 'nullable|exists:media,id'
        ]);

        $hero = Hero::findorFail($hero->id);

        if ($request->filled('media_id')) {

            $media = Media::findOrFail($request->media_id);

            $this->attachExistingMedia($hero, $media->id);

            $data['background'] = $media->filepath;
            $hero->update($data);
        } elseif ($request->hasFile('background')) {
            if ($hero && Storage::disk('public')->exists($hero->background)) {
                Storage::disk('public')->delete($hero->background);

                DB::table('media_usages')->where('model_type', get_class($hero))
                        ->where('model_id', $hero->id)
                        ->delete();
            }
            $imagePath = $request->file('background')->store('hero', 'public');
            $data['background'] = $imagePath;
            $hero->fill($data)->save();

            $this->attachMedia($hero, $request->file('background'));
        } else {
            $hero->update($data);
        }

        return back()->with('success', 'Hero berhasil diupdate');
    }
}