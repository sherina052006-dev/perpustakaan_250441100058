<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        $roles = Role::all();

        return view('admin.users', compact('users', 'roles'));
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        $user->syncRoles($request->role);

        if ($request->role === 'Siswa') {
            \App\Models\Anggota::firstOrCreate(
                ['email' => $user->email],
                [
                    'nama' => $user->name,
                    'telepon' => '-',
                ]
            );
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Role pengguna berhasil diperbarui.');
    }
}
