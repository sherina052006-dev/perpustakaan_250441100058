@extends('layouts.app')

@section('title', 'Kelola Pengguna')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">
        Kelola Pengguna
    </h1>

    <div class="bg-white rounded-xl shadow overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-pink-100">
                <tr>
                    <th class="p-4">No</th>
                    <th class="p-4">Nama</th>
                    <th class="p-4">Email</th>
                    <th class="p-4">Role</th>
                    <th class="p-4">Aksi</th>
                </tr>
            </thead>

            <tbody>
                 @forelse ($users as $user)
                    <tr class="border-b">
                        <td class="p-4">{{ $loop->iteration }}</td>
                        <td class="p-4">{{ $user->name }}</td>
                        <td class="p-4">{{ $user->email }}</td>
                        <td class="p-4">
                            {{ $user->getRoleNames()->join(', ') ?: 'Belum memiliki role' }}
                        </td>
                        
                        <td class="p-4">
                            <form action="{{ route('admin.users.updateRole', $user->id) }}"
                                method="POST"
                                class="flex flex-col gap-2 items-start">

                            @csrf
                            @method('PATCH')

        <select name="role" class="border rounded p-2 w-full">
            @foreach ($roles as $role)
                <option value="{{ $role->name }}"
                    @selected($user->hasRole($role->name))>
                    {{ $role->name }}
                </option>
            @endforeach
        </select>

        <button type="submit"
            style="display: block; background-color: #ec4899; color: white; padding: 10px 20px; border-radius: 8px; margin-top: 10px;">
                Simpan
        </button>
    </form>
</td>
        </tr>
    @empty
        <tr>
            <td colspan="5" class="p-4 text-center">
                Belum ada pengguna.
            </td>
        </tr>
    @endforelse
</tbody>
        </table>
    </div>
</div>
@endsection
