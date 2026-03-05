<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReviewSetting;
use Illuminate\Http\Request;

class ReviewSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read.review')->only('index');
        $this->middleware('permission:update.review')->only('update');
    }

    public function index()
    {
        $setting = ReviewSetting::first();
        if (!$setting) {
            $setting = ReviewSetting::create([
                'sort_order' => 'date',
                'limit' => 10,
                'min_rating' => 5
            ]);
        }
        return view('admin.review-settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = ReviewSetting::first();
        
        $request->validate([
            'sort_order' => 'required|in:date,random',
            'limit' => 'required|integer|min:1|max:100',
            'min_rating' => 'required|integer|min:1|max:5',
        ]);

        $setting->update($request->all());

        return redirect()->route('admin.review-settings.index')->with('success', 'Pengaturan review berhasil diperbarui.');
    }
}
