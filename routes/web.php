<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\Api\BukuController;
use App\Models\Buku;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (auth()->user()->hasRole('Admin')) {
        return redirect()->route('admin.dashboard');
    }

    if (auth()->user()->hasRole('Petugas')) {
        return redirect()->route('petugas.dashboard');
    }

    if (auth()->user()->hasRole('Siswa')) {
        return redirect()->route('katalog.index');
    }

    abort(403, 'Anda tidak memiliki hak akses.');
})->middleware('auth')->name('dashboard');

Route::get('/admin/dashboard', function () {
    return view('dashboard.admin');
})->middleware(['auth', 'role:Admin'])->name('admin.dashboard');

Route::get('/petugas/dashboard', function () {
    return view('dashboard.petugas');
})->middleware(['auth', 'role:Petugas'])->name('petugas.dashboard');

Route::get('/katalog', function () {
    return view('buku.index');
})->middleware(['auth', 'permission:lihat daftar buku'])
  ->name('katalog.index');

Route::get('/buku/create', [BukuController::class, 'create'])
    ->middleware(['auth', 'permission:kelola data buku'])
    ->name('buku.create');

Route::post('/buku', [BukuController::class, 'store'])
    ->middleware(['auth', 'permission:kelola data buku'])
    ->name('buku.store');

Route::get('/buku/{id}', function ($id) {
    $buku = Buku::with('kategori')->findOrFail($id);

    return view('buku.detail', compact('buku'));
})->middleware(['auth', 'permission:lihat daftar buku'])
  ->whereNumber('id')
  ->name('buku.detail');


Route::delete('/buku/{buku}', function (Buku $buku) {
    $buku->delete();

    return redirect()->route('katalog.index')
        ->with('success', 'Buku berhasil dihapus.');
})->middleware(['auth', 'can:kelola-buku'])
  ->name('buku.destroy');

Route::get('/buku/{id}/hapus', [BukuController::class, 'destroy'])
  ->whereNumber('id');

Route::get('/admin/users', [\App\Http\Controllers\UserController::class, 'index'])
    ->middleware(['auth', 'role:Admin'])
    ->name('admin.users.index');

Route::patch('/admin/users/{user}/role', [\App\Http\Controllers\UserController::class, 'updateRole'])
    ->middleware(['auth', 'role:Admin'])
    ->name('admin.users.updateRole');

Route::get('/laporan', [\App\Http\Controllers\LaporanController::class, 'index'])
    ->middleware(['auth', 'role:Admin|Petugas'])
    ->name('laporan.index');

Route::middleware('auth')->group(function () {
    Route::get('/peminjaman/{id}', [PeminjamanController::class, 'show'])
        ->whereNumber('id')
        ->name('peminjaman.show');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/riwayat-peminjaman', [\App\Http\Controllers\RiwayatPeminjamanController::class, 'index'])
    ->middleware(['auth', 'permission:melihat riwayat peminjaman sendiri'])
    ->name('peminjaman.riwayat');

Route::get('/buku-cari', [BukuController::class, 'cari'])
    ->middleware('auth')
    ->name('buku.cari');

Route::post('/peminjaman/ajukan/{buku_id}', [PeminjamanController::class, 'ajukan'])
    ->middleware(['auth', 'role:Siswa', 'permission:mengajukan peminjaman buku'])
    ->name('peminjaman.ajukan');

Route::get('/peminjaman', [PeminjamanController::class, 'index'])
    ->middleware(['auth', 'permission:memproses persetujuan peminjaman'])
    ->name('peminjaman.index');

Route::patch('/peminjaman/{id}/setujui', [PeminjamanController::class, 'setujui'])
    ->middleware(['auth', 'permission:memproses persetujuan peminjaman'])
    ->name('peminjaman.setujui');

Route::patch('/peminjaman/{id}/kembalikan', [PeminjamanController::class, 'kembalikan'])
    ->middleware(['auth', 'role:Admin|Petugas', 'permission:mencatat pengembalian buku'])
    ->name('peminjaman.kembalikan');

// Route::get('/uji-error', function () {
//     throw new RuntimeException('Tes keamanan Soal 5');
// });
require __DIR__.'/auth.php';


