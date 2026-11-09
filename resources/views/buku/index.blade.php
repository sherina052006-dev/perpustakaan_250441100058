@extends('layouts.app')
@section('judul', 'Koleksi Buku - Perpustakaan')
@section('content')

<div class="mb-10 bg-gradient-to-r from-pink-600 to-pink-400 rounded-3xl p-8 md:p-10 text-white shadow-xl shadow-pink-100">
    <span class="bg-white/20 text-white text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider">
        Katalog Aktif
    </span>
    <h1 class="text-3xl font-extrabold mt-3">Koleksi Buku Perpustakaan</h1>
    <p class="text-pink-100 mt-2 text-sm md:text-base">
        Temukan berbagai referensi menarik untuk menunjang perkuliahan dan wawasan Anda.
    </p>
</div>
@if (session('success'))
    <div class="mb-6 bg-green-100 border border-green-300 text-green-700 px-5 py-3 rounded-xl">
        {{ session('success') }}
    </div>
@endif

@can('kelola-buku')
<div class="bg-white rounded-2xl p-6 shadow-sm mb-6">
    <h2 class="text-xl font-bold text-slate-800 mb-4">Tambah Buku</h2>

    <form id="form-buku" class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label for="kategori_id" class="block mb-2 font-medium">Kategori</label>
            <select id="kategori_id" name="kategori_id"
                class="w-full border rounded-lg p-3" required
                oninvalid="this.setCustomValidity('Silakan pilih kategori buku.')"
                oninput="this.setCustomValidity('')"
                onchange="this.setCustomValidity('')">
                <option value="">Pilih Kategori</option>
            </select>
        </div>

        <div>
            <label for="judul" class="block mb-2 font-medium">Judul Buku</label>
            <input type="text" id="judul" name="judul"
                class="w-full border rounded-lg p-3"
                minlength="3" maxlength="150" required
                oninvalid="this.setCustomValidity('Judul buku minimal 3 karakter.')"
                oninput="this.setCustomValidity('')">
        </div>

        <div>
            <label for="penulis" class="block mb-2 font-medium">Penulis</label>
            <input type="text" id="penulis" name="penulis"
                class="w-full border rounded-lg p-3"
                minlength="3" maxlength="100" required>
        </div>

        <div>
            <label for="tahun_terbit" class="block mb-2 font-medium">Tahun Terbit</label>
            <input type="number" id="tahun_terbit" name="tahun_terbit"
                class="w-full border rounded-lg p-3"
                min="1900" max="2026" required>
        </div>

        <div class="md:col-span-2">
            <button type="submit"
                class="bg-pink-600 hover:bg-pink-700 text-white font-semibold px-6 py-3 rounded-xl">
                Tambah Buku
            </button>
        </div>
    </form>

    <p id="pesan-form" class="mt-4 text-sm" role="status"></p>
</div>
@endcan

<div class="bg-white rounded-2xl p-6 shadow-sm overflow-x-auto">
    <h2 class="text-xl font-bold text-slate-800 mb-4">Daftar Buku</h2>
    <p id="pesan" class="mb-4 text-sm"></p>

    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-pink-100 text-pink-800">
                <th class="p-3">Kategori</th>
                <th class="p-3">Judul</th>
                <th class="p-3">Penulis</th>
                <th class="p-3">Tahun Terbit</th>
                <th class="p-3">Aksi</th>
            </tr>
        </thead>
        <tbody id="daftar-buku">
            <tr>
                <td colspan="5" class="p-4 text-center">Memuat data buku...</td>
            </tr>
        </tbody>
    </table>
</div>

<script>

let idBukuDiubah = null;

function ambilTokenCSRF() {
    const token = document.cookie
        .split('; ')
        .find(baris => baris.startsWith('XSRF-TOKEN='));

    return token ? decodeURIComponent(token.split('=')[1]) : '';
}
async function siapkanCSRF() {
    const response = await fetch('/sanctum/csrf-cookie', {
        credentials: 'same-origin'
    });

    if (!response.ok) {
        throw new Error('Gagal menyiapkan keamanan CSRF.');
    }
}

