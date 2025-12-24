<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::latest()->paginate(10);
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimonials.create');
    }

    public function store(Request $request)
    {   
        

        $data = $request->validate([
    'name' => 'required|string|max:255',
    'title' => 'nullable|string',
    'content' => 'required',
    'avatar' => 'nullable|image'
]);

        
       if ($request->hasFile('avatar')) {
    $data['avatar'] = $request->file('avatar')
        ->store('testimonials', 'public');
}

Testimonial::create($data);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial berhasil ditambahkan.');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $data = $request->validate([
    'name' => 'required|string|max:255',
    'title' => 'nullable|string',
    'content' => 'required',
    'avatar' => 'nullable|image'
]);

         if ($request->hasFile('avatar')) {
        $data['avatar'] = $request->file('avatar')
            ->store('testimonials', 'public');
    }

    $testimonial->update($data);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial berhasil diperbarui.');
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial berhasil dihapus.');
    }
}
