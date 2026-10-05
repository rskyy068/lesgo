<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bimbel;
use App\Models\Mapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BimbelController extends Controller
{
    /**
     * Tampilkan daftar semua bimbel dengan pencarian & filter.
     */
    public function index(Request $request)
    {
        $query = Bimbel::query();

        // Pencarian: nama / mapel / kota
        if ($request->filled('search')) {
            $term = '%' . $request->search . '%';
            $query->where(function ($q) use ($term) {
                $q->where('nama', 'like', $term)
                  ->orWhere('mapel', 'like', $term)
                  ->orWhere('kota', 'like', $term)
                  ->orWhere('alamat', 'like', $term);
            });
        }

        // Filter status
        if ($request->filled('status') && in_array($request->status, ['Aktif', 'Nonaktif'], true)) {
            $query->where('status', $request->status);
        }

        $bimbels = $query->latest()->paginate(10)->withQueryString();

        $stats = [
            'total'    => Bimbel::count(),
            'aktif'    => Bimbel::where('status', 'Aktif')->count(),
            'nonaktif' => Bimbel::where('status', 'Nonaktif')->count(),
        ];

        return view('admin.bimbel.index', compact('bimbels', 'stats'));
    }

    /**
     * Tampilkan form tambah bimbel.
     */
    public function create()
    {
        $mapels = Mapel::where('status', 'aktif')->orderBy('nama')->get();
        return view('admin.bimbel.create', compact('mapels'));
    }

    /**
     * Simpan bimbel baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'           => 'required|string|max:255',
            'mapel_ids'      => 'required|array|min:1',
            'mapel_ids.*'    => 'exists:mapels,id',
            'jenjang'        => 'required|string|max:255',
            'kota'           => 'required|string|max:255',
            'alamat'         => 'required|string',
            'telepon'        => 'nullable|string|max:20',
            'email'          => 'nullable|email|max:255',
            'website'        => 'nullable|url:http,https|max:255',
            'deskripsi'      => 'required|string',
            'harga_mulai'    => 'nullable|integer|min:0',
            'jam_operasional'=> 'nullable|string|max:255',
            'status'         => 'required|in:Aktif,Nonaktif',
            'logo'           => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'cover'          => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'nama.required'            => 'Nama bimbel wajib diisi.',
            'mapel_ids.required'       => 'Pilih minimal satu mata pelajaran/kategori.',
            'jenjang.required'         => 'Jenjang wajib diisi.',
            'kota.required'            => 'Kota wajib diisi.',
            'alamat.required'          => 'Alamat wajib diisi.',
            'deskripsi.required'       => 'Deskripsi wajib diisi.',
            'status.required'          => 'Pilih status bimbel.',
            'email.email'              => 'Format email tidak valid.',
            'website.url'              => 'Format URL website tidak valid.',
            'harga_mulai.integer'      => 'Harga harus berupa angka.',
            'logo.image'               => 'Logo harus berupa gambar.',
            'logo.mimes'               => 'Format logo harus jpeg, png, gif, atau webp.',
            'logo.max'                 => 'Ukuran logo maksimal 2 MB.',
            'cover.image'              => 'Cover harus berupa gambar.',
            'cover.mimes'              => 'Format cover harus jpeg, png, gif, atau webp.',
            'cover.max'                => 'Ukuran cover maksimal 2 MB.',
        ]);

        $mapelIds = $validated['mapel_ids'];
        $mapelNames = Mapel::whereIn('id', $mapelIds)->pluck('nama')->implode(', ');
        $validated['mapel'] = $mapelNames;
        unset($validated['mapel_ids']);

        // Simpan file logo jika ada
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('bimbel/logos', 'public');
        }

        // Simpan file cover jika ada
        if ($request->hasFile('cover')) {
            $validated['cover'] = $request->file('cover')->store('bimbel/covers', 'public');
        }

        // Set masa aktif 30 hari
        $validated['expires_at'] = now()->addDays(30);

        $bimbel = Bimbel::create($validated);
        $bimbel->mapels()->sync($mapelIds);

        return redirect()->route('admin.bimbel.index')
            ->with('success', 'Bimbel "' . $validated['nama'] . '" berhasil ditambahkan dengan masa aktif 30 hari.');
    }

    /**
     * Perpanjang masa aktif bimbel selama 30 hari.
     */
    public function perpanjang(Bimbel $bimbel)
    {
        $currentExpiration = ($bimbel->expires_at && $bimbel->expires_at->isFuture())
            ? $bimbel->expires_at
            : now();

        $bimbel->update([
            'expires_at' => (clone $currentExpiration)->addDays(30),
            'status' => 'Aktif',
        ]);

        return back()->with('success', 'Masa aktif bimbel "' . $bimbel->nama . '" berhasil diperpanjang 30 hari.');
    }

    /**
     * Detail bimbel.
     */
    public function show(Bimbel $bimbel)
    {
        $bimbel->loadCount(['reviews', 'favorites']);
        return view('admin.bimbel.show', compact('bimbel'));
    }

    /**
     * Form edit bimbel.
     */
    public function edit(Bimbel $bimbel)
    {
        $mapels = Mapel::where('status', 'aktif')->orderBy('nama')->get();
        $selectedMapelIds = $bimbel->mapels()->pluck('mapels.id')->toArray();

        return view('admin.bimbel.edit', compact('bimbel', 'mapels', 'selectedMapelIds'));
    }

    /**
     * Update data bimbel.
     */
    public function update(Request $request, Bimbel $bimbel)
    {
        $validated = $request->validate([
            'nama'           => 'required|string|max:255',
            'mapel_ids'      => 'required|array|min:1',
            'mapel_ids.*'    => 'exists:mapels,id',
            'jenjang'        => 'required|string|max:255',
            'kota'           => 'required|string|max:255',
            'alamat'         => 'required|string',
            'telepon'        => 'nullable|string|max:20',
            'email'          => 'nullable|email|max:255',
            'website'        => 'nullable|url:http,https|max:255',
            'deskripsi'      => 'required|string',
            'harga_mulai'    => 'nullable|integer|min:0',
            'jam_operasional'=> 'nullable|string|max:255',
            'status'         => 'required|in:Aktif,Nonaktif',
            'logo'           => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'cover'          => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'nama.required'            => 'Nama bimbel wajib diisi.',
            'mapel_ids.required'       => 'Pilih minimal satu mata pelajaran/kategori.',
            'jenjang.required'         => 'Jenjang wajib diisi.',
            'kota.required'            => 'Kota wajib diisi.',
            'alamat.required'          => 'Alamat wajib diisi.',
            'deskripsi.required'       => 'Deskripsi wajib diisi.',
            'status.required'          => 'Pilih status bimbel.',
            'email.email'              => 'Format email tidak valid.',
            'website.url'              => 'Format URL website tidak valid.',
            'harga_mulai.integer'      => 'Harga harus berupa angka.',
            'logo.image'               => 'Logo harus berupa gambar.',
            'logo.mimes'               => 'Format logo harus jpeg, png, gif, atau webp.',
            'logo.max'                 => 'Ukuran logo maksimal 2 MB.',
            'cover.image'              => 'Cover harus berupa gambar.',
            'cover.mimes'              => 'Format cover harus jpeg, png, gif, atau webp.',
            'cover.max'                => 'Ukuran cover maksimal 2 MB.',
        ]);

        $mapelIds = $validated['mapel_ids'];
        $mapelNames = Mapel::whereIn('id', $mapelIds)->pluck('nama')->implode(', ');
        $validated['mapel'] = $mapelNames;
        unset($validated['mapel_ids']);

        // Simpan file logo baru jika ada, hapus yang lama
        if ($request->hasFile('logo')) {
            if ($bimbel->logo) {
                Storage::disk('public')->delete($bimbel->logo);
            }
            $validated['logo'] = $request->file('logo')->store('bimbel/logos', 'public');
        }

        // Simpan file cover baru jika ada, hapus yang lama
        if ($request->hasFile('cover')) {
            if ($bimbel->cover) {
                Storage::disk('public')->delete($bimbel->cover);
            }
            $validated['cover'] = $request->file('cover')->store('bimbel/covers', 'public');
        }

        $bimbel->update($validated);
        $bimbel->mapels()->sync($mapelIds);

        return redirect()->route('admin.bimbel.index')
            ->with('success', 'Bimbel "' . $validated['nama'] . '" berhasil diperbarui.');
    }


    /**
     * Hapus bimbel beserta file-file terkait.
     */
    public function destroy(Bimbel $bimbel)
    {
        $nama = $bimbel->nama;

        // Hapus file logo & cover jika ada
        if ($bimbel->logo) {
            Storage::disk('public')->delete($bimbel->logo);
        }
        if ($bimbel->cover) {
            Storage::disk('public')->delete($bimbel->cover);
        }

        $bimbel->delete();

        return redirect()->route('admin.bimbel.index')
            ->with('success', 'Bimbel "' . $nama . '" berhasil dihapus.');
    }
}
