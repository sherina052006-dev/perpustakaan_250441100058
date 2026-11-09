<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use App\Http\Requests\StoreBukuRequest;
use App\Http\Requests\UpdateBukuRequest;
use Illuminate\Http\Request;
use App\Http\Resources\BukuResource;
use Illuminate\Support\Facades\DB;

class BukuController extends Controller
{

    
    public function index(Request $request)
    {
    $query = Buku::with('kategori')->withCount('peminjamans');

    if ($request->filled('cari')) {
        $cari = $request->cari;

        $query->where(function ($q) use ($cari) {
            $q->where('judul', 'like', "%{$cari}%")
              ->orWhere('penulis', 'like', "%{$cari}%");
        });
    }

    if ($request->filled('kategori')) {
        $query->where('kategori_id', $request->kategori);
    }

    if ($request->filled('tahun')) {
        $query->where('tahun_terbit', $request->tahun);
    }

    $buku = $query->latest()->paginate(10)->withQueryString();

    return BukuResource::collection($buku);
    }


    public function cari(Request $request)
    {
    $judul = $request->query('judul', '');

    $hasil = DB::select(
        'SELECT * FROM bukus WHERE judul LIKE ?',
        ["%{$judul}%"]
    );

    return response()->json($hasil);
    }
    
    
    public function store(Request $request)
    {
    $tahunSekarang = date('Y');

    $validated = $request->validate([
        'kategori_id'  => 'required|exists:kategoris,id',
        'judul'        => 'required|string|min:3|max:150',
        'penulis'      => 'required|string|min:3|max:100',
        'tahun_terbit' => "required|integer|between:1900,{$tahunSekarang}",
    ], [
        'required' => ':attribute wajib diisi.',
        'min'      => ':attribute minimal :min karakter.',
        'exists'   => ':attribute yang dipilih tidak valid.',
    ]);

    $buku = Buku::create($validated);

    return response()->json([
        'message' => 'Buku berhasil ditambahkan',
        'data'    => $buku->load('kategori')
    ], 201);
    }


    public function show($id)
    {
        $buku = Buku::with(['kategori', 'peminjamans'])->find($id);

        if (!$buku) {
            return response()->json([
                'message' => 'not found'
            ], 404);
        }

        return response()->json([
            'data' => $buku
        ], 200);
    }

    
    public function update(Request $request, $id)
    {
    $buku = Buku::find($id);

    if (!$buku) {
        return response()->json([
            'message' => 'Buku tidak ditemukan'
        ], 404);
    }

    $tahunSekarang = date('Y');

    $validated = $request->validate([
        'kategori_id'  => 'required|exists:kategoris,id',
        'judul'        => 'required|string|min:3|max:150',
        'penulis'      => 'required|string|min:3|max:100',
        'tahun_terbit' => "required|integer|between:1900,{$tahunSekarang}",
    ], [
        'required' => ':attribute wajib diisi.',
        'min'      => ':attribute minimal :min karakter.',
        'exists'   => ':attribute yang dipilih tidak valid.',
    ]);

    $buku->update($validated);

    return response()->json([
        'message' => 'Buku berhasil diperbarui',
        'data'    => $buku->load('kategori')
    ], 200);
    }


    public function destroy($id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json([
                'message' => 'not found'
            ], 404);
        }

        $buku->delete();

        return response()->json([
            'message' => 'Buku berhasil dihapus'
        ], 200);
    }


    public function bukuPerKategori()
    {
        $rekap = Kategori::withCount('bukus')->get();

        return response()->json([
            'status' => 'success',
            'data'   => $rekap
        ], 200);
    }


    public function peminjamanPerBuku()
    {
        $rekap = Buku::withCount('peminjamans')->get(['id', 'judul', 'penulis']);

        return response()->json([
            'status' => 'success',
            'data'   => $rekap
        ], 200);
    }
}