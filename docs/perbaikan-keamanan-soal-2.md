# PERBAIKAN KEAMANAN WEB - SOAL 2

## A1. Perbaikan Cross-Site Scripting (XSS)

**Kode sebelum perbaikan:**
Belum tersedia karena repository Git dibuat setelah proses perbaikan.

**Kode sesudah perbaikan:**

Pada `resources/views/buku/detail.blade.php`:

```blade
{{ $buku->judul }}
```

Pada tampilan daftar buku, data ditampilkan menggunakan `textContent`, bukan `innerHTML`.

**Hasil pengujian:**
Input yang berisi tag HTML atau script ditampilkan sebagai teks dan tidak dijalankan oleh browser.

**Penjelasan:**
Kerentanan XSS terjadi ketika input pengguna ditampilkan tanpa escaping. Perbaikan dilakukan dengan Blade escaping `{{ }}` dan penggunaan `textContent` pada JavaScript.

## A2. Perbaikan SQL Injection

**Kode sebelum perbaikan:**
Belum tersedia karena repository Git dibuat setelah proses perbaikan.

**Kode sesudah perbaikan:**

Pada `app/Http/Controllers/Api/BukuController.php`:

```php
public function cari(Request $request)
{
    $judul = $request->query('judul', '');

    $hasil = DB::select(
        'SELECT * FROM bukus WHERE judul LIKE ?',
        ["%{$judul}%"]
    );

    return response()->json($hasil);
}
```

**Hasil pengujian:**
Pencarian menggunakan parameter binding sehingga input diperlakukan sebagai nilai, bukan bagian dari perintah SQL.

**Penjelasan:**
SQL Injection dapat terjadi ketika input pengguna digabungkan langsung ke query SQL. Perbaikan dilakukan menggunakan parameter binding agar input tidak mengubah struktur query.

## A3. Perbaikan Penghapusan Buku melalui GET

**Kode sebelum perbaikan:**
Belum tersedia karena repository Git dibuat setelah proses perbaikan.

**Kode sesudah perbaikan:**

Pada `routes/web.php`:

```php
Route::delete('/buku/{buku}', function (Buku $buku) {
    $buku->delete();

    return redirect()->route('katalog.index')
        ->with('success', 'Buku berhasil dihapus.');
})->middleware(['auth', 'can:kelola-buku'])
  ->name('buku.destroy');
```

Form penghapusan menggunakan POST dengan method spoofing DELETE serta token CSRF.

**Hasil pengujian:**
- Route penghapusan menggunakan metode DELETE.
- Route GET penghapusan lama sudah tidak tersedia.
- Tombol hapus pada aplikasi tetap berfungsi.
- Permintaan DELETE tanpa token CSRF ditolak.

**Penjelasan:**
Penghapusan data tidak seharusnya dilakukan melalui GET. Perbaikan dilakukan dengan metode DELETE dan perlindungan CSRF agar penghapusan hanya dapat dilakukan melalui permintaan yang sesuai.

## Catatan Repository

Repository Git dibuat setelah pengerjaan perbaikan. Oleh karena itu, kode sebelum perbaikan dan riwayat perubahan awal tidak tersedia untuk ditampilkan secara autentik.