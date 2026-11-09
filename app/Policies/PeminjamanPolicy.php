<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Peminjaman;
use App\Models\Anggota;

class PeminjamanPolicy
{
    public function view(User $user, Peminjaman $peminjaman): bool
    {
        if ($user->hasAnyRole(['Admin', 'Petugas'])) {
            return true;
        }

        if ($user->hasRole('Siswa')) {
            $anggota = Anggota::where('email', $user->email)->first();

            return $anggota !== null &&
                (int) $peminjaman->anggota_id === (int) $anggota->id;
        }

        return false;
    }
}