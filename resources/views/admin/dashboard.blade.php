@extends('layouts.admin')

@section('title', 'Dashboard Admin - LESGO')

@push('style')
<style>
    /* Custom Styling for Dashboard Elements */
    .metric-card {
        transition: var(--transition);
        border: 1px solid rgba(147, 225, 216, 0.12);
        overflow: hidden;
        position: relative;
    }

    .metric-card::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 4px;
        background-color: transparent;
        transition: var(--transition);
    }

    .metric-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-sm);
    }

    .metric-card.card-user:hover::after { background-color: var(--accent); }
    .metric-card.card-bimbel:hover::after { background-color: #55a096; }
    .metric-card.card-review:hover::after { background-color: #ffc107; }
    .metric-card.card-mapel:hover::after { background-color: #0dcaf0; }

    .icon-box {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        transition: var(--transition);
    }

    .metric-card:hover .icon-box {
        transform: scale(1.1) rotate(5deg);
    }

    /* Table styling - Optimized for responsiveness */
    .table-responsive {
        border-radius: 12px;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .custom-table {
        margin-bottom: 0;
        vertical-align: middle;
        white-space: nowrap; /* Mencegah teks tabel bertumpuk di layar kecil */
    }

    .custom-table th {
        background-color: rgba(147, 225, 216, 0.1);
        color: var(--dark);
        font-weight: 600;
        font-size: 13px;
        padding: 12px 16px;
        border: none;
    }

    .custom-table td {
        padding: 12px 16px;
        border-bottom: 1px solid rgba(147, 225, 216, 0.1);
        font-size: 13.5px;
    }

    .custom-table tr:last-child td {
        border-bottom: none;
    }

    .custom-table tbody tr:hover {
        background-color: rgba(230, 247, 243, 0.3);
    }

    /* Chart Container Fluid Height */
    .chart-container-fluid {
        position: relative;
        height: 30vh;
        min-height: 220px;
        max-height: 280px;
        width: 100%;
    }

    /* Right Sidebar Widgets - Compact Padding */
    .widget-section {
        margin-bottom: 20px;
        background: var(--white);
        border-radius: 14px;
        padding: 16px;
        box-shadow: 0 2px 8px rgba(47, 72, 88, 0.02);
        border: 1px solid rgba(147, 225, 216, 0.1);
    }

    .widget-title {
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 12px;
        color: var(--dark);
        display: flex;
        align-items: center;
        gap: 8px;
        border-bottom: 1px solid rgba(147, 225, 216, 0.2);
        padding-bottom: 8px;
    }

    .widget-title i {
        color: var(--accent);
    }

    /* Todo & Activity - Slightly smaller fonts to fit screen */
    .todo-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 8px 10px;
        border-radius: 8px;
        background-color: var(--bg-main);
        transition: var(--transition);
        margin-bottom: 8px;
    }

    .todo-checkbox {
        margin-top: 2px;
        width: 16px;
        height: 16px;
        cursor: pointer;
    }

    .todo-text {
        font-size: 12.5px;
        font-weight: 500;
        cursor: pointer;
    }

    .todo-item.completed .todo-text {
        text-decoration: line-through;
        color: var(--dark-muted);
    }

    .activity-feed {
        position: relative;
        padding-left: 14px;
    }

    .activity-feed::before {
        content: '';
        position: absolute;
        left: 4px;
        top: 8px;
        bottom: 8px;
        width: 2px;
        background-color: rgba(147, 225, 216, 0.3);
    }

    .activity-item {
        position: relative;
        padding-bottom: 12px;
    }

    .activity-dot {
        position: absolute;
        left: -14px;
        top: 4px;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: var(--accent);
        border: 2px solid var(--white);
    }

    .activity-content { font-size: 12px; }
    .activity-time { font-size: 10.5px; color: var(--dark-muted); }
    .reminder-badge { font-size: 10.5px; padding: 2px 6px; border-radius: 6px; font-weight: 600; }
</style>
@endpush

@section('content')
<!-- Header Area -->
<div class="row align-items-center mb-3">
    <div class="col-12 col-md-8 mb-2 mb-md-0">
        <h1 class="fw-bold h3 mb-1" style="color: var(--dark);">👋 Halo, Admin</h1>
        <p class="text-muted small mb-0">Selamat datang kembali! Berikut ringkasan performa LesGo hari ini (Data Real-Time).</p>
    </div>
    <div class="col-12 col-md-4 text-md-end">
        <div class="bg-white px-3 py-2 rounded-3 shadow-sm border d-inline-flex align-items-center gap-2">
            <span class="badge bg-success-subtle text-success border border-success me-1" id="realtime-status-indicator" style="font-size: 11px;">
                <i class="bi bi-broadcast me-1"></i>Live Real-Time
            </span>
            <i class="bi bi-calendar-event text-secondary"></i>
            <span class="fw-semibold text-secondary small" id="current-date"></span>
        </div>
    </div>
</div>

<!-- Metrik Ringkasan (Row of 4 Cards - Dynamic Real-Time Count) -->
<div class="row g-2 g-md-3 mb-3">
    <!-- User Card -->
    <div class="col-6 col-lg-3">
        <div class="card main-card metric-card card-user border-0 p-2 p-md-3 h-100">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="icon-box bg-accent-light text-accent">
                    <i class="bi bi-people-fill" style="color: #ea8a80;"></i>
                </div>
                <span class="badge rounded-pill bg-success-subtle text-success" style="font-size: 10px;">
                    <i class="bi bi-arrow-up"></i> Real-time
                </span>
            </div>
            <div>
                <p class="text-muted small mb-0 fw-medium" style="font-size: 11px;">Total User</p>
                <h4 class="fw-bold mb-0" id="realtime-total-user" style="color: var(--dark);">{{ number_format($totalUser) }}</h4>
            </div>
        </div>
    </div>

    <!-- Bimbel Card -->
    <div class="col-6 col-lg-3">
        <div class="card main-card metric-card card-bimbel border-0 p-2 p-md-3 h-100">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="icon-box bg-primary-light text-primary">
                    <i class="bi bi-mortarboard-fill" style="color: #55a096;"></i>
                </div>
                <span class="badge rounded-pill bg-info-subtle text-info" style="font-size: 10px;">
                    <i class="bi bi-clock-history me-1"></i>30-Hari Limit
                </span>
            </div>
            <div>
                <p class="text-muted small mb-0 fw-medium" style="font-size: 11px;">Total Bimbel</p>
                <h4 class="fw-bold mb-0" id="realtime-total-bimbel" style="color: var(--dark);">{{ number_format($totalBimbel) }}</h4>
            </div>
        </div>
    </div>

    <!-- Review Card -->
    <div class="col-6 col-lg-3">
        <div class="card main-card metric-card card-review border-0 p-2 p-md-3 h-100">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="icon-box bg-warning-subtle text-warning">
                    <i class="bi bi-chat-left-heart-fill"></i>
                </div>
                <span class="badge rounded-pill bg-warning-subtle text-warning" style="font-size: 10px;">
                    <i class="bi bi-star-fill me-1"></i>Ulasan
                </span>
            </div>
            <div>
                <p class="text-muted small mb-0 fw-medium" style="font-size: 11px;">Total Review</p>
                <h4 class="fw-bold mb-0" id="realtime-total-review" style="color: var(--dark);">{{ number_format($totalReview) }}</h4>
            </div>
        </div>
    </div>

    <!-- Mapel Card -->
    <div class="col-6 col-lg-3">
        <div class="card main-card metric-card card-mapel border-0 p-2 p-md-3 h-100">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="icon-box bg-info-subtle text-info">
                    <i class="bi bi-book-fill"></i>
                </div>
                <span class="badge rounded-pill bg-secondary-subtle text-secondary" style="font-size: 10px;">
                    Kategori
                </span>
            </div>
            <div>
                <p class="text-muted small mb-0 fw-medium" style="font-size: 11px;">Total Mapel</p>
                <h4 class="fw-bold mb-0" id="realtime-total-mapel" style="color: var(--dark);">{{ number_format($totalMapel) }}</h4>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-3">
    <!-- Grafik Pengguna -->
    <div class="col-12 col-xl-8">
        <div class="card main-card border-0 p-3 p-md-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h6 class="fw-bold mb-0" style="color: var(--dark);">Grafik Pengguna</h6>
                    <p class="text-muted small mb-0" style="font-size: 11px;">Tren pertumbuhan 2026</p>
                </div>
                <select class="form-select form-select-sm w-auto rounded-pill border-0 bg-light shadow-none">
                    <option selected>Tahun Ini</option>
                    <option>Bulan Ini</option>
                    <option>Minggu Ini</option>
                </select>
            </div>
            <div class="chart-container-fluid">
                <canvas id="userGrowthChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Kategori Populer -->
    <div class="col-12 col-xl-4">
        <div class="card main-card border-0 p-3 p-md-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h6 class="fw-bold mb-0" style="color: var(--dark);">Kategori Populer</h6>
                    <p class="text-muted small mb-0" style="font-size: 11px;">Pembagian bimbel</p>
                </div>
            </div>
            <div class="chart-container-fluid d-flex align-items-center justify-content-center">
                <canvas id="mapelChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Data Bimbel Terbaru (Diperbaiki dengan Table & Looping) -->
<div class="card main-card border-0 p-3 p-md-4 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold mb-0" style="color: var(--dark);">Pendaftaran Bimbel Terbaru</h6>
        <a href="{{ route('admin.pendaftaran-bimbel.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3" style="font-size: 12px;">
            Lihat Semua Pendaftaran & Token <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>
    <div class="table-responsive">
        <table class="table custom-table align-middle">
            <thead>
                <tr>
                    <th>Nama & Email</th>
                    <th>Paket</th>
                    <th>Status</th>
                    <th>Token</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendaftaran as $item)
                    <tr>
                        <td>
                            <div class="fw-semibold text-dark">{{ $item->nama }}</div>
                            <div class="text-muted" style="font-size: 11px;">{{ $item->email }}</div>
                        </td>
                        <td>
                            <span class="badge rounded-pill" style="background:#93E1D8;color:#2F4858;">
                                Paket {{ strtoupper($item->paket) }}
                            </span>
                        </td>
                        <td>
                            @if($item->status === 'pending' || empty($item->status))
                                <span class="badge rounded-pill bg-warning-subtle text-warning">Pending</span>
                            @elseif($item->status === 'diterima')
                                <span class="badge rounded-pill bg-success-subtle text-success">Diterima</span>
                            @else
                                <span class="badge rounded-pill bg-danger-subtle text-danger">Ditolak</span>
                            @endif
                        </td>
                        <td>
                            @if($item->token)
                                @if($item->token->status === 'unused')
                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2" style="font-size:11px;"><i class="bi bi-shield-check-fill me-1"></i>Aktif</span>
                                @elseif($item->token->status === 'used')
                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill px-2" style="font-size:11px;"><i class="bi bi-shield-slash-fill me-1"></i>Digunakan</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-2" style="font-size:11px;"><i class="bi bi-shield-x-fill me-1"></i>Kedaluwarsa</span>
                                @endif
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex justify-content-center gap-2 flex-wrap">
                                @if($item->status === 'pending' || empty($item->status))
                                    @php
                                        $cleanPhoneDash = preg_replace('/[^0-9]/', '', $item->no_wa);
                                        if (str_starts_with($cleanPhoneDash, '0')) {
                                            $cleanPhoneDash = '62' . substr($cleanPhoneDash, 1);
                                        }
                                        $pendingDashWaMsg = "Halo *" . $item->nama . "*,\n\nKami dari Tim Admin *LesGo* ingin mengonfirmasi pendaftaran Bimbel Anda (Paket *" . strtoupper($item->paket) . "*).\n\nApakah ada data atau pertanyaan yang ingin disampaikan sebelum pendaftaran Anda kami proses lebih lanjut? Terima kasih!";
                                        $pendingDashWaUrl = "https://wa.me/" . $cleanPhoneDash . "?text=" . rawurlencode($pendingDashWaMsg);
                                    @endphp
                                    <a href="{{ $pendingDashWaUrl }}" target="_blank" class="btn btn-sm btn-success rounded-pill px-2 py-0 text-white" style="font-size: 12px; height: 26px;" title="Hubungi Pendaftar via WhatsApp">
                                        <i class="bi bi-whatsapp"></i> Chat WA
                                    </a>

                                    <!-- Tombol Setuju -->
                                    <form method="POST" action="{{ route('admin.pendaftaran-bimbel.approve', $item->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-outline-success rounded-pill px-2 py-0" style="font-size: 12px; height: 26px;" title="Setujui & Generate Token">
                                            <i class="bi bi-check-lg"></i> Setujui
                                        </button>
                                    </form>

                                    <!-- Tombol Tolak -->
                                    <form method="POST" action="{{ route('admin.pendaftaran-bimbel.reject', $item->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-2 py-0" style="font-size: 12px; height: 26px;">
                                            <i class="bi bi-x-lg"></i> Tolak
                                        </button>
                                    </form>
                                @endif

                                @if($item->token)
                                    {{-- Server-side redirect: token tidak pernah muncul di HTML --}}
                                    <a href="{{ route('admin.pendaftaran-bimbel.kirim-token-wa', $item->id) }}"
                                       class="btn btn-sm btn-success rounded-pill px-2 py-0 text-white"
                                       style="font-size: 12px; height: 26px;"
                                       title="Kirim Token ke Pendaftar via WhatsApp">
                                        <i class="bi bi-whatsapp"></i> WA Token
                                    </a>
                                @endif

                                <!-- Tombol Detail (tanpa token) -->
                                <button type="button" class="btn btn-sm btn-light rounded-pill px-2 py-0 text-secondary border" style="font-size: 12px; height: 26px;"
                                    onclick="openDetailModal(
                                        '{{ addslashes($item->nama) }}',
                                        '{{ addslashes($item->email) }}',
                                        '{{ addslashes($item->no_wa) }}',
                                        '{{ strtoupper($item->paket) }}',
                                        '{{ $item->status }}',
                                        '{{ addslashes($item->catatan ?? "-") }}'
                                    )">
                                    <i class="bi bi-eye"></i> Detail
                                </button>

                                <!-- Tombol Hapus -->
                                <form method="POST" action="{{ route('admin.pendaftaran-bimbel.destroy', $item->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pendaftaran {{ addslashes($item->nama) }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-2 py-0" style="font-size: 12px; height: 26px;" title="Hapus Pendaftaran">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">Belum ada pendaftaran terbaru.</td>
                    </tr>
                @endforelse
    </div>
</div>

<!-- Card Pengingat Masa Aktif Membership Bimbel (30 Hari) -->
<div class="card main-card border-0 p-3 p-md-4 mb-4" style="background: linear-gradient(135deg, #ffffff 0%, #fffbfb 100%); border-left: 4px solid #FFA69E !important;">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h6 class="fw-bold mb-1" style="color: var(--dark);">
                <i class="bi bi-clock-history me-2 text-danger"></i>Pengingat Tenggat Membership Bimbel
            </h6>
            <p class="text-muted small mb-0" style="font-size: 11px;">
                Bimbel hanya tampil selama 30 hari. Pemilik harus membayar perpanjangan atau bimbel dapat dihapus.
            </p>
        </div>
        <a href="{{ route('admin.bimbel.index') }}" class="btn btn-sm btn-outline-danger rounded-pill px-3" style="font-size: 12px;">
            Kelola Semua Bimbel <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>

    <div class="table-responsive">
        <table class="table custom-table align-middle">
            <thead>
                <tr>
                    <th>Bimbel & Pemilik</th>
                    <th>Tanggal Daftar</th>
                    <th>Tenggat (Masa Aktif)</th>
                    <th>Sisa Waktu</th>
                    <th class="text-center">Aksi Admin</th>
                </tr>
            </thead>
            <tbody>
                @forelse($expiringBimbels as $expBimbel)
                    <tr>
                        <td>
                            <div class="fw-semibold text-dark">{{ $expBimbel->nama }}</div>
                            <div class="text-muted" style="font-size: 11px;">
                                <i class="bi bi-person me-1"></i>{{ $expBimbel->user->name ?? 'Admin/Sistem' }} ({{ $expBimbel->user->email ?? '-' }})
                            </div>
                        </td>
                        <td>
                            <span class="text-secondary small">{{ $expBimbel->created_at->format('d M Y') }}</span>
                        </td>
                        <td>
                            <span class="text-secondary small">
                                {{ $expBimbel->expires_at ? $expBimbel->expires_at->format('d M Y H:i') : $expBimbel->created_at->addDays(30)->format('d M Y H:i') }}
                            </span>
                        </td>
                        <td>
                            @if($expBimbel->isExpired())
                                <span class="badge rounded-pill bg-danger-subtle text-danger px-3 py-1" style="font-size: 11.5px;">
                                    <i class="bi bi-exclamation-triangle-fill me-1"></i>Kedaluwarsa (0 Hari)
                                </span>
                            @else
                                <span class="badge rounded-pill bg-warning-subtle text-warning px-3 py-1" style="font-size: 11.5px;">
                                    <i class="bi bi-hourglass-split me-1"></i>Sisa {{ $expBimbel->remainingDays() }} Hari
                                </span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <!-- Tombol Perpanjang 30 Hari -->
                                <form method="POST" action="{{ route('admin.bimbel.perpanjang', $expBimbel->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-success rounded-pill px-3 py-1" style="font-size: 11.5px;" title="Perpanjang Membership 30 Hari">
                                        <i class="bi bi-arrow-repeat me-1"></i>Perpanjang +30 Hari
                                    </button>
                                </form>

                                <!-- Tombol Hapus jika Kedaluwarsa -->
                                <form method="POST" action="{{ route('admin.bimbel.destroy', $expBimbel->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus bimbel {{ addslashes($expBimbel->nama) }} karena masa aktif habis?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-2 py-1" style="font-size: 11.5px;" title="Hapus Bimbel Kedaluwarsa">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
                            <i class="bi bi-check-circle text-success me-1"></i> Tidak ada bimbel yang kedaluwarsa atau mendekati tenggat pembayaran.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ===== SINGLE DYNAMIC MODAL (Hanya 1 di DOM) ===== --}}
