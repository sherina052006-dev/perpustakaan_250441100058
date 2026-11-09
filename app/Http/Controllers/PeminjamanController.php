<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Peminjaman;
use App\Models\Buku;
use Illuminate\Support\Facades\Gate;

class PeminjamanController extends Controller
{
    public function ajukan($buku_id)
    {
        $anggota = Anggota::where(
            'email',
            auth()->user()->email
        )->first();

        if (!$anggota) {
            abort(403, 'Data anggota tidak ditemukan.');
        }

        $buku = Buku::findOrFail($buku_id);

        Peminjaman::create([
            'anggota_id' => $anggota->id,
            'buku_id' => $buku->id,
            'tanggal_pinjam' => now()->toDateString(),
            'tanggal_kembali' => null,
            'status' => 'Menunggu Persetujuan',
        ]);

        return back()->with(
            'success',
            'Pengajuan peminjaman berhasil dikirim.'
        );
    }

    public function index()
    {
        $pengajuan = Peminjaman::with(['anggota', 'buku'])
            ->where('status', 'Menunggu Persetujuan')
            ->get();

        $dipinjam = Peminjaman::with(['anggota', 'buku'])
            ->where('status', 'Dipinjam')
            ->get();

        return view('peminjaman.index', compact(
            'pengajuan',
            'dipinjam'
        ));
    }

    public function setujui($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'Menunggu Persetujuan') {
            return back()->with('error', 'Pengajuan sudah diproses.');
        }

        $peminjaman->update([
            'status' => 'Dipinjam',
            'tanggal_kembali' => now()->addDays(7)->toDateString(),
        ]);

        return back()->with(
            'success',
            'Pengajuan peminjaman berhasil disetujui.'
        );
    }

    public function kembalikan($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'Dipinjam') {
            return back()->with(
                'error',
                'Buku tidak dalam status dipinjam.'
            );
        }

        $peminjaman->update([
            'status' => 'Dikembalikan',
        ]);

        return back()->with(
            'success',
            'Buku berhasil dikembalikan.'
        );
    }

    public function show($id)
    {
    $peminjaman = Peminjaman::with(['anggota', 'buku'])->findOrFail($id);

    Gate::authorize('view', $peminjaman);

    return view('peminjaman.detail', compact('peminjaman'));
    }
}
