<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
// use App\Models\Peminjaman;
// use App\Policies\PeminjamanPolicy;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Gate untuk mengelola data buku
        Gate::define('kelola-buku', function ($user) {
            return $user->hasAnyRole(['Admin', 'Petugas']);
        });

        // Policy untuk akses detail peminjaman
        // Gate::policy(Peminjaman::class, PeminjamanPolicy::class);
    }
}
