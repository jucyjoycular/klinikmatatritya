<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        try {
            if (\Schema::hasTable('settings')) {
                $mailSettings = \App\Models\Settings::whereIn('key', [
                    'mail_driver', 'mail_host', 'mail_port', 'mail_username', 'mail_password', 'mail_encryption', 'mail_from_address', 'mail_from_name'
                ])->pluck('value', 'key');

                if ($mailSettings->count() > 0) {
                    $config = [
                        'driver' => $mailSettings['mail_driver'] ?? env('MAIL_MAILER', 'smtp'),
                        'host' => $mailSettings['mail_host'] ?? env('MAIL_HOST', 'smtp.mailgun.org'),
                        'port' => $mailSettings['mail_port'] ?? env('MAIL_PORT', 587),
                        'username' => $mailSettings['mail_username'] ?? env('MAIL_USERNAME'),
                        'password' => $mailSettings['mail_password'] ?? env('MAIL_PASSWORD'),
                        'encryption' => $mailSettings['mail_encryption'] ?? env('MAIL_ENCRYPTION', 'tls'),
                        'from' => [
                            'address' => $mailSettings['mail_from_address'] ?? env('MAIL_FROM_ADDRESS', 'hello@example.com'),
                            'name' => $mailSettings['mail_from_name'] ?? env('MAIL_FROM_NAME', 'Example'),
                        ],
                    ];

                    config(['mail.mailers.smtp' => array_merge(config('mail.mailers.smtp'), [
                        'transport' => $config['driver'],
                        'host' => $config['host'],
                        'port' => $config['port'],
                        'username' => $config['username'],
                        'password' => $config['password'],
                        'encryption' => $config['encryption'],
                    ])]);
                    
                    config(['mail.from.address' => $config['from']['address']]);
                    config(['mail.from.name' => $config['from']['name']]);
                }

                // Share Office Settings
                $officeSettings = \App\Models\Settings::whereIn('key', [
                    'office_name', 'office_address', 'office_phone', 'office_wa', 'office_email', 'eye_anatomy_image', 'booking_link', 'help_menu_roles', 'help_menu_needs',
                    'facebook', 'instagram', 'youtube', 'tiktok'
                ])->pluck('value', 'key');

                \View::share('office_name', $officeSettings['office_name'] ?? 'Klinik Mata Tritya');
                \View::share('office_address', $officeSettings['office_address'] ?? 'Ruko Bratang Plaza, Jl. Barata Jaya No.59 Blok A3, Baratajaya, Gubeng, Surabaya, East Java 60284');
                \View::share('office_phone', $officeSettings['office_phone'] ?? '031-5022048');
                \View::share('office_wa', $officeSettings['office_wa'] ?? '0821-1211-0048');
                \View::share('office_email', $officeSettings['office_email'] ?? 'support@klinikmatatritya.co.id');
                \View::share('eye_anatomy_image', $officeSettings['eye_anatomy_image'] ?? null);
                \View::share('booking_link', $officeSettings['booking_link'] ?? 'http://tritya.id/DaftarOnline');
                \View::share('facebook', $officeSettings['facebook'] ?? 'https://facebook.com/klinikmatatrityasurabaya');
                \View::share('instagram', $officeSettings['instagram'] ?? 'https://instagram.com/klinikmatatritya.official');
                \View::share('youtube', $officeSettings['youtube'] ?? 'https://youtube.com/@klinikmatatritya');
                \View::share('tiktok', $officeSettings['tiktok'] ?? 'https://www.tiktok.com/@klinikmatatritya');
                
                $help_menu_roles = isset($officeSettings['help_menu_roles']) ? json_decode($officeSettings['help_menu_roles'], true) : ['Pasien', 'Keluarga Pasien'];
                $help_menu_needs = isset($officeSettings['help_menu_needs']) ? json_decode($officeSettings['help_menu_needs'], true) : ['Dokter', 'Layanan', 'Jadwal'];

                \View::share('help_menu_roles', $help_menu_roles);
                \View::share('help_menu_needs', $help_menu_needs);
            }
        } catch (\Exception $e) {
            // Logic to handle database connection issues usually not needed in boot unless strict
        }
    }
}