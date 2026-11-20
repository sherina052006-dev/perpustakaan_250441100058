@extends('layouts.app')

@section('judul', 'Detail Peminjaman')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">

    <div class="bg-white rounded-xl shadow p-6">

        <h1 class="text-2xl font-bold mb-6">
            Detail Peminjaman
        </h1>

        <div class="space-y-5">

            <div>
                <p class="text-gray-500">ID Peminjaman</p>
                <p class="font-semibold">{{ $peminjaman->id }}</p>
            </div>

            <div>
                <p class="text-gray-500">Nama Peminjam</p>
                <p class="font-semibold">{{ $peminjaman->anggota?->nama ?? '-' }}</p>
            </div>

            <div>
                <p class="text-gray-500">Judul Buku</p>
                <p class="font-semibold">{{ $peminjaman->buku?->judul ?? '-' }}</p>
            </div>

            <div>
                <p class="text-gray-500">Tanggal Pinjam</p>
                <p class="font-semibold">{{ $peminjaman->tanggal_pinjam }}</p>
            </div>

            <div>
                <p class="text-gray-500">Tanggal Kembali</p>
                <p class="font-semibold">{{ $peminjaman->tanggal_kembali ?? '-' }}</p>
            </div>

            <div>
                <p class="text-gray-500">Status Peminjaman</p>
                <p class="font-semibold">{{ $peminjaman->status }}</p>
            </div>

        </div>

                <a href="{{ route('peminjaman.riwayat') }}"
                    style="display: inline-block; margin-top: 24px; background-color: #EC4899; color: white; padding: 8px 16px; border-radius: 6px;">
                    Kembali ke Riwayat
            </a>

    </div>
</div>
@endsection
