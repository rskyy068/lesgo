<?php

namespace App\Http\Controllers;

use App\Models\Bimbel;
use App\Models\BimbelToken;
use App\Models\Mapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BimbelUserController extends Controller
{
    /**
     * Tampilkan daftar bimbel milik user yang sedang login dengan pencarian & filter.
     */
    public function index(Request $request)
    {
        $query = Bimbel::where('user_id', auth()->id());

        // Pencarian: nama / mapel / kota
        if ($request->filled('search')) {
            $term = '%'.$request->search.'%';
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

        $userBimbels = Bimbel::where('user_id', auth()->id());
        $stats = [
            'total' => (clone $userBimbels)->count(),
            'aktif' => (clone $userBimbels)->where('status', 'Aktif')->count(),
            'nonaktif' => (clone $userBimbels)->where('status', 'Nonaktif')->count(),
        ];

        return view('guest.bimbeluser.index', compact('bimbels', 'stats'));
    }

    /**
     * Tampilkan form tambah bimbel.
     */
    public function create()
    {
        $mapels = Mapel::where('status', 'aktif')->orderBy('nama')->get();
        return view('guest.bimbeluser.create', compact('mapels'));
    }

    /**
     * Simpan bimbel baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'token' => 'required|string',
            'nama' => 'required|string|max:255',
            'mapel_ids' => 'required|array|min:1',
            'mapel_ids.*' => 'exists:mapels,id',
            'jenjang' => 'required|string|max:255',
            'kota' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url:http,https|max:255',
            'deskripsi' => 'required|string',
            'harga_mulai' => 'nullable|integer|min:0',
            'jam_operasional' => 'nullable|string|max:255',
            'status' => 'required|in:Aktif,Nonaktif',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'token.required' => 'Token pembuatan bimbel wajib diisi.',
            'nama.required' => 'Nama bimbel wajib diisi.',
            'mapel_ids.required' => 'Pilih minimal satu mata pelajaran/kategori.',
            'jenjang.required' => 'Jenjang wajib diisi.',
            'kota.required' => 'Kota wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'status.required' => 'Pilih status bimbel.',
            'email.email' => 'Format email tidak valid.',
            'website.url' => 'Format URL website tidak valid.',
            'harga_mulai.integer' => 'Harga harus berupa angka.',
            'logo.image' => 'Logo harus berupa gambar.',
            'logo.mimes' => 'Format logo harus jpeg, png, gif, atau webp.',
            'logo.max' => 'Ukuran logo maksimal 2 MB.',
            'cover.image' => 'Cover harus berupa gambar.',
            'cover.mimes' => 'Format cover harus jpeg, png, gif, atau webp.',
            'cover.max' => 'Ukuran cover maksimal 2 MB.',
        ]);

        // Verifikasi ketersediaan dan status token
        $bimbelToken = BimbelToken::where('token', trim($request->token))->first();

        if (! $bimbelToken) {
            return back()->withErrors(['token' => 'Token pembuatan bimbel tidak ditemukan. Silakan periksa kembali token Anda.'])->withInput();
        }

        if ($bimbelToken->status !== 'unused') {
            return back()->withErrors(['token' => 'Token ini sudah pernah digunakan untuk mendaftarkan bimbel.'])->withInput();
        }

        if ($bimbelToken->expires_at && $bimbelToken->expires_at->isPast()) {
            return back()->withErrors(['token' => 'Token ini telah kedaluwarsa. Silakan hubungi admin untuk token baru.'])->withInput();
        }

        // Simpan list id mapel & gabungkan nama mapel untuk kolom string legacy
        $mapelIds = $validated['mapel_ids'];
        $mapelNames = Mapel::whereIn('id', $mapelIds)->pluck('nama')->implode(', ');
        $validated['mapel'] = $mapelNames;
        unset($validated['token'], $validated['mapel_ids']);

        // Set pemilik bimbel ke ID user yang sedang login & masa aktif 30 hari
        $validated['user_id'] = auth()->id();
        $validated['expires_at'] = now()->addDays(30);

        // Simpan file logo jika ada
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('bimbel/logos', 'public');
        }

        // Simpan file cover jika ada
        if ($request->hasFile('cover')) {
            $validated['cover'] = $request->file('cover')->store('bimbel/covers', 'public');
        }

        $bimbel = Bimbel::create($validated);

        // Sync relasi pivot bimbel_mapel
        $bimbel->mapels()->sync($mapelIds);

        // Tandai token telah digunakan
        $bimbelToken->update([
            'status' => 'used',
            'used_at' => now(),
        ]);

        return redirect()->route('bimbeluser.index')
            ->with('success', 'Bimbel "'.$validated['nama'].'" berhasil ditambahkan dengan masa aktif 30 hari (Token: '.$bimbelToken->token.').');
    }

    /**
     * Detail bimbel (hanya milik user yang login).
     */
    public function show(Bimbel $bimbeluser)
    {
        $this->authorizeOwner($bimbeluser);
        $bimbeluser->loadCount(['reviews', 'favorites']);

        return view('guest.bimbeluser.show', ['bimbel' => $bimbeluser]);
    }

    /**
     * Form edit bimbel (hanya milik user yang login).
     */
    public function edit(Bimbel $bimbeluser)
    {
        $this->authorizeOwner($bimbeluser);
        $mapels = Mapel::where('status', 'aktif')->orderBy('nama')->get();
        $selectedMapelIds = $bimbeluser->mapels()->pluck('mapels.id')->toArray();

        return view('guest.bimbeluser.edit', [
            'bimbel' => $bimbeluser,
            'mapels' => $mapels,
            'selectedMapelIds' => $selectedMapelIds,
        ]);
    }

    /**
     * Update data bimbel (hanya milik user yang login).
     */
    public function update(Request $request, Bimbel $bimbeluser)
    {
        $this->authorizeOwner($bimbeluser);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'mapel_ids' => 'required|array|min:1',
            'mapel_ids.*' => 'exists:mapels,id',
            'jenjang' => 'required|string|max:255',
            'kota' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url:http,https|max:255',
            'deskripsi' => 'required|string',
            'harga_mulai' => 'nullable|integer|min:0',
            'jam_operasional' => 'nullable|string|max:255',
            'status' => 'required|in:Aktif,Nonaktif',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'nama.required' => 'Nama bimbel wajib diisi.',
            'mapel_ids.required' => 'Pilih minimal satu mata pelajaran/kategori.',
            'jenjang.required' => 'Jenjang wajib diisi.',
            'kota.required' => 'Kota wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'status.required' => 'Pilih status bimbel.',
            'email.email' => 'Format email tidak valid.',
            'website.url' => 'Format URL website tidak valid.',
            'harga_mulai.integer' => 'Harga harus berupa angka.',
            'logo.image' => 'Logo harus berupa gambar.',
            'logo.mimes' => 'Format logo harus jpeg, png, gif, atau webp.',
            'logo.max' => 'Ukuran logo maksimal 2 MB.',
            'cover.image' => 'Cover harus berupa gambar.',
            'cover.mimes' => 'Format cover harus jpeg, png, gif, atau webp.',
            'cover.max' => 'Ukuran cover maksimal 2 MB.',
        ]);

        $mapelIds = $validated['mapel_ids'];
        $mapelNames = Mapel::whereIn('id', $mapelIds)->pluck('nama')->implode(', ');
        $validated['mapel'] = $mapelNames;
        unset($validated['mapel_ids']);

        // Simpan file logo baru jika ada, hapus yang lama
        if ($request->hasFile('logo')) {
            if ($bimbeluser->logo) {
                Storage::disk('public')->delete($bimbeluser->logo);
            }
            $validated['logo'] = $request->file('logo')->store('bimbel/logos', 'public');
        }

        // Simpan file cover baru jika ada, hapus yang lama
        if ($request->hasFile('cover')) {
            if ($bimbeluser->cover) {
                Storage::disk('public')->delete($bimbeluser->cover);
            }
            $validated['cover'] = $request->file('cover')->store('bimbel/covers', 'public');
        }

        $bimbeluser->update($validated);
        $bimbeluser->mapels()->sync($mapelIds);

        return redirect()->route('bimbeluser.index')
            ->with('success', 'Bimbel "'.$validated['nama'].'" berhasil diperbarui.');
    }


    /**
     * Hapus bimbel (hanya milik user yang login).
     */
    public function destroy(Bimbel $bimbeluser)
    {
        $this->authorizeOwner($bimbeluser);
        $nama = $bimbeluser->nama;

        // Hapus file logo & cover jika ada
        if ($bimbeluser->logo) {
            Storage::disk('public')->delete($bimbeluser->logo);
        }
        if ($bimbeluser->cover) {
            Storage::disk('public')->delete($bimbeluser->cover);
        }

        $bimbeluser->delete();

        return redirect()->route('bimbeluser.index')
            ->with('success', 'Bimbel "'.$nama.'" berhasil dihapus.');
    }

    /**
     * Helper privat untuk memastikan bimbel milik user yang login.
     */
    private function authorizeOwner(Bimbel $bimbel): void
    {
        if ($bimbel->user_id && (int) $bimbel->user_id !== (int) auth()->id()) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengelola bimbel ini.');
        }
    }
}
