<?php
namespace Database\Seeders;

use App\Models\Service;
use App\Models\Article;
use App\Models\Doctor;
use App\Models\Schedule;
use Database\Seeders\FooterSectionSeeder;
use Database\Seeders\HeroSeeder;
use Database\Seeders\AdminUserSeeder;
use Database\Seeders\AnalyticsSeeder;
use Database\Seeders\FaqSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Run all class-based seeders
        $this->call([
            AdminUserSeeder::class,
            HeroSeeder::class,
            FooterSectionSeeder::class,
            FaqSeeder::class,
            AnalyticsSeeder::class,
        ]);

        // Run factory seeders
        Service::factory()->count(6)->create();
        Article::factory()->count(6)->create();
        Doctor::factory()->count(4)->create()->each(function ($doc) {
            Schedule::factory()->count(3)->create(['doctor_id' => $doc->id]);
        });
    }
}
