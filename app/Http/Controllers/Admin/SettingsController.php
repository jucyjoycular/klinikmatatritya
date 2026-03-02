<?php 
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FooterSection;
use App\Models\Media;
use App\Models\Settings;
use App\Traits\HandlesMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    use HandlesMedia;

    public function logo()
    {
        $logo = Settings::where('key', 'site_logo')->first();
        return view('admin.settings.logo', compact('logo'));
    }

     public function analytics()
    {
        return view('admin.analytics.index');
    }

    public function updateLogo(Request $request)
    {
        $request->validate(['logo' => 'required|image|max:2048']);
        $path = $request->file('logo')->store('public/logo');

        Settings::updateOrCreate(
            ['key' => 'site_logo'],
            ['value' => str_replace('public/', 'storage/', $path)]
        );

        return back()->with('success', 'Logo berhasil diperbarui!');
    }

    public function social()
    {
        $socials = Settings::whereIn('key', ['instagram', 'youtube', 'facebook', 'tiktok'])->get()->pluck('value', 'key');
        return view('admin.settings.social', compact('socials'));
    }

    public function updateSocial(Request $request)
    {
        foreach (['instagram', 'youtube', 'facebook', 'tiktok'] as $key) {
            Settings::updateOrCreate(['key' => $key], ['value' => $request->$key]);
        }

        return back()->with('success', 'Social links updated!');
    }

    public function mail()
    {
        $mail = Settings::whereIn('key', [
            'mail_driver', 'mail_host', 'mail_port', 'mail_username', 'mail_password', 'mail_encryption', 'mail_from_address', 'mail_from_name'
        ])->get()->pluck('value', 'key');
        
        return view('admin.settings.mail', compact('mail'));
    }

    public function updateMail(Request $request)
    {
        $request->validate([
            'mail_host' => 'required',
            'mail_port' => 'required',
            'mail_username' => 'required',
            'mail_password' => 'required',
            'mail_encryption' => 'nullable',
            'mail_from_address' => 'required|email',
            'mail_from_name' => 'required',
        ]);

        $keys = [
            'mail_driver', 'mail_host', 'mail_port', 'mail_username', 'mail_password', 'mail_encryption', 'mail_from_address', 'mail_from_name'
        ];

        foreach ($keys as $key) {
            Settings::updateOrCreate(
                ['key' => $key],
                ['value' => $request->$key]
            );
        }

        return back()->with('success', 'Mail settings updated successfully!');
    }
    public function general()
    {
        $settings = Settings::whereIn('key', [
            'maintenance_mode', 'website_font', 'office_name', 'office_address', 'office_phone', 'office_wa', 'office_email', 
            'eye_anatomy_image', 'booking_link', 'help_menu_roles', 'help_menu_needs',
            'about_us', 'vision', 'mission', 'motto', 'facebook', 'instagram', 'youtube', 'tiktok'
        ])->pluck('value', 'key');
        
        $maintenance_mode = $settings['maintenance_mode'] ?? 'false';
        $website_font = $settings['website_font'] ?? 'Poppins';

        $systemfonts = config('fonts.system');
        $googlefonts = config('fonts.google');
        $isGoogleFont = in_array($website_font, $googlefonts);

        $office_name = $settings['office_name'] ?? 'Klinik Mata Tritya';
        $office_address = $settings['office_address'] ?? '';
        $office_phone = $settings['office_phone'] ?? '';
        $office_wa = $settings['office_wa'] ?? '';
        $office_email = $settings['office_email'] ?? '';
        $eye_anatomy_image = $settings['eye_anatomy_image'] ?? '';
        $booking_link = $settings['booking_link'] ?? '';
        
        $facebook = $settings['facebook'] ?? 'https://facebook.com/klinikmatatrityasurabaya';
        $instagram = $settings['instagram'] ?? 'https://instagram.com/klinikmatatritya.official';
        $youtube = $settings['youtube'] ?? 'https://youtube.com/@klinikmatatritya';
        $tiktok = $settings['tiktok'] ?? 'https://www.tiktok.com/@klinikmatatritya';
        
        $about_us = $settings['about_us'] ?? '';
        $vision = $settings['vision'] ?? '';
        $mission = $settings['mission'] ?? '';
        $motto = $settings['motto'] ?? '';

        $help_menu_roles = isset($settings['help_menu_roles']) ? json_decode($settings['help_menu_roles'], true) : ['Pasien', 'Keluarga Pasien'];
        $help_menu_needs = isset($settings['help_menu_needs']) ? json_decode($settings['help_menu_needs'], true) : ['Dokter', 'Layanan', 'Jadwal'];

        // Convert arrays to newline-separated strings for textarea
        $help_menu_roles = is_array($help_menu_roles) ? implode("\n", $help_menu_roles) : $help_menu_roles;
        $help_menu_needs = is_array($help_menu_needs) ? implode("\n", $help_menu_needs) : $help_menu_needs;

        // Get media for media browser modal
        $media = Media::latest()->get();

        return view('admin.settings.general', compact(
            'maintenance_mode', 'website_font', 'office_name', 'office_address', 'office_phone', 'office_wa', 'office_email', 
            'eye_anatomy_image', 'booking_link', 'help_menu_roles', 'help_menu_needs',
            'about_us', 'vision', 'mission', 'motto', 'facebook', 'instagram', 'youtube', 'tiktok', 'media'
        ))->with('systemfonts', $systemfonts)
          ->with('googlefonts', $googlefonts)
          ->with('isGoogleFont', $isGoogleFont);
    }

    public function updateGeneral(Request $request)
    {
        // Update Maintenance Mode
        Settings::updateOrCreate(
            ['key' => 'maintenance_mode'],
            ['value' => $request->has('maintenance_mode') ? 'true' : 'false']
        );

        // Update Website Font
        $allfonts = array_merge(config('fonts.system'), config('fonts.google'));
        $request->validate([
            'website_font' => 'required|in:' . implode(',', $allfonts),
        ]);
        Settings::updateOrCreate(
            ['key' => 'website_font'],
            ['value' => $request->website_font]
        );

        // Update Office Info & Company Info
        $keys = [
            'office_name', 'office_address', 'office_phone', 'office_wa', 'office_email',
            'about_us', 'vision', 'mission', 'motto'
        ];
        
        foreach ($keys as $key) {
             Settings::updateOrCreate(
                ['key' => $key],
                ['value' => $request->$key]
            );
        }

        // Update Booking Link
        Settings::updateOrCreate(
            ['key' => 'booking_link'],
            ['value' => $request->booking_link]
        );

        // Update Social Media Links
        $socialKeys = ['facebook', 'instagram', 'youtube', 'tiktok'];
        foreach ($socialKeys as $key) {
            Settings::updateOrCreate(
                ['key' => $key],
                ['value' => $request->$key]
            );
        }

        // Update Help Menu Options (Roles)
        $roles = array_filter(array_map('trim', explode("\n", $request->help_menu_roles)));
        Settings::updateOrCreate(
            ['key' => 'help_menu_roles'],
            ['value' => json_encode(array_values($roles))]
        );

        // Update Help Menu Options (Needs)
        $needs = array_filter(array_map('trim', explode("\n", $request->help_menu_needs)));
        Settings::updateOrCreate(
            ['key' => 'help_menu_needs'],
            ['value' => json_encode(array_values($needs))]
        );

        // Upload Eye Anatomy Image
        if ($request->hasFile('eye_anatomy_image')) {

            $request->validate([
                'eye_anatomy_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $existing = Settings::where('key', 'eye_anatomy_image')->first();

            if ($existing && str_starts_with($existing->value, 'img/') && Storage::disk('public')->exists($existing->value)) {
                Storage::disk('public')->delete($existing->value);
            }

            if ($existing) {
                $existing->mediaUsage()->delete();
            }
            
            $path = $request->file('eye_anatomy_image')->store('img', 'public');

            Settings::updateOrCreate(
                ['key' => 'eye_anatomy_image'],
                ['value' => $path]
            );
        } elseif ($request->filled('eye_anatomy_media_id')) {
            $media = Media::find($request->eye_anatomy_media_id);
            if ($media) {
                $existing = Settings::where('key', 'eye_anatomy_image')->first();

                if ($existing && str_starts_with($existing->value, 'img/') && Storage::disk('public')->exists($existing->value)) {
                    Storage::disk('public')->delete($existing->value);
                }

                if ($existing) {
                    $existing->mediaUsage()->delete();
                }

                Settings::updateOrCreate(
                    ['key' => 'eye_anatomy_image'],
                    ['value' => $media->filepath]
                );

                $setting = Settings::where('key', 'eye_anatomy_image')->first();
                if ($setting) {
                    $this->attachExistingMedia($setting, $media->id);
                }
            }
        }

        return back()->with('success', 'Pengaturan umum berhasil diperbarui!');
    }

    public function footerIndex(){
        $sections = FooterSection::all();
        $media = Media::latest()->get();
        return view('admin.footer-management.footer', compact('sections', 'media'));
    }

    public function getFooterItems($id) {
        try {
            $section = FooterSection::with('items')->findOrFail($id);
            return response()->json([
                'success' => true,
                'items' => $section->items
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateFooterSection(Request $request, $id){
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'nullable|string',
                'image' => 'nullable|image|max:2048',
                'media_id' => 'nullable|exists:media,id',
                'items' => 'nullable|array',
                'items.*.pemeriksaan' => 'required|string|max:255',
                'items.*.harga_normal' => 'required|numeric|min:0',
                'items.*.harga_promo' => 'nullable|numeric|min:0',
                'items.*.keterangan' => 'nullable|string'
            ]);

            $section = FooterSection::findOrFail($id);

            if ($request->hasFile('image')) {
                if ($section->image && str_starts_with($section->image, 'footer/') && Storage::disk('public')->exists($section->image)) {
                    Storage::disk('public')->delete($section->image);
                }
                $section->mediaUsage()->delete();
                
                $imagePath = $request->file('image')->store('footer', 'public');
                $section->image = $imagePath;
                $this->attachMedia($section, $request->file('image'), 'footer');
                
            } elseif ($request->filled('media_id')) {
                $media = Media::findOrFail($request->media_id);
                
                if ($section->image && str_starts_with($section->image, 'footer/') && Storage::disk('public')->exists($section->image)) {
                    Storage::disk('public')->delete($section->image);
                }
                $section->mediaUsage()->delete();
                
                $section->image = $media->filepath;
                $this->attachExistingMedia($section, $media->id);
            }

            $section->title = $request->title;
            $section->content = $request->content;
            $section->save();

            // Handle items (update/create)
            if ($request->has('items')) {
                // Delete existing items
                $section->items()->delete();
                
                // Create new items
                foreach ($request->items as $item) {
                    if (!empty($item['pemeriksaan'])) {
                        $section->items()->create([
                            'pemeriksaan' => $item['pemeriksaan'],
                            'harga_normal' => $item['harga_normal'] ?? 0,
                            'harga_promo' => $item['harga_promo'] ?? null,
                            'keterangan' => $item['keterangan'] ?? null
                        ]);
                    }
                }
            }

            // Clear cache untuk footer section
            $cacheKeys = [
                'footer_promosi',
                'footer_csr',
                'footer_investor',
                'footer_emc',
                'footer_charities',
                'footer_privacy',
                'footer_help_center'
            ];
            
            foreach ($cacheKeys as $key) {
                Cache::forget($key);
            }

            return response()->json([
                'success' => true,
                'message' => 'Footer section berhasil diperbarui!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}