<div class="modal fade" id="dynamicDetailModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold">Detail Pendaftaran</h6>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-start" style="font-size: 13px;">
                <div class="mb-2">
                    <small class="text-muted d-block" style="font-size: 11px;">Nama Pendaftar</small>
                    <span class="fw-bold" id="modal-nama"></span>
                </div>
                <div class="mb-2">
                    <small class="text-muted d-block" style="font-size: 11px;">Email</small>
                    <span id="modal-email"></span>
                </div>
                <div class="mb-2">
                    <small class="text-muted d-block" style="font-size: 11px;">WhatsApp</small>
                    <span id="modal-wa"></span>
                </div>
                <div class="mb-2">
                    <small class="text-muted d-block" style="font-size: 11px;">Paket</small>
                    <span class="badge rounded-pill" style="background:#93E1D8;color:#2F4858;" id="modal-paket"></span>
                </div>
                <div class="mb-2">
                    <small class="text-muted d-block" style="font-size: 11px;">Status</small>
                    <span id="modal-status"></span>
                </div>
                <div>
                    <small class="text-muted d-block" style="font-size: 11px;">Catatan</small>
                    <span class="text-muted" id="modal-catatan"></span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('right-sidebar')
<!-- Profile Widget -->
<div class="text-center mb-3 pb-3 border-bottom">
    <div class="position-relative d-inline-block mb-2">
        <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150" alt="Admin Avatar" class="rounded-circle shadow-sm border border-2 border-white" style="width: 60px; height: 60px; object-fit: cover;">
        <span class="position-absolute bottom-0 end-0 bg-success border border-2 border-white rounded-circle p-1" title="Online"></span>
    </div>
    <h6 class="fw-bold mb-0 text-dark">{{ Auth::user()->name ?? 'Admin Lesgo' }}</h6>
    <p class="text-muted mb-2" style="font-size: 11px;">Super Administrator</p>
    <span class="badge rounded-pill px-2 py-1 shadow-sm" style="background-color: var(--accent); color: white; font-size:10px;">
        Level 1
    </span>
