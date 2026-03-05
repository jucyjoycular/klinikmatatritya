<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read.faq')->only('index');
        $this->middleware('permission:create.kategori-faq')->only(['create', 'store']);
        $this->middleware('permission:create.faq')->only(['create', 'store']);
        $this->middleware('permission:update.faq')->only(['edit', 'update']);
        $this->middleware('permission:delete.faq')->only('destroy');
    }

    public function index()
    {
        $faqs = Faq::latest()->paginate(10);
        return view('admin.faqs.index', compact('faqs'));
    }

    public function create()
    {
        $categories = \App\Models\FaqCategory::all();
        return view('admin.faqs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'faq_category_id' => 'required|exists:faq_categories,id',
        ]);

        $data = $request->all();
        // Checkbox usually sends '1' or 'on' if checked, nothing if unchecked. 
        // We'll trust the input if it's there, but default to true if not specified? 
        // Actually for a checkbox in edit it's tricky.
        // Let's assume the view handles it or we handle it here.
        // If we want it to be strictly boolean from checkbox presence:
        $data['is_active'] = $request->has('is_active');

        Faq::create($data);

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ berhasil ditambahkan.');
    }

    public function edit(Faq $faq)
    {
        $categories = \App\Models\FaqCategory::all();
        return view('admin.faqs.edit', compact('faq', 'categories'));
    }

    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'faq_category_id' => 'required|exists:faq_categories,id',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        $faq->update($data);

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ berhasil diperbarui.');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ berhasil dihapus.');
    }
}
