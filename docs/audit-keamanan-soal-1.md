# AUDIT KEAMANAN WEB - SOAL 1

## A1. Cross-Site Scripting (XSS)

- Jenis kerentanan: Cross-Site Scripting (XSS).
- Penyebab: Data judul buku ditampilkan tanpa escaping.
- Dampak: Browser berpotensi menafsirkan input pengguna sebagai kode.
- Perbaikan: Menggunakan Blade escaping dengan sintaks Blade {{ }}.

## A2. SQL Injection

- Jenis kerentanan: SQL Injection.
- Penyebab: Input pencarian berpotensi digabungkan langsung ke query SQL.
- Dampak: Query database dapat dimanipulasi melalui input pengguna.
- Perbaikan: Menggunakan parameter binding pada query SQL.

## A3. Penghapusan Buku

- Jenis kerentanan: Penghapusan data melalui GET.
- Penyebab: Route penghapusan menggunakan metode GET.
- Dampak: Penghapusan dapat terpicu melalui permintaan yang tidak semestinya.
- Perbaikan: Menggunakan metode DELETE dan perlindungan CSRF.

## A4. Insecure Direct Object Reference (IDOR)

- Jenis kerentanan: IDOR pada detail peminjaman.
- Penyebab: Tidak adanya pemeriksaan kepemilikan data peminjaman.
- Dampak: Siswa berpotensi melihat data peminjaman milik siswa lain.
- Perbaikan: Menggunakan PeminjamanPolicy dan Gate.

## Kesimpulan

Audit Soal 1 mengidentifikasi empat kerentanan keamanan pada aplikasi perpustakaan.

A1, A2, dan A3 diperbaiki pada Soal 2. A4 diperbaiki pada Soal 4.

Catatan: Repository Git baru dibuat setelah pengerjaan perbaikan. Belum tersedia riwayat commit kondisi rentan sebelum perbaikan.