async function muatKategori() {
    const select = document.getElementById('kategori_id');

    if (!select) return;

    try {
        const response = await fetch('/api/rekap/buku-per-kategori');

        if (!response.ok) {
            throw new Error('Gagal mengambil daftar kategori.');
        }

        const hasil = await response.json();

        hasil.data.forEach(kategori => {
            const option = document.createElement('option');
            option.value = kategori.id;
            option.textContent = kategori.nama_kategori;
            select.appendChild(option);
        });
    } catch (error) {
        tampilkanPesanForm(error.message, true);
    }
}

function tampilkanPesanForm(pesan, error = false) {
    const elemen = document.getElementById('pesan-form');

    if (!elemen) return;

    elemen.textContent = pesan;
    elemen.className = error
        ? 'mt-4 text-sm text-red-600'
        : 'mt-4 text-sm text-green-600';
}

async function tampilkanBuku() {
    const tabel = document.getElementById('daftar-buku');
    const pesan = document.getElementById('pesan');

    try {
        pesan.textContent = '';

        const response = await fetch('/api/buku');

        if (!response.ok) {
            throw new Error('Gagal mengambil data buku.');
        }

        const hasil = await response.json();
        const buku = hasil.data;

        tabel.replaceChildren();

        if (!buku || buku.length === 0) {
            const baris = tabel.insertRow();
            const kolom = baris.insertCell();
            kolom.colSpan = 5;
            kolom.className = 'p-4 text-center';
            kolom.textContent = 'Data buku belum tersedia.';
            return;
        }

        buku.forEach(item => {
            const baris = tabel.insertRow();

            [
                item.kategori,
                item.judul_buku,
                item.penulis,
                item.tahun_terbit
            ].forEach(nilai => {
                const kolom = baris.insertCell();
                kolom.className = 'p-3 border-b';
                kolom.textContent = nilai ?? '-';
            });

            const kolomAksi = baris.insertCell();
                kolomAksi.className = 'p-3 border-b align-top';

                const tombolDetail = document.createElement('a');
                    tombolDetail.textContent = 'Detail';
                    tombolDetail.href = `/buku/${item.id}`;
                    tombolDetail.className =
                        'inline-block bg-pink-600 hover:bg-pink-700 text-white font-bold px-4 py-2 rounded-lg mb-2 border border-pink-700';

            kolomAksi.appendChild(tombolDetail);

            const bolehKelolaBuku = @json(auth()->user()->can('kelola-buku'));
            const bolehAjukanPeminjaman = @json(
                auth()->user()->hasRole('Siswa') &&
                auth()->user()->can('mengajukan peminjaman buku')
);

if (bolehAjukanPeminjaman) {
    const status = item.status_peminjaman;

    if (status === 'Menunggu Persetujuan') {
        const tombolStatus = document.createElement('button');
        tombolStatus.textContent = 'Menunggu Persetujuan';
        tombolStatus.disabled = true;
        tombolStatus.className =
            'bg-yellow-400 text-gray-800 px-4 py-2 rounded-lg mt-2';

        kolomAksi.appendChild(tombolStatus);

    } else if (status === 'Dipinjam') {
        const tombolStatus = document.createElement('button');
        tombolStatus.textContent = 'Sedang Dipinjam';
        tombolStatus.disabled = true;
        tombolStatus.className =
            'bg-green-600 text-white px-4 py-2 rounded-lg mt-2';

        kolomAksi.appendChild(tombolStatus);

    } else {
        const formAjukan = document.createElement('form');
        formAjukan.className = 'mt-2';
        formAjukan.method = 'POST';
        formAjukan.action = `/peminjaman/ajukan/${item.id}`;

        const token = document.querySelector('meta[name="csrf-token"]');

        formAjukan.innerHTML = `
            <input type="hidden" name="_token" value="${token.content}">
            <button type="submit"
                class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-lg">
                Ajukan Peminjaman
            </button>
        `;

        kolomAksi.appendChild(formAjukan);
    }
} 

            if (bolehKelolaBuku) {
                const tombolUbah = document.createElement('button');

                tombolUbah.textContent = 'Ubah';
                tombolUbah.className =
                    'bg-yellow-400 hover:bg-yellow-500 px-4 py-2 rounded-lg';

                tombolUbah.addEventListener('click', () => {
                    ubahBuku(item);
                });

                kolomAksi.appendChild(tombolUbah);

                const formHapus = document.createElement('form');

                    formHapus.method = 'POST';
                    formHapus.action = `/buku/${item.id}`;
                    formHapus.className = 'inline-block ml-2';

                    const token = document.querySelector('meta[name="csrf-token"]');

                    formHapus.innerHTML = `
                        <input type="hidden" name="_token" value="${token.content}">
                        <input type="hidden" name="_method" value="DELETE">

                        <button type="submit"
                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                            Hapus
                        </button>
                    `;

                    formHapus.addEventListener('submit', function(event) {
                        if (!confirm('Yakin ingin menghapus buku ini?')) {
                            event.preventDefault();
                        }
                    });

                    kolomAksi.appendChild(formHapus);
            }
        });

    } catch (error) {
        tabel.replaceChildren();

        const baris = tabel.insertRow();
        const kolom = baris.insertCell();

        kolom.colSpan = 5;
        kolom.className = 'p-4 text-center text-red-600';
        kolom.textContent = 'Data gagal dimuat. ' + error.message;

        pesan.textContent = 'Periksa koneksi dan endpoint API.';
        pesan.className = 'mb-4 text-sm text-red-600';
    }
}

