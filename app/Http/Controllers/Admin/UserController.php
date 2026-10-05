<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Tampilkan daftar semua user dengan pencarian & filter.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Pencarian: nama / email / phone
        if ($request->filled('search')) {
            $term = '%' . $request->search . '%';
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', $term)
                  ->orWhere('email', 'like', $term)
                  ->orWhere('phone', 'like', $term);
            });
        }

        // Filter role
        if ($request->filled('role') && in_array($request->role, ['admin', 'user'], true)) {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        // Statistik ringkas untuk header
        $stats = [
            'total' => User::count(),
            'admin' => User::where('role', 'admin')->count(),
            'user'  => User::where('role', 'user')->count(),
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }

    /**
     * Tampilkan form tambah user.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Simpan user baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email',
            'phone'    => 'nullable|string|max:20',
            'role'     => 'required|in:admin,user',
            'password' => ['required', 'confirmed', Password::min(8)],
            // Validasi file foto: maksimal 2 MB, format gambar umum
            'photo'    => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'name.required'      => 'Nama wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email sudah terdaftar.',
            'role.required'      => 'Pilih role user.',
            'role.in'            => 'Role tidak valid.',
            'password.required'  => 'Kata sandi wajib diisi.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'photo.image'        => 'File harus berupa gambar.',
            'photo.mimes'        => 'Format gambar harus jpeg, png, gif, atau webp.',
            'photo.max'          => 'Ukuran gambar maksimal 2 MB.',
        ]);

        // Simpan file foto jika ada
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            $validated['photo'] = $path;
        }

        // 'hashed' cast di model User otomatis melakukan bcrypt.
        User::create($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User "' . $validated['name'] . '" berhasil ditambahkan.');
    }

    /**
     * Detail user.
     */
    public function show(User $user)
    {
        $user->loadCount(['reviews', 'favorites']);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Form edit user.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update data user.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => [
                'required', 'string', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'phone'    => 'nullable|string|max:20',
            'role'     => 'required|in:admin,user',
            'password' => ['nullable', 'confirmed', Password::min(8)],
            // Validasi URL foto: hanya izinkan protokol http(s) untuk mencegah XSS via javascript:
            'photo'    => 'nullable|string|max:255|url:http,https',
        ], [
            'name.required'      => 'Nama wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email sudah digunakan user lain.',
            'role.required'      => 'Pilih role user.',
            'role.in'            => 'Role tidak valid.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'photo.url'          => 'URL foto tidak valid.',
        ]);

        // Self-protection: admin tidak bisa mengubah role-nya sendiri.
        if ($user->id === Auth::id() && ($validated['role'] ?? null) !== 'admin') {
            return back()->withErrors(['role' => 'Anda tidak dapat mengubah role akun Anda sendiri.'])
                ->withInput();
        }

        // Hanya update password bila diisi.
        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'Data user "' . $validated['name'] . '" berhasil diperbarui.');
    }

    /**
     * Hapus user.
     */
    public function destroy(User $user)
    {
        // Self-protection
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // Pastikan setidaknya masih ada 1 admin
        if ($user->isAdmin() && User::where('role', 'admin')->count() <= 1) {
            return back()->with('error', 'Tidak dapat menghapus admin terakhir. Sistem minimal memerlukan 1 admin.');
        }

        $name = $user->name;
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User "' . $name . '" berhasil dihapus.');
    }
}
