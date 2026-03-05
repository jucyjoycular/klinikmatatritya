<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        $user = User::updateOrCreate(
            ['email' => 'admin@tritya.com'],
            [
                'name' => 'Admin Tritya',
                'password' => Hash::make('password'),
            ]
        );
        
        $permissions = Permission::whereIn('name', [
            'create.user',
            'read.user',
            'hakAkses.user',
            'update.user',
            'delete.user'
        ])->get();

        $user->syncPermissions($permissions);
}
}
