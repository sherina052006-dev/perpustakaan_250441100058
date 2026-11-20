<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Peminjaman;

class RiwayatPeminjamanController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $anggota = Anggota::firstOrCreate(
            ['email' => $user->email],
            [
                'nama' => $user->name,
                'telepon' => '-',
            ]
        );

        $riwayat = Peminjaman::with('buku')
            ->where('anggota_id', $anggota->id)
            ->get();

        return view('peminjaman.riwayat', compact('riwayat'));
    }
}