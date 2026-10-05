<?php

namespace App\Http\Controllers;

use App\Models\PendaftaranBimbel;
use Illuminate\Http\Request;

class PendaftaranBimbelController extends Controller
{
    // Menampilkan halaman riwayat/pesanan user (hanya milik user yang login)
    public function index()
    {
        $userId = auth()->id();
        $userEmail = auth()->user()?->email;

        $pesanans = PendaftaranBimbel::with('token')
            ->where(function ($query) use ($userId, $userEmail) {
                $query->where('user_id', $userId);
                if ($userEmail) {
                    $query->orWhere(function ($q) use ($userEmail) {
                        $q->whereNull('user_id')
                            ->where('email', $userEmail);
                    });
                }
            })
            ->latest()
            ->get();

        return view('guest.pesanan', compact('pesanans'));
    }

    // Menampilkan halaman form pendaftaran bimbel
    public function create(Request $request)
    {
        $paket = 'pemasaran';
        $harga = 10000;
        return view('bimbel.daftar', compact('paket', 'harga'));
    }

    // Menyimpan data dari form pendaftaran
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'no_wa' => 'required|numeric',
            'paket' => 'required|string',
        ]);

        // Simpan ke database dengan mencatat user_id jika user sedang login
        $pesanan = PendaftaranBimbel::create([
            'user_id' => auth()->id(),
            'nama' => $request->nama,
            'email' => $request->email,
            'no_wa' => $request->no_wa,
            'paket' => $request->paket,
            'status' => 'pending',
            'catatan' => null,
        ]);

        // Format nomor WhatsApp Admin (ganti sesuai nomor Admin official jika ada)
        $adminWa = '6281234567890';
        
        $pesanWa = "*PENDAFTARAN PEMASARAN BIMBEL - LESGO*\n\n" .
                   "Halo Admin LesGo,\n" .
                   "Saya telah mendaftarkan bimbel saya di platform LesGo dengan rincian berikut:\n\n" .
                   "📌 *ID Pesanan:* #ORD-" . str_pad($pesanan->id, 4, '0', STR_PAD_LEFT) . "\n" .
                   "👤 *Nama Lengkap:* {$request->nama}\n" .
                   "✉️ *Email:* {$request->email}\n" .
                   "📱 *No. WhatsApp:* {$request->no_wa}\n" .
                   "📦 *Paket:* Paket Pemasaran Bimbel (Rp 10.000 / bulan)\n\n" .
                   "Mohon untuk segera diproses persetujuannya agar saya dapat mengaktifkan akun bimbel saya. Terima kasih!";

        $waUrl = "https://wa.me/{$adminWa}?text=" . urlencode($pesanWa);

        // Redirect ke halaman pesanan dengan URL WhatsApp di session flash
        // JavaScript di halaman pesanan akan otomatis membuka WhatsApp
        return redirect()->route('pesanan')
            ->with('success', 'Pendaftaran berhasil disimpan! WhatsApp akan segera terbuka...')
            ->with('wa_url', $waUrl);
    }

    // Menampilkan halaman detail dan metode pembayaran
    public function bayar($id)
    {
        $pesanan = PendaftaranBimbel::findOrFail($id);

        // Keamanan: Cek kepemilikan pesanan jika user sedang login
        if (auth()->check()) {
            $user = auth()->user();
            if ($pesanan->user_id && (int) $pesanan->user_id !== (int) $user->id && $pesanan->email !== $user->email) {
                return redirect()->route('pesanan')
                    ->with('error', 'Anda tidak memiliki akses ke pesanan ini.');
            }
        }

        // Keamanan: Hanya pesanan dengan status 'diterima' yang boleh masuk ke halaman ini
        if ($pesanan->status !== 'diterima') {
            return redirect()->route('pesanan')
                ->with('error', 'Pesanan ini tidak dalam status siap dibayar.');
        }

        // Harga tetap: Paket Pemasaran Bimbel Rp 10.000/bulan
        $harga = 10000;

        return view('guest.pembayaran', compact('pesanan', 'harga'));
    }
}
