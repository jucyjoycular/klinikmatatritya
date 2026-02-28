<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Insurance;
use App\Models\Media;
use App\Traits\HandlesMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InsuranceController extends Controller
{
    use HandlesMedia;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $insurances = Insurance::latest()->paginate(10);
        return view('admin.insurances.index', compact('insurances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $media = Media::latest()->get();
        return view('admin.insurances.create', compact('media'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'logo' => 'required_without:media_id|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'nullable|string|max:255',
            'media_id' => 'required_without:logo|nullable|exists:media,id',
        ]);

        $data = $request->only('name');

        if ($request->hasFile('logo')) {
            $imagePath = $request->file('logo')->store('insurances', 'public');
            $data['logo'] = $imagePath;
            $insurance = Insurance::create($data);
            $this->attachMedia($insurance, $request->file('logo'));
        } elseif ($request->filled('media_id')) {
            $media = Media::findOrFail($request->media_id);

            $data['logo'] = $media->filepath;
            $insurance = Insurance::create($data);
            $this->attachExistingMedia($insurance, $media->id);
        } else {
            return back()->withErrors(['logo' => 'Logo wajib diisi, upload file atau pilih dari media library.'])->withInput();
        }
        
        return redirect()->route('admin.insurances.index')->with('success', 'Insurance partner created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Insurance $insurance)
    {
        $media = Media::latest()->get();
        return view('admin.insurances.edit', compact('insurance', 'media'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Insurance $insurance)
    {
        $request->validate([
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'nullable|string|max:255',
            'media_id' => 'nullable|exists:media,id',
        ]);

        $data = $request->only('name');

        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($insurance->logo && Storage::disk('public')->exists($insurance->logo)) {
                Storage::disk('public')->delete($insurance->logo);
                $insurance->mediaUsage()->delete(); 
            }
            
            // Upload new logo
            $imagePath = $request->file('logo')->store('insurances', 'public');
            $data['logo'] = $imagePath;
            $insurance->fill($data)->save();
            $this->attachMedia($insurance, $request->file('logo'));
            
        } elseif ($request->filled('media_id')) {
            // Delete old logo
            if ($insurance->logo && Storage::disk('public')->exists($insurance->logo)) {
                Storage::disk('public')->delete($insurance->logo);
                $insurance->mediaUsage()->delete(); 
            }
            
            // Use media from library
            $media = Media::findOrFail($request->media_id);
            $data['logo'] = $media->filepath;
            $insurance->fill($data)->save();
            $this->attachExistingMedia($insurance, $media->id);
            
        } else {
            // Only update name (no logo change)
            $insurance->fill($data)->save();
        }

        return redirect()->route('admin.insurances.index')->with('success', 'Insurance partner updated successfully.');
    }

    public function destroy(Insurance $insurance)
    {
        if ($insurance->logo && Storage::disk('public')->exists($insurance->logo)) {
            Storage::disk('public')->delete($insurance->logo);

            $insurance->mediaUsage()->delete();
        }
        $insurance->delete();

        return redirect()->route('admin.insurances.index')->with('success', 'Insurance partner deleted successfully.');
    }
}