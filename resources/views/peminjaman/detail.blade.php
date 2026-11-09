@extends('layouts.app')

@section('judul', 'Detail Peminjaman')

@section('content')
<div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow p-6">

        <h1 class="text-2xl font-bold text-pink-600 mb-6">
            Detail Peminjaman
        </h1>

        <div class="space-y-4">

            <div>
                <p class="text-gray-500">Nama Anggota</p>
                <p class="font-semibold">
                    {{ $peminjaman->anggota->nama }}
                </p>
            </div>

            <div>
                <p class="text-gray-500">Judul Buku</p>
                <p class="font-semibold">
                    {{ $peminjaman->buku->judul }}
                </p>
            </div>

            <div>
                <p class="text-gray-500">Tanggal Pinjam</p>
                <p class="font-semibold">
                    {{ $peminjaman->tanggal_pinjam }}
                </p>
            </div>

            <div>
                <p class="text-gray-500">Tanggal Kembali</p>
                <p class="font-semibold">
                    {{ $peminjaman->tanggal_kembali ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-gray-500">Status Peminjaman</p>
                <p class="font-semibold">
                    {{ $peminjaman->status }}
                </p>
            </div>

        </div>

        <a href="{{ url('/riwayat-peminjaman') }}"
           class="inline-block mt-6 bg-pink-600 text-white px-5 py-2 rounded-lg">
            Kembali
        </a>

    </div>
</div>
@endsection
