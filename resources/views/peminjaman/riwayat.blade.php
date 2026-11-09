@extends('layouts.app')

@section('judul', 'Riwayat Peminjaman')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">

    <h1 class="text-2xl font-bold text-gray-800 mb-6">
        Riwayat Peminjaman Saya
    </h1>

    <div class="bg-white rounded-xl shadow p-6 overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b bg-gray-100">
                    <th class="p-3">No</th>
                    <th class="p-3">Judul Buku</th>
                    <th class="p-3">Tanggal Pinjam</th>
                    <th class="p-3">Tanggal Kembali</th>
                    <th class="p-3">Status</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($riwayat as $item)
                    <tr class="border-b">
                        <td class="p-3">{{ $loop->iteration }}</td>
                        <td class="p-3">{{ $item->buku->judul ?? '-' }}</td>
                        <td class="p-3">{{ $item->tanggal_pinjam }}</td>
                        <td class="p-3">{{ $item->tanggal_kembali ?? '-' }}</td>
                        <td class="p-3">{{ $item->status }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-4 text-center text-gray-500">
                            Belum ada riwayat peminjaman.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection