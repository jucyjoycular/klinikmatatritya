<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class UserPermissionController extends Controller
{
    public function edit(User $user)
    {
    $permissions = Permission::all();
    return view('admin.permissions.edit', compact('user', 'permissions'));
    }

    public function update(Request $request, User $user)
{
    $request->validate([
        'permissions' => 'array',
        'permissions.*' => 'exists:permissions,name', 
    ]);

    $user->syncPermissions($request->permissions ?? []);

    return redirect()
        ->route('admin.users.index')
        ->with('success', 'Hak akses berhasil diperbarui');
}
}
