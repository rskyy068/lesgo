<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MapelController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $mapels = Mapel::when($search, function ($query) use ($search) {
            $query->where('nama', 'like', "%{$search}%");
        })->latest()->get();

        return view('admin.mapel.index', compact('mapels', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'warna' => 'required|string|max:7',
            'icon' => 'required|image|mimes:png,jpg,jpeg,webp,svg|max:2048',
        ]);

        $iconPath = $request->file('icon')->store('mapel', 'public');

        Mapel::create([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama),
            'warna' => $request->warna,
            'icon' => $iconPath,
            'status' => 'aktif',
        ]);

        return redirect()->route('admin.mapel.index')->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    public function update(Request $request, Mapel $mapel)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'warna' => 'required|string|max:7',
            'icon' => 'nullable|image|mimes:png,jpg,jpeg,webp,svg|max:2048',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $data = [
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama),
            'warna' => $request->warna,
            'status' => $request->status,
        ];

        if ($request->hasFile('icon')) {
            // Hapus icon lama jika ada
            if (Storage::disk('public')->exists($mapel->icon)) {
                Storage::disk('public')->delete($mapel->icon);
            }
            $data['icon'] = $request->file('icon')->store('mapel', 'public');
        }

        $mapel->update($data);

        return redirect()->route('admin.mapel.index')->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    public function destroy(Mapel $mapel)
    {
        if (Storage::disk('public')->exists($mapel->icon)) {
            Storage::disk('public')->delete($mapel->icon);
        }

        $mapel->delete();

        return redirect()->route('admin.mapel.index')->with('success', 'Mata pelajaran berhasil dihapus.');
    }
}