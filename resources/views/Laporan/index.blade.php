@extends('layouts.app')

@section('judul', 'Laporan Perpustakaan')

@section('content')

<div class="min-h-screen bg-gray-50 p-6 md:p-8">

    <div class="max-w-7xl mx-auto">

        <div class="mb-10 bg-gradient-to-r from-pink-600 to-pink-400 rounded-3xl p-8 md:p-10 text-white shadow-xl shadow-pink-100">
            <span class="bg-white/20 text-white text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider">
                Laporan Aktif
            </span>

            <h1 class="text-3xl font-extrabold mt-3">
                Laporan Perpustakaan
            </h1>

            <p class="text-pink-100 mt-2">
                Ringkasan data buku dan aktivitas peminjaman perpustakaan.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-pink-100">
                <p class="text-gray-500">Total Buku</p>
                <h2 class="text-3xl font-bold text-pink-600 mt-2">
                    {{ $totalBuku }}
                </h2>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-pink-100">
                <p class="text-gray-500">Total Peminjaman</p>
                <h2 class="text-3xl font-bold text-pink-600 mt-2">
                    {{ $totalPeminjaman }}
                </h2>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-pink-100">
                <p class="text-gray-500">Menunggu Persetujuan</p>
                <h2 class="text-3xl font-bold text-yellow-500 mt-2">
                    {{ $menungguPersetujuan }}
                </h2>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-pink-100">
                <p class="text-gray-500">Sedang Dipinjam</p>
                <h2 class="text-3xl font-bold text-blue-500 mt-2">
                    {{ $sedangDipinjam }}
                </h2>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-pink-100">
                <p class="text-gray-500">Sudah Dikembalikan</p>
                <h2 class="text-3xl font-bold text-green-600 mt-2">
                    {{ $sudahDikembalikan }}
                </h2>
            </div>

        </div>

    </div>
</div>

<div class="bg-white rounded-2xl p-6 shadow-sm mt-8 overflow-x-auto">

    <h2 class="text-xl font-bold text-slate-800 mb-5">
        Daftar Seluruh Peminjaman
    </h2>

    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-pink-100 text-pink-800">
                <th class="p-3">Peminjaman</th>
                <th class="p-3">Judul Buku</th>
                <th class="p-3">Tanggal Pinjam</th>
                <th class="p-3">Tanggal Kembali</th>
                <th class="p-3">Status</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($daftarPeminjaman as $item)
                <tr class="border-b hover:bg-pink-50">
                    <td class="p-3">Peminjaman</td>
                    <td class="p-3">{{ $item->buku->judul ?? '-' }}</td>
                    <td class="p-3">{{ $item->tanggal_pinjam ?? '-' }}</td>
                    <td class="p-3">{{ $item->tanggal_kembali ?? '-' }}</td>
                    <td class="p-3">{{ $item->status }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-5 text-center text-gray-500">
                        Belum ada data peminjaman.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection