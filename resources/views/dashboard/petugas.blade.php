@extends('layouts.app')
@section('judul', 'Dashboard Admin')

@section('content')
<div class="min-h-screen bg-gray-50 p-6 md:p-8">

    <div class="max-w-7xl mx-auto">

        <div class="bg-gradient-to-r from-pink-600 to-pink-400 rounded-3xl p-8 md:p-10 text-white shadow-xl shadow-pink-100">

            <span class="bg-white/20 text-white text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider">
                Dashboard Petugas
            </span>

            <h1 class="text-3xl font-extrabold mt-4">
                Selamat Datang, {{ auth()->user()->name }}!
            </h1>

            <p class="text-pink-100 mt-3 text-sm md:text-base">
                Selamat datang di Sistem Informasi Perpustakaan Digital.
                Silakan gunakan menu navigasi untuk mengelola buku dan peminjaman perpustakaan.
            </p>

        </div>

    </div>
</div>
@endsection