</div>

<!-- Notification Center Widget -->
<div class="widget-section">
    <h6 class="widget-title"><i class="bi bi-bell-fill"></i> Notifikasi</h6>
    <div class="d-flex flex-column gap-2">
        <div class="d-flex gap-2">
            <i class="bi bi-info-circle text-info mt-1" style="font-size: 12px;"></i>
            <div>
                <span class="d-block font-semibold" style="font-size: 12px;">Persetujuan Bimbel</span>
                <span class="d-block text-muted" style="font-size: 10.5px;">Bimbel Mandiri menunggu konfirmasi.</span>
            </div>
        </div>
        <div class="d-flex gap-2">
            <i class="bi bi-exclamation-triangle text-warning mt-1" style="font-size: 12px;"></i>
            <div>
                <span class="d-block font-semibold" style="font-size: 12px;">Laporan Review</span>
                <span class="d-block text-muted" style="font-size: 10.5px;">2 review bintang 1 dilaporkan hari ini.</span>
            </div>
        </div>
    </div>
</div>

<!-- Reminder Widget -->
<div class="widget-section">
    <h6 class="widget-title"><i class="bi bi-clock-history"></i> Reminder</h6>
    <div class="d-flex flex-column gap-2">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex flex-column">
                <span class="fw-semibold" style="font-size: 12px;">Verifikasi Bimbel</span>
                <span class="text-muted" style="font-size: 10px;">Hari ini, 14:00</span>
            </div>
            <span class="reminder-badge bg-danger-subtle text-danger">Penting</span>
        </div>
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex flex-column">
                <span class="fw-semibold" style="font-size: 12px;">Backup Database</span>
                <span class="text-muted" style="font-size: 10px;">Besok, 00:00</span>
            </div>
            <span class="reminder-badge bg-secondary-subtle text-secondary">Rutin</span>
        </div>
    </div>
