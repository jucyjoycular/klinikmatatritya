<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InstagramSetting;
use Illuminate\Http\Request;

class InstagramSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read.instagram')->only('index');
        $this->middleware('permission:update.instagram')->only('update');
    }

    public function index()
    {
        $setting = InstagramSetting::first();
        if (!$setting) {
            $setting = InstagramSetting::create([
                'sort' => 'date',
                'limit' => 6
            ]);
        }
        return view('admin.instagram-settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = InstagramSetting::first();
        
        $request->validate([
            'sort' => 'required|in:date,random', // Assuming 'random' is supported by Elfsight or implied usage
            'limit' => 'required|integer|min:1|max:100',
        ]);

        $setting->update($request->all());

        return redirect()->route('admin.instagram-settings.index')->with('success', 'Pengaturan Instagram feed berhasil diperbarui.');
    }
}