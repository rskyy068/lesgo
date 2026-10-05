<?php

namespace App\Http\Controllers;

use App\Models\Bimbel;
use App\Models\Mapel;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Halaman utama
     */
    public function index()
    {
        // Ambil bimbel yang diurutkan berdasarkan rating tertinggi (algoritma rating) & belum kedaluwarsa
        $bimbels = Bimbel::active()
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->orderByRaw('COALESCE(reviews_avg_rating, 0) DESC')
            ->orderBy('reviews_count', 'desc')
            ->latest()
            ->take(6)
            ->get();

        // Ambil 5 mata pelajaran terpopuler
        $mapels = Mapel::where('status', 'aktif')
            ->get()
            ->map(function ($mapel) {

                // Hitung jumlah bimbel berdasarkan nama mapel
                $mapel->jumlah_bimbel = Bimbel::where('mapel', 'like', "%{$mapel->nama}%")
                    ->active()
                    ->count();

                return $mapel;
            })
            ->sortByDesc('jumlah_bimbel')
            ->take(5);

        // Kirim KEDUANYA ke guest.home
        return view('guest.home', compact('bimbels', 'mapels'));
    }

    /**
     * Halaman form pendaftaran bimbel
     */
    public function create(Request $request)
    {
        $paket = $request->get('paket', 'basic');

        if (!in_array($paket, ['basic', 'pro'])) {
            $paket = 'basic';
        }

        return view('bimbel.daftar', compact('paket'));
    }

    /**
     * Halaman Lihat Semua Bimbel (Public Guest View) dengan Algoritma Sorting Rating
     */
    public function bimbel(Request $request)
    {
        $query = Bimbel::active()
            ->withAvg('reviews', 'rating')
            ->withCount('reviews');

        if ($request->filled('q')) {
            $keyword = $request->q;
            $query->where(function ($q) use ($keyword) {
                $q->where('nama', 'like', "%{$keyword}%")
                  ->orWhere('mapel', 'like', "%{$keyword}%")
                  ->orWhere('kota', 'like', "%{$keyword}%")
                  ->orWhere('jenjang', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('mapel')) {
            $query->where('mapel', 'like', "%{$request->mapel}%");
        }

        if ($request->filled('kota')) {
            $query->where('kota', $request->kota);
        }

        // ALGORITMA PENGURUTAN: Default berdasarkan Rating Tertinggi
        $sort = $request->get('sort', 'rating');
        if ($sort === 'terbaru') {
            $query->latest();
        } elseif ($sort === 'harga_asc') {
            $query->orderBy('harga_mulai', 'asc');
        } elseif ($sort === 'harga_desc') {
            $query->orderBy('harga_mulai', 'desc');
        } else {
            // Default (Rating Tertinggi): Bimbel dengan rating rata-rata lebih tinggi ditampilkan paling atas
            $query->orderByRaw('COALESCE(reviews_avg_rating, 0) DESC')
                  ->orderBy('reviews_count', 'desc')
                  ->latest();
        }

        $bimbels = $query->paginate(9)->withQueryString();

        // Ambil list mapel & kota unik untuk dropdown filter
        $allMapels = Mapel::where('status', 'aktif')->pluck('nama');
        $allKotas = Bimbel::active()->distinct()->pluck('kota')->filter();

        return view('guest.bimbel_all', compact('bimbels', 'allMapels', 'allKotas'));
    }

    /**
     * Halaman Lihat Semua Mata Pelajaran (Public Guest View)
     */
    public function mapel(Request $request)
    {
        $query = Mapel::where('status', 'aktif');

        if ($request->filled('q')) {
            $query->where('nama', 'like', "%{$request->q}%");
        }

        $mapels = $query->get()
            ->map(function ($mapel) {
                $mapel->jumlah_bimbel = Bimbel::where('mapel', 'like', "%{$mapel->nama}%")
                    ->whereIn('status', ['Aktif', 'aktif', 'Active', 'active'])
                    ->count();
                return $mapel;
            })
            ->sortByDesc('jumlah_bimbel');

        return view('guest.mapel_all', compact('mapels'));
    }

    /**
     * Detail bimbel
     */
    public function detail($id)
    {
        $bimbel = Bimbel::withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->findOrFail($id);

        return view('bimbel.detail', compact('bimbel'));
    }

    /**
     * Form pendaftaran siswa untuk bimbel tertentu
     */
    public function pendaftaranSiswa($id)
    {
        $bimbel = Bimbel::withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->findOrFail($id);

        $reviews = $bimbel->reviews()
            ->with('user')
            ->latest()
            ->get();

        // Ambil daftar mapel yang HANYA TERSEDIA di bimbel ini
        if ($bimbel->mapels()->exists()) {
            $bimbelMapels = $bimbel->mapels->pluck('nama');
        } else {
            $bimbelMapels = collect(preg_split('/[,;\/&]+/', $bimbel->mapel))
                ->map(fn($m) => trim($m))
                ->filter()
                ->unique()
                ->values();
        }

        return view('guest.bimbel_pendaftaran', compact('bimbel', 'bimbelMapels', 'reviews'));
    }
}
