@extends('layouts.app')

@section('judul', 'Detail Buku')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">

    <div class="bg-white rounded-2xl shadow p-8">
        <h1 class="text-2xl font-bold text-pink-700 mb-6">
            Detail Buku
        </h1>

        <div class="space-y-4">
            <div>
                <p class="text-gray-500">Judul Buku</p>
                <p class="font-semibold">{{ $buku->judul }}</p>
            </div>

            <div>
                <p class="text-gray-500">Kategori</p>
                <p class="font-semibold">
                    {{ $buku->kategori->nama_kategori ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-gray-500">Penulis</p>
                <p class="font-semibold">{{ $buku->penulis }}</p>
            </div>

            <div>
                <p class="text-gray-500">Tahun Terbit</p>
                <p class="font-semibold">{{ $buku->tahun_terbit }}</p>
            </div>
        </div>

        <a href="{{ url('/katalog') }}"
            class="inline-block mt-8 bg-gray-200 hover:bg-gray-300 px-5 py-2 rounded-lg">
            Kembali ke Katalog
        </a>
    </div>
</div>
@endsection