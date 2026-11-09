<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Peminjaman;

class RiwayatPeminjamanController extends Controller
{
    public function index()
    {
        $anggota = Anggota::where('email', auth()->user()->email)->first();

        if (!$anggota) {
            abort(403, 'Data anggota tidak ditemukan.');
        }

        $riwayat = Peminjaman::with('buku')
            ->where('anggota_id', $anggota->id)
            ->get();

        return view('peminjaman.riwayat', compact('riwayat'));
    }
}