function ubahBuku(item) {
    const form = document.getElementById('form-buku');

    if (!form) return;

    idBukuDiubah = item.id;

    document.getElementById('kategori_id').value = item.kategori_id;
    document.getElementById('judul').value = item.judul_buku;
    document.getElementById('penulis').value = item.penulis;
    document.getElementById('tahun_terbit').value = item.tahun_terbit;

    const tombol = form.querySelector('button[type="submit"]');
    tombol.textContent = 'Simpan Perubahan';

    tampilkanPesanForm('Silakan ubah data buku yang dipilih.');
}

const formBuku = document.getElementById('form-buku');

if (formBuku) {
    formBuku.addEventListener('submit', async function(event) {
        event.preventDefault();

        const form = this;
        const tombol = form.querySelector('button[type="submit"]');
        const data = Object.fromEntries(new FormData(form).entries());
        const sedangMengubah = idBukuDiubah !== null;

        tombol.disabled = true;
        tampilkanPesanForm('Menyimpan data...');

        try {
            await siapkanCSRF();

            const response = await fetch(
                sedangMengubah
                    ? `/api/buku/${idBukuDiubah}`
                    : '/api/buku',
                {
                    method: sedangMengubah ? 'PUT' : 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-XSRF-TOKEN': ambilTokenCSRF()
                    },
                    body: JSON.stringify(data)
                }
            );

            const hasil = await response.json();

            if (!response.ok) {
                if (response.status === 422 && hasil.errors) {
                    const daftarError = Object.values(hasil.errors).flat();
                    throw new Error(daftarError.join(' '));
                }

                throw new Error(
                    hasil.message || 'Gagal menyimpan data buku.'
                );
            }

            form.reset();
            idBukuDiubah = null;
            tombol.textContent = 'Tambah Buku';

            tampilkanPesanForm(
                sedangMengubah
                    ? 'Buku berhasil diperbarui.'
                    : 'Buku berhasil ditambahkan.'
            );

            await tampilkanBuku();

        } catch (error) {
            tampilkanPesanForm(error.message, true);
        } finally {
            tombol.disabled = false;
        }
    });
}

muatKategori();
tampilkanBuku();

const inputTahun = document.getElementById('tahun_terbit');

if (inputTahun) {
    inputTahun.addEventListener('input', function() {
        this.setCustomValidity('');
    });

    inputTahun.addEventListener('invalid', function() {
        if (this.validity.rangeOverflow) {
            this.setCustomValidity(
                'Tahun terbit tidak boleh melebihi tahun 2026.'
            );
        } else if (this.validity.rangeUnderflow) {
            this.setCustomValidity(
                'Tahun terbit minimal tahun 1900.'
            );
        } else if (this.validity.valueMissing) {
            this.setCustomValidity(
                'Tahun terbit wajib diisi.'
            );
        } else {
            this.setCustomValidity(
                'Masukkan tahun terbit yang valid.'
            );
        }
    });
}
</script>
@endsection