<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\PopupSetting;
use App\Traits\HandlesMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class PopupSettingController extends Controller
{
    use HandlesMedia;

    public function edit()
{
    $popup = PopupSetting::firstOrCreate(['id' => 1]);
    $mediaItems = Media::latest()->get();
    return view('admin.popup.edit', compact('popup', 'mediaItems'));
}

public function update(Request $request)
{

    $request->validate([
        'image' => 'nullable|image',
        'is_active' => 'nullable|boolean',
        'media_id' => 'nullable|exists:media,id'
    ]);

    $data = $request->all();
    $data['is_active'] = $request->has('is_active');

    $popup = PopupSetting::firstOrCreate(['id' => 1]);

    if ($request->filled('media_id')) {

        $media = Media::findOrFail($request->media_id);

        $this->attachExistingMedia($popup, $media->id);

        $data['image'] = $media->filepath;
        $popup->update($data);
    } elseif ($request->hasFile('image')) {
        if ($popup->image && Storage::disk('public')->exists($popup->image)) {
            Storage::disk('public')->delete($popup->image);

            $popup->mediaUsages()->delete();
        }
        $imagePath = $request->file('image')->store('popup', 'public');
        $data['image'] = $imagePath;
        $popup->fill($data)->save();

        $this->attachMedia($popup, $request->file('image'), 'popup');
    } else {
        $popup->update($data);
    }

    return back()->with('success', 'Popup berhasil diperbarui');
    
    }
}