<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;

class LaporanController extends Controller
{
    public function index()
    {
        $totalBuku = Buku::count();
        $totalPeminjaman = Peminjaman::count();

        $menungguPersetujuan = Peminjaman::where(
            'status', 'Menunggu Persetujuan'
        )->count();

        $sedangDipinjam = Peminjaman::where(
            'status', 'Dipinjam'
        )->count();

        $sudahDikembalikan = Peminjaman::where(
            'status', 'Dikembalikan'
        )->count();

        $daftarPeminjaman = Peminjaman::with(
            ['anggota', 'buku'])
            ->latest()
            ->get();

       return view('laporan.index', compact(
            'totalBuku',
            'totalPeminjaman',
            'menungguPersetujuan',
            'sedangDipinjam',
            'sudahDikembalikan',
             'daftarPeminjaman'
        ));
    }
}