</div>

<!-- Todo Widget (Interactive) -->
<div class="widget-section mb-0">
    <h6 class="widget-title"><i class="bi bi-check2-square"></i> Todo</h6>
    <div class="todo-list">
        <div class="todo-item">
            <input type="checkbox" class="todo-checkbox" id="todo-1" onchange="toggleTodo(this)">
            <label for="todo-1" class="todo-text">Cek pendaftaran baru</label>
        </div>
        <div class="todo-item completed">
            <input type="checkbox" class="todo-checkbox" id="todo-2" checked onchange="toggleTodo(this)">
            <label for="todo-2" class="todo-text">Verifikasi mapel</label>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Tanggal
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    document.getElementById('current-date').textContent = new Date().toLocaleDateString('id-ID', options);

    // Todo Interaktif
    function toggleTodo(checkbox) {
        checkbox.closest('.todo-item').classList.toggle('completed', checkbox.checked);
    }

    // Single Dynamic Modal Handler (Menggantikan banyak loop modal)
    function openDetailModal(nama, email, wa, paket, status, catatan) {
        document.getElementById('modal-nama').textContent = nama;
        document.getElementById('modal-email').textContent = email;
        document.getElementById('modal-wa').textContent = wa;
        document.getElementById('modal-paket').textContent = paket;
        document.getElementById('modal-catatan').textContent = catatan;

        let statusBadge = '';
        if(status === 'pending' || status === '') statusBadge = '<span class="badge rounded-pill bg-warning-subtle text-warning">Pending</span>';
        else if(status === 'diterima') statusBadge = '<span class="badge rounded-pill bg-success-subtle text-success">Diterima</span>';
        else statusBadge = '<span class="badge rounded-pill bg-danger-subtle text-danger">Ditolak</span>';
        document.getElementById('modal-status').innerHTML = statusBadge;

        new bootstrap.Modal(document.getElementById('dynamicDetailModal')).show();
    }

    // Pengaturan Global Chart supaya responsif terhadap kontainer
    Chart.defaults.maintainAspectRatio = false;
    Chart.defaults.responsive = true;

    // Chart 1: User Growth Line Chart
    const ctxGrowth = document.getElementById('userGrowthChart').getContext('2d');
    const growthGradient = ctxGrowth.createLinearGradient(0, 0, 0, 250);
    growthGradient.addColorStop(0, 'rgba(255, 166, 158, 0.4)');
    growthGradient.addColorStop(1, 'rgba(255, 255, 255, 0.05)');

    new Chart(ctxGrowth, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt'],
            datasets: [{
                data: [150, 220, 180, 290, 380, 320, 480, 510],
                borderColor: '#FFA69E',
                borderWidth: 2,
                pointBackgroundColor: '#2F4858',
                backgroundColor: growthGradient,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false }, ticks: { font: { size: 10 } } },
                y: { grid: { color: 'rgba(147,225,216,0.1)' }, ticks: { font: { size: 10 } } }
            }
        }
    });

    // Chart 2: Category Doughnut Chart
    const ctxMapel = document.getElementById('mapelChart').getContext('2d');
    new Chart(ctxMapel, {
        type: 'doughnut',
        data: {
            labels: ['MTK', 'Inggris', 'Fisika', 'Lain'],
            datasets: [{
                data: [40, 30, 20, 10],
                backgroundColor: ['#93E1D8', '#FFA69E', '#2F4858', '#e2e8f0'],
                borderWidth: 2
            }]
        },
        options: {
            plugins: {
                legend: { position: 'right', labels: { boxWidth: 10, font: { size: 10 } } }
            },
            cutout: '70%'
        }
    });

    // Real-Time Polling Real-Count Data Admin
    function updateRealtimeCounts() {
        fetch("{{ route('admin.realtime-counts') }}")
            .then(res => res.json())
            .then(data => {
                const elUser = document.getElementById('realtime-total-user');
                const elBimbel = document.getElementById('realtime-total-bimbel');
                const elReview = document.getElementById('realtime-total-review');
                const elMapel = document.getElementById('realtime-total-mapel');

                if (elUser) elUser.textContent = Number(data.totalUser).toLocaleString('id-ID');
                if (elBimbel) elBimbel.textContent = Number(data.totalBimbel).toLocaleString('id-ID');
                if (elReview) elReview.textContent = Number(data.totalReview).toLocaleString('id-ID');
                if (elMapel) elMapel.textContent = Number(data.totalMapel).toLocaleString('id-ID');
            })
            .catch(err => console.log('Realtime fetch error:', err));
    }

    // Jalankan otomatis setiap 5 detik
    setInterval(updateRealtimeCounts, 5000);
</script>
@endpush
