<?php

namespace Database\Seeders;

// use Google\Rpc\Context\AttributeContext\Peer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
        /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'create.user']);
        Permission::create(['name' => 'read.user']);
        Permission::create(['name' => 'update.user']);
        Permission::create(['name' => 'hakAkses.user']);
        Permission::create(['name' => 'delete.user']);

        Permission::create(['name' => 'read.hero']);
        Permission::create(['name' => 'update.hero']);

        Permission::create(['name' => 'read.popup']);
        Permission::create(['name' => 'update.popup']);

        Permission::create(['name' => 'create.doctor']);
        Permission::create(['name' => 'read.doctor']);
        Permission::create(['name' => 'update.doctor']);
        Permission::create(['name' => 'delete.doctor']);

        Permission::create(['name' => 'read.media']);
        Permission::create(['name' => 'delete.media']);
        Permission::create(['name' => 'preview.media']);

        Permission::create(['name' => 'create.layanan']);
        Permission::create(['name' => 'read.layanan']);
        Permission::create(['name' => 'update.layanan']);
        Permission::create(['name' => 'delete.layanan']);

        Permission::create(['name' => 'create.kategori-faq']);
        
        Permission::create(['name' => 'create.faq']);
        Permission::create(['name' => 'read.faq']);
        Permission::create(['name' => 'update.faq']);
        Permission::create(['name' => 'delete.faq']);

        Permission::create(['name' => 'create.promo']);
        Permission::create(['name' => 'read.promo']);
        Permission::create(['name' => 'update.promo']);
        Permission::create(['name' => 'delete.promo']);

        Permission::create(['name' => 'read.review']);
        Permission::create(['name' => 'update.review']);

        Permission::create(['name' => 'create.asuransi']);
        Permission::create(['name' => 'read.asuransi']);
        Permission::create(['name' => 'update.asuransi']);
        Permission::create(['name' => 'delete.asuransi']);

        Permission::create(['name' => 'create.spesialisasi']);
        Permission::create(['name' => 'read.spesialisasi']);
        Permission::create(['name' => 'update.spesialisasi']);
        Permission::create(['name' => 'delete.spesialisasi']);

        Permission::create(['name' => 'read.instagram']);
        Permission::create(['name' => 'update.instagram']);

        Permission::create(['name' => 'create.artikel']);
        Permission::create(['name' => 'read.artikel']);
        Permission::create(['name' => 'update.artikel']);
        Permission::create(['name' => 'delete.artikel']);

        Permission::create(['name' => 'create.karir']);
        Permission::create(['name' => 'read.karir']);
        Permission::create(['name' => 'update.karir']);
        Permission::create(['name' => 'delete.karir']);

        Permission::create(['name' => 'read.lamaran']);
        Permission::create(['name' => 'delete.lamaran']);

        Permission::create(['name' => 'read.analytics']);
        Permission::create(['name' => 'export.analytics']);

        Permission::create(['name' => 'read.mail']);
        Permission::create(['name' => 'update.mail']);

        Permission::create(['name' => 'read.setting']);
        Permission::create(['name' => 'update.setting']);

        Permission::create(['name' => 'read.footer']);
        Permission::create(['name' => 'preview.footer']);
        Permission::create(['name' => 'update.footer']);
    }
}
