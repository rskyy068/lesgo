<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\User\SettingsController;
use App\Http\Controllers\Admin\MapelController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\BimbelUserController;

// Controller untuk aksi User (Form Daftar & Lihat Pesanan)
use App\Http\Controllers\PendaftaranBimbelController;

// Controller untuk aksi Admin (Approve/Reject Pesanan)
use App\Http\Controllers\Admin\PendaftaranBimbelController as AdminPendaftaranBimbelController;

/*
|--------------------------------------------------------------------------
| Guest Routes (Publik)
|--------------------------------------------------------------------------
*/

// Halaman utama
Route::get('/', [HomeController::class, 'index'])->name('home');

// Daftar bimbel & mata pelajaran (guest public view)
Route::get('/bimbel', [HomeController::class, 'bimbel'])->name('bimbel.guest');
Route::get('/bimbel/{id}/pendaftaran', [HomeController::class, 'pendaftaranSiswa'])->name('bimbel.pendaftaran');
Route::get('/mata-pelajaran', [HomeController::class, 'mapel'])->name('mapel.guest');


/*
|--------------------------------------------------------------------------
| Authentication (Login & Register)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    // Login (POST diberi throttle 5x percobaan/menit untuk mencegah brute-force)
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('login.attempt');

    // Register
    Route::get('/register', [RegisterController::class, 'show'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])
        ->middleware('throttle:5,1')
        ->name('register.attempt');

});

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Dashboard user
    Route::get('/dashboard', function () {
        if (view()->exists('user.dashboard')) {
            return view('user.dashboard');
        }

        return redirect()->route('home')
            ->with('success', 'Berhasil masuk ke Dashboard!');
    })->name('dashboard');

    // Pengaturan user
    Route::get('/user/settings', [SettingsController::class, 'index'])
        ->name('user.settings');

    // Halaman Tabel Pesanan User (Sudah dihubungkan ke controller)
    Route::get('/pesanan', [PendaftaranBimbelController::class, 'index'])
        ->name('pesanan');

    // Daftarkan Bimbel - Form Pendaftaran User
    Route::get('/daftarkan-bimbel', [PendaftaranBimbelController::class, 'create'])
        ->name('bimbel.daftar');

    Route::post('/daftarkan-bimbel', [PendaftaranBimbelController::class, 'store'])
        ->name('bimbel.daftar.store');

        // Halaman Pembayaran
    Route::get('/pesanan/{id}/bayar', [PendaftaranBimbelController::class, 'bayar'])
        ->name('pesanan.bayar');


    // Manajemen Bimbel (CRUD)
    Route::resource('bimbeluser', \App\Http\Controllers\BimbelUserController::class);

    // Kirim Ulasan & Rating Bimbel
    Route::post('/bimbel/{id}/review', [\App\Http\Controllers\ReviewController::class, 'store'])
        ->name('bimbel.review.store');

});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/realtime-counts', [DashboardController::class, 'realtimeCounts'])->name('realtime-counts');

    // Manajemen User (CRUD)
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);

    // Manajemen Bimbel (CRUD) + Perpanjang Masa Aktif Membership 30 Hari
    Route::patch('/bimbel/{bimbel}/perpanjang', [\App\Http\Controllers\Admin\BimbelController::class, 'perpanjang'])
        ->name('bimbel.perpanjang');
    Route::resource('bimbel', \App\Http\Controllers\Admin\BimbelController::class);

    // Manajemen Mapel
    Route::resource('mapel', \App\Http\Controllers\Admin\MapelController::class);

    // Manajemen Pendaftaran Bimbel (Persetujuan Admin)
    Route::get('/pendaftaran-bimbel', [AdminPendaftaranBimbelController::class, 'index'])
        ->name('pendaftaran-bimbel.index');

    Route::patch('/pendaftaran-bimbel/{id}/approve', [AdminPendaftaranBimbelController::class, 'approve'])
        ->name('pendaftaran-bimbel.approve');

    // Tambahan: Route untuk Menolak Pendaftaran
    Route::patch('/pendaftaran-bimbel/{id}/reject', [AdminPendaftaranBimbelController::class, 'reject'])
        ->name('pendaftaran-bimbel.reject');

    Route::post('/pendaftaran-bimbel/{id}/generate-token', [AdminPendaftaranBimbelController::class, 'generateToken'])
        ->name('pendaftaran-bimbel.generate-token');

    Route::delete('/pendaftaran-bimbel/{id}', [AdminPendaftaranBimbelController::class, 'destroy'])
        ->name('pendaftaran-bimbel.destroy');

    // Server-side redirect WA kirim token (token tidak pernah muncul di HTML browser admin)
    Route::get('/pendaftaran-bimbel/{id}/kirim-token-wa', [AdminPendaftaranBimbelController::class, 'kirimTokenWa'])
        ->name('pendaftaran-bimbel.kirim-token-wa');

});


/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/

// Support GET (untuk link di navbar) dan POST (untuk form CSRF logout)
Route::match(['get', 'post'], '/logout', [LogoutController::class, 'logout'])->name('logout');
