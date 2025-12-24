<?php
use App\Http\Controllers\Controller;

use App\Models\PopupSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class PopupSettingController extends Controller
{
    public function edit()
{
    $popup = PopupSetting::firstOrCreate(['id' => 1]);
    return view('admin.popup.edit', compact('popup'));
}

public function update(Request $request)
{
    $popup = PopupSetting::firstOrCreate(['id' => 1]);

    $data = $request->validate([
        'image' => 'nullable|image',
        'is_active' => 'nullable|boolean',
    ]);

    $data['is_active'] = $request->has('is_active');

    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')
            ->store('popup', 'public');
    }

    $popup->update($data);

    return back()->with('success', 'Popup berhasil diperbarui');
}

}

