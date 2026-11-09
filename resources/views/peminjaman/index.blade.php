@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Daftar Pengajuan Peminjaman</h1>

    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-pink-100">
                <tr>
                    <th class="p-3">Nama Siswa</th>
                    <th class="p-3">Judul Buku</th>
                    <th class="p-3">Tanggal Pengajuan</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($pengajuan as $item)
                    <tr class="border-b">
                        <td class="p-3">{{ $item->anggota->nama }}</td>
                        <td class="p-3">{{ $item->buku->judul }}</td>
                        <td class="p-3">{{ $item->tanggal_pinjam }}</td>
                        <td class="p-3">{{ $item->status }}</td>
                        <td class="p-3">
                            <form action="{{ route('peminjaman.setujui', $item->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="bg-pink-600 hover:bg-pink-700 text-white px-3 py-2 rounded">
                                    Setujui
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-4 text-center text-gray-500">
                            Belum ada pengajuan peminjaman.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
<div class="mt-10">
    <h2 class="text-2xl font-bold mb-6">
        Daftar Buku yang Sedang Dipinjam
    </h2>

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-pink-100">
                <tr>
                    <th class="p-3">Nama Siswa</th>
                    <th class="p-3">Judul Buku</th>
                    <th class="p-3">Tanggal Pinjam</th>
                    <th class="p-3">Batas Pengembalian</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($dipinjam as $item)
                    <tr class="border-b">
                        <td class="p-3">{{ $item->anggota->nama }}</td>
                        <td class="p-3">{{ $item->buku->judul }}</td>
                        <td class="p-3">{{ $item->tanggal_pinjam }}</td>
                        <td class="p-3">{{ $item->tanggal_kembali ?? '-' }}</td>
                        <td class="p-3">{{ $item->status }}</td>
                        <td class="p-3">
                            <form action="{{ route('peminjaman.kembalikan', $item->id) }}" method="POST">
                                @csrf
                                @method('PATCH')

                                <button type="submit"
                                    onclick="return confirm('Apakah buku ini sudah dikembalikan?')"
                                    class="bg-pink-600 hover:bg-pink-700 text-white px-3 py-2 rounded">
                                    Tandai Dikembalikan
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-4 text-center text-gray-500">
                            Belum ada buku yang sedang dipinjam.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</div>
@endsection
