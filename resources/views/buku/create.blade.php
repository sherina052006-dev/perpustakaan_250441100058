@extends('layouts.app')

@section('judul', 'Tambah Buku - Perpustakaan')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-slate-800">Tambah Buku Baru</h1>
            <p class="text-slate-500 text-sm mt-1">Masukkan data buku yang ingin ditambahkan ke katalog perpustakaan.</p>
        </div>

        @if (isset($errors) && $errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('buku.store') }}" class="space-y-4">
            @csrf

            <div>
                <label for="kategori_id" class="block mb-2 font-medium text-slate-700">Kategori</label>
                <select id="kategori_id" name="kategori_id" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-pink-500" required>
                    <option value="">Pilih Kategori</option>
                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="judul" class="block mb-2 font-medium text-slate-700">Judul Buku</label>
                <input type="text" id="judul" name="judul" value="{{ old('judul') }}"
                    class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-pink-500"
                    minlength="3" maxlength="150" required placeholder="Masukkan judul buku">
            </div>

            <div>
                <label for="penulis" class="block mb-2 font-medium text-slate-700">Penulis</label>
                <input type="text" id="penulis" name="penulis" value="{{ old('penulis') }}"
                    class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-pink-500"
                    minlength="3" maxlength="100" required placeholder="Nama penulis buku">
            </div>

            <div>
                <label for="tahun_terbit" class="block mb-2 font-medium text-slate-700">Tahun Terbit</label>
                <input type="number" id="tahun_terbit" name="tahun_terbit" value="{{ old('tahun_terbit', date('Y')) }}"
                    class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-pink-500"
                    min="1900" max="{{ date('Y') }}" required>
            </div>

            <div class="flex items-center gap-3 pt-4">
                <button type="submit" class="bg-pink-600 hover:bg-pink-700 text-white font-semibold px-6 py-3 rounded-xl transition">
                    Simpan Buku
                </button>
                <a href="{{ route('katalog.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-6 py-3 rounded-xl transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
