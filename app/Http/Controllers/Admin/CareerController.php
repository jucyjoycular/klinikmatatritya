<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Career;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CareerController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read.career')->only('index');
        $this->middleware('permission:create.career')->only(['create', 'store']);
        $this->middleware('permission:update.career')->only(['edit', 'update']);
        $this->middleware('permission:delete.career')->only('destroy');
    }

    public function index()
    {
        $careers = Career::latest()->paginate(10);
        return view('admin.careers.index', compact('careers'));
    }

    public function create()
    {
        return view('admin.careers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'required',
            'short_description' => 'required|string',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title) . '-' . Str::random(5); // Ensure uniqueness

        // Handle checkbox
        $data['is_active'] = $request->has('is_active');

        Career::create($data);

        return redirect()->route('admin.careers.index')->with('success', 'Karir berhasil ditambahkan.');
    }

    public function edit(Career $career)
    {
        return view('admin.careers.edit', compact('career'));
    }

    public function update(Request $request, Career $career)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'required',
            'short_description' => 'required|string',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        // Don't update slug to preserve SEO or update if needed. Let's keep it simple.
        
        $data['is_active'] = $request->has('is_active');

        $career->update($data);

        return redirect()->route('admin.careers.index')->with('success', 'Karir berhasil diperbarui.');
    }

    public function destroy(Career $career)
    {
        $career->delete();
        return redirect()->route('admin.careers.index')->with('success', 'Karir berhasil dihapus.');
    }
}
