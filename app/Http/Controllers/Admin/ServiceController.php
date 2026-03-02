<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\Service;
use App\Traits\HandlesMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    use HandlesMedia;

    public function index()
    {
        $services = Service::latest()->paginate(10);
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        $mediaItems = Media::latest()->get();
        return view('admin.services.create', compact('mediaItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'excerpt' => 'nullable|string',
            'content' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);

        $service = Service::create($data);

        if ($request->filled('media_id')) {
            $media = Media::findOrFail($request->media_id);
            
            $this->attachExistingMedia($service, $media->id);
            $data['image'] = $media->filepath;
            $service->update($data);
        } elseif ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('services', 'public');
            $data['image'] = $imagePath;
            $service->fill($data)->save();

            $this->attachMedia($service, $request->file('image'));
        } else {
            $service->fill($data)->save();
        }

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function edit(Service $service)
    {
        $mediaItems = Media::latest()->get();
        return view('admin.services.edit', compact('service', 'mediaItems'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'excerpt' => 'nullable|string',
            'content' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);

        if ($request->filled('media_id')) {

            $media = Media::findOrFail($request->media_id);

            $this->attachExistingMedia($service, $media->id);

            $data['image'] = $media->filepath;
            $service->update($data);
        } elseif ($request->hasFile('image')) {
            if ($service && Storage::disk('public')->exists($service->image)) {
                Storage::disk('public')->delete($service->image);

                $service->mediaUsage()->delete();
            }
            $imagePath = $request->file('image')->store('services', 'public');
            $data['image'] = $imagePath;
            $service->fill($data)->save();

            $this->attachMedia($service, $request->file('image'));
        } else {
            $service->update ($data);
        }

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy(Service $service)
    {
        if ($service->image && Storage::disk('public')->exists($service->image)) {
            Storage::disk('public')->delete($service->image);

            $service->mediaUsage()->delete();
        }
        
        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil dihapus.');
    }
}
