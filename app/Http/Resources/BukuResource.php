<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Peminjaman;
use App\Models\Anggota;

class BukuResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $user = auth()->user();
        $anggota = null;

        if ($user && $user->hasRole('Siswa')) {
            $anggota = Anggota::firstOrCreate(
                ['email' => $user->email],
                [
                    'nama' => $user->name,
                    'telepon' => '-',
                ]
            );
        }

        $peminjaman = null;

        if ($anggota) {
            $peminjaman = Peminjaman::where('anggota_id', $anggota->id)
                ->where('buku_id', $this->id)
                ->latest()
                ->first();
        }

        return [
            'id' => $this->id,
            'kategori' => $this->kategori?->nama_kategori ?? 'Umum',
            'judul_buku' => $this->judul,
            'penulis' => $this->penulis,
            'tahun_terbit' => $this->tahun_terbit,
            'status_peminjaman' => $peminjaman?->status,
        ];
    }
}
