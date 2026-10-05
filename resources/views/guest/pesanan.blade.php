@extends('layouts.guest')

@section('title', 'Pesanan Saya - LesGo')

@push('style')
<style>
    .order-header {
        background: linear-gradient(135deg, #DDFFF7 0%, #ffffff 70%, #ffe9e7 100%);
        padding: 60px 0 40px;
        position: relative;
        overflow: hidden;
    }

    .order-header::before {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 250px;
        height: 250px;
        background: radial-gradient(circle, rgba(255, 166, 158, 0.15) 0%, transparent 70%);
        border-radius: 50%;
        z-index: 0;
    }

    .order-header .container {
        position: relative;
        z-index: 1;
    }

    .order-section {
        padding: 40px 0 80px;
        background-color: #f8fbfb;
        min-height: 60vh;
    }

    /* Tabel Modern & Tidak Kaku */
    .custom-table-wrapper {
        background: #ffffff;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 25px -10px rgba(47, 72, 88, 0.05);
        border: 1px solid rgba(147, 225, 216, 0.2);
    }

    .table-modern {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 12px; /* Memberikan jarak antar baris */
    }

    .table-modern thead th {
        border: none;
        color: #6b8496;
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 0 20px 10px;
    }

    .table-modern tbody tr {
        background-color: #ffffff;
        box-shadow: 0 2px 10px rgba(47, 72, 88, 0.04);
        border-radius: 12px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .table-modern tbody tr:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(47, 72, 88, 0.08);
    }

    .table-modern tbody td {
        padding: 18px 20px;
        vertical-align: middle;
        color: #2F4858;
        border-top: 1px solid rgba(147, 225, 216, 0.1);
        border-bottom: 1px solid rgba(147, 225, 216, 0.1);
    }

    /* Membulatkan ujung baris tabel */
    .table-modern tbody td:first-child {
        border-left: 1px solid rgba(147, 225, 216, 0.1);
        border-radius: 12px 0 0 12px;
    }

    .table-modern tbody td:last-child {
        border-right: 1px solid rgba(147, 225, 216, 0.1);
        border-radius: 0 12px 12px 0;
    }

    /* Badge Status Lembut */
    .status-badge {
        padding: 6px 14px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 600;
        display: inline-block;
    }

    .status-menunggu {
        background-color: rgba(255, 193, 7, 0.15);
        color: #b4861f;
    }

    .status-aktif {
        background-color: rgba(147, 225, 216, 0.25);
        color: #3b877c;
    }

    .status-selesai {
        background-color: rgba(47, 72, 88, 0.1);
        color: #2F4858;
    }

    .status-batal {
        background-color: rgba(255, 166, 158, 0.2);
        color: #d87e76;
    }

    .btn-aksi {
        background-color: #f8fbfb;
        color: #2F4858;
        border: 1px solid rgba(47, 72, 88, 0.15);
        border-radius: 8px;
        padding: 6px 16px;
        font-size: 13px;
        font-weight: 600;
        transition: all 0.2s;
    }

    .btn-aksi:hover {
        background-color: #2F4858;
        color: #ffffff;
    }
</style>
@endpush

@section('content')

<!-- Header Pesanan -->
<section class="order-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="d-inline-block rounded-pill px-3 py-2 mb-3"
                      style="background: rgba(147, 225, 216, 0.25); color: #3b877c; font-weight: 600; font-size: 14px;">
                    <i class="bi bi-bag-check-fill me-2"></i>Riwayat Pembelajaran
                </span>
                <h2 class="display-6 fw-bold mb-2" style="color: #2F4858;">Pesanan Saya</h2>
                <p class="mb-0" style="color: #6b8496;">Pantau status pendaftaran dan riwayat belajar Anda di LesGo.</p>
            </div>
        </div>
    </div>
</section>

<!-- Tabel Pesanan -->
<section class="order-section">
    <div class="container">

        {{-- Banner WhatsApp Fallback (muncul setelah submit pendaftaran) --}}
        @if(session('wa_url'))
        <div id="waBannerFallback" class="alert border-0 rounded-4 shadow-sm mb-4 d-flex align-items-center justify-content-between flex-wrap gap-3"
             style="background: linear-gradient(135deg, #dcfce7 0%, #f0fdf4 100%); border: 1px solid #86efac !important;">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: #25D366;">
                    <i class="bi bi-whatsapp text-white fs-4"></i>
                </div>
                <div>
                    <strong class="d-block" style="color: #166534;">Pendaftaran Berhasil Disimpan!</strong>
                    <span class="small" style="color: #15803d;">Klik tombol di bawah untuk mengirim data pendaftaran ke Admin via WhatsApp.</span>
                </div>
            </div>
            <a href="{{ session('wa_url') }}" target="_blank" class="btn text-white fw-bold rounded-pill px-4 py-2 shadow-sm"
               style="background: #25D366; font-size: 14px; text-decoration: none;">
                <i class="bi bi-whatsapp me-2"></i> Buka WhatsApp Sekarang
            </a>
        </div>
        @endif

        <div class="custom-table-wrapper">
            <div class="table-responsive">
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th>ID Pesanan</th>
                            <th>Program Bimbel</th>
                            <th>Tanggal</th>
                            <th>Total Bayar</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
    @forelse ($pesanans as $pesanan)
        <tr>
            <!-- ID Pesanan Dinamis berdasarkan ID di Database -->
            <td class="fw-bold">#ORD-{{ str_pad($pesanan->id, 4, '0', STR_PAD_LEFT) }}</td>

            <!-- Nama Paket dan Nama Pendaftar -->
            <td>
                <div class="fw-bold" style="color: #2F4858;">Paket Pemasaran Bimbel</div>
                <div class="small text-muted">{{ $pesanan->nama }}</div>
            </td>

            <!-- Tanggal Pendaftaran Dinamis -->
            <td>{{ $pesanan->created_at->format('d M Y') }}</td>

            <!-- Harga Paket Pemasaran Bimbel -->
            <td class="fw-bold text-success">
                Rp 10.000
            </td>

            <!-- Pewarnaan Badge Status sesuai Database -->
            <td>
                @if($pesanan->status === 'pending' || empty($pesanan->status))
                    <span class="status-badge status-menunggu">Menunggu Persetujuan</span>
                @elseif($pesanan->status === 'diterima')
                    <span class="status-badge status-aktif">Telah Disetujui</span>
                @elseif($pesanan->status === 'ditolak')
                    <span class="status-badge status-batal">Ditolak</span>
                @endif
            </td>

            <!-- Tombol Aksi Berdasarkan Status -->
            <td class="text-center">
                @if($pesanan->status === 'pending' || empty($pesanan->status))
                    @php
                        $waText = urlencode("Halo Admin LesGo,\nSaya telah menginput pendaftaran Paket Pemasaran Bimbel dengan rincian:\n" .
                            "📌 *ID Pesanan:* #ORD-" . str_pad($pesanan->id, 4, '0', STR_PAD_LEFT) . "\n" .
                            "👤 *Nama:* " . $pesanan->nama . "\n" .
                            "✉️ *Email:* " . $pesanan->email . "\n" .
                            "📱 *No. WA:* " . $pesanan->no_wa . "\n\n" .
                            "Mohon untuk diproses persetujuannya. Terima kasih!");
                        $adminWaUrl = "https://wa.me/6281234567890?text={$waText}";
                    @endphp
                    <a href="{{ $adminWaUrl }}" target="_blank" class="btn btn-sm text-white rounded-pill px-3 shadow-sm" style="background-color: #25D366; font-size: 12px; font-weight: 600;">
                        <i class="bi bi-whatsapp me-1"></i> Kirim ke WA Admin
                    </a>
                @elseif($pesanan->status === 'diterima')
                    @if($pesanan->token)
                        <div class="mb-1">
                            <span class="badge bg-light text-dark border px-2 py-1" style="font-family: monospace; font-size: 11px;">
                                <i class="bi bi-key-fill text-warning me-1"></i>{{ $pesanan->token->token }}
                            </span>
                        </div>
                        @if($pesanan->token->status === 'unused')
                            <a href="{{ route('bimbeluser.create', ['token' => $pesanan->token->token]) }}" class="btn btn-sm text-white rounded-pill px-3" style="background-color: #FF9980; font-size: 12px;">
                                <i class="bi bi-plus-circle me-1"></i> Buat Bimbel
                            </a>
                        @else
                            <span class="badge bg-secondary-subtle text-secondary">Token Telah Digunakan</span>
                        @endif
                    @else
                        <a href="{{ route('pesanan.bayar', $pesanan->id) }}" class="btn btn-sm text-white rounded-pill px-3" style="background-color: #2F4858; font-size: 12px;">Lanjut Bayar</a>
                    @endif
                @elseif($pesanan->status === 'ditolak')
                    <button class="btn btn-aksi text-white bg-danger" disabled>Dibatalkan</button>
                @endif
            </td>
        </tr>
    @empty
        <!-- Tampilan jika database masih kosong / belum ada yang mendaftar -->
        <tr>
            <td colspan="6" class="text-center py-5 text-muted">
                <i class="bi bi-inbox fs-1 d-block mb-3 text-secondary"></i>
                Belum ada pesanan bimbel untuk akun Anda.
            </td>
        </tr>
    @endforelse
</tbody>
                </table>
            </div>

            @if($pesanans->count() > 0)
            <!-- Pagination / Summary -->
            <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top" style="border-color: rgba(147, 225, 216, 0.2) !important;">
                <span class="small text-muted">Total: {{ $pesanans->count() }} pesanan</span>
            </div>
            @endif
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Cek apakah ada wa_url dari session flash (setelah submit form pendaftaran bimbel)
    @if(session('wa_url'))
        // Tampilkan banner WhatsApp fallback
        const waBanner = document.getElementById('waBannerFallback');
        if (waBanner) waBanner.style.display = 'block';

        // Auto-open WhatsApp setelah 500ms delay
        setTimeout(function() {
            window.open(@json(session('wa_url')), '_blank');
        }, 500);
    @endif
});
</script>
@endpush
