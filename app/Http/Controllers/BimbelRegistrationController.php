<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // Wajib ditambahkan

class BimbelRegistrationController extends Controller
{
    public function store(Request $request)
{
    // 1. Kita matikan validasi sementara untuk memastikan form benar-benar terkirim
    // $request->validate([...]);

    $target = $request->no_wa;
    if (substr($target, 0, 1) == '0') {
        $target = '62' . substr($target, 1);
    }

    $pesan = "Halo *$request->nama* 👋\n\nIni adalah pesan test dari sistem LesGo.";

    // 2. Kita gunakan dd() untuk menghentikan sistem dan melihat apa isi token
    $token = env('FONNTE_TOKEN');
    if (!$token) {
        dd("ERROR: Token Fonnte kosong! Pastikan sudah diisi di .env dan jalankan 'php artisan config:clear'");
    }

    // 3. Eksekusi Fonnte dengan menonaktifkan SSL Verify (Sering jadi masalah di localhost)
    $response = \Illuminate\Support\Facades\Http::withOptions([
        'verify' => false, // Mengatasi cURL error 60 di localhost
    ])->withHeaders([
        'Authorization' => $token,
    ])->post('https://api.fonnte.com/send', [
        'target'  => $target,
        'message' => $pesan,
        'countryCode' => '62',
    ]);

    // 4. Tampilkan hasil balasan dari server Fonnte
    dd([
        'status_http' => $response->status(),
        'balasan_fonnte' => $response->json()
    ]);
}
}
