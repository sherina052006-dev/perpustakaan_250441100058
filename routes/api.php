
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BukuController;

// Menampilkan daftar buku tetap dapat diakses sesuai kebutuhan aplikasi
Route::get('buku', [BukuController::class, 'index']);
Route::get('buku/{buku}', [BukuController::class, 'show']);

// Tambah, ubah, dan hapus hanya untuk Admin dan Petugas
Route::middleware(['auth:sanctum', 'can:kelola-buku'])->group(function () {
    Route::post('buku', [BukuController::class, 'store']);
    Route::put('buku/{buku}', [BukuController::class, 'update']);
    Route::patch('buku/{buku}', [BukuController::class, 'update']);
    Route::delete('buku/{buku}', [BukuController::class, 'destroy']);
});

// Rekap buku
Route::get('rekap/buku-per-kategori', [BukuController::class, 'bukuPerKategori']);
Route::get('rekap/peminjaman-per-buku', [BukuController::class, 'peminjamanPerBuku']);
