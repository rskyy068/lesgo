<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PendaftaranBimbel;
use App\Models\BimbelToken;
use Illuminate\Support\Str;

class PendaftaranBimbelController extends Controller
{
    // Menampilkan daftar semua pendaftar di halaman admin
    public function index()
    {
        $pendaftarans = PendaftaranBimbel::with('token')->latest()->get();
        return view('admin.pendaftaran.index', compact('pendaftarans'));
    }

    // Menyetujui pendaftaran & otomatis generate token jika belum ada
    public function approve($id)
    {
        $pendaftaran = PendaftaranBimbel::findOrFail($id);
        $pendaftaran->update([
            'status' => 'diterima'
        ]);

        // Auto generate token jika belum ada
        if (!$pendaftaran->token) {
            $this->createTokenForPendaftaran($pendaftaran);
        }

        return back()->with('success', 'Pendaftaran bimbel berhasil disetujui dan token telah dibuat. Kirimkan token ke pendaftar via WhatsApp.');
    }

    // Menolak pendaftaran
    public function reject($id)
    {
        $pendaftaran = PendaftaranBimbel::findOrFail($id);
        $pendaftaran->update([
            'status' => 'ditolak'
        ]);

        return back()->with('error', 'Pendaftaran bimbel telah ditolak.');
    }

    // Generate token secara manual oleh admin
    public function generateToken($id)
    {
        $pendaftaran = PendaftaranBimbel::findOrFail($id);

        if ($pendaftaran->status !== 'diterima') {
            return back()->with('error', 'Token hanya dapat dibuat untuk pendaftaran yang berstatus diterima.');
        }

        if ($pendaftaran->token) {
            return back()->with('error', 'Token sudah dibuat sebelumnya. Gunakan tombol Kirim WA untuk mengirimkan token ke pendaftar.');
        }

        $this->createTokenForPendaftaran($pendaftaran);

        return back()->with('success', 'Token berhasil dibuat. Gunakan tombol Kirim WA untuk mengirimkan token ke pendaftar.');
    }

    /**
     * Server-side redirect: Buat URL WhatsApp yang mengandung token,
     * lalu redirect ke WhatsApp. Token TIDAK pernah dikirim ke browser admin dalam HTML.
     */
    public function kirimTokenWa($id)
    {
        $pendaftaran = PendaftaranBimbel::with('token')->findOrFail($id);

        if (!$pendaftaran->token) {
            return back()->with('error', 'Token belum tersedia. Setujui pendaftaran terlebih dahulu.');
        }

        // Format nomor WA ke format internasional
        $cleanPhone = preg_replace('/[^0-9]/', '', $pendaftaran->no_wa);
        if (str_starts_with($cleanPhone, '0')) {
            $cleanPhone = '62' . substr($cleanPhone, 1);
        }

        $token = $pendaftaran->token->token;

        $waMessage = "Halo *{$pendaftaran->nama}*,\n\nTerima kasih telah mendaftar di *LesGo* (Paket *" . strtoupper($pendaftaran->paket) . "*).\n\nPembayaran & Pendaftaran Anda telah disetujui! Berikut adalah *Token Akses Pembuatan Bimbel* Anda:\n\n🔑 *TOKEN:* `{$token}`\n\nGunakan token ini untuk membuat/mendaftarkan profil Bimbel Anda di platform LesGo.\n\nJika ada pertanyaan, silakan hubungi tim kami. Terima kasih!";

        $waUrl = "https://wa.me/{$cleanPhone}?text=" . rawurlencode($waMessage);

        // Redirect langsung ke WhatsApp — token tidak pernah muncul di HTML browser admin
        return redirect()->away($waUrl);
    }

    // Hapus data pendaftaran bimbel
    public function destroy($id)
    {
        $pendaftaran = PendaftaranBimbel::findOrFail($id);
        $nama = $pendaftaran->nama;
        $pendaftaran->delete();

        return back()->with('success', 'Data pendaftaran bimbel "' . $nama . '" berhasil dihapus.');
    }

    /**
     * Helper untuk membuat BimbelToken unik.
     */
    private function createTokenForPendaftaran(PendaftaranBimbel $pendaftaran): BimbelToken
    {
        do {
            $tokenStr = 'LESGO-' . strtoupper(Str::random(8));
        } while (BimbelToken::where('token', $tokenStr)->exists());

        return BimbelToken::create([
            'pendaftaran_bimbel_id' => $pendaftaran->id,
            'token'                 => $tokenStr,
            'status'                => 'unused',
            'expires_at'            => now()->addDays(30),
        ]);
    }
}
