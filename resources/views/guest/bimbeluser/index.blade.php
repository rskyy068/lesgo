@extends('layouts.guest')

@section('title', 'Bimbel Saya - LesGo')

@push('style')
<style>
    :root {
        --lesgo-pink: #FF9980;
        --lesgo-pink-hover: #ff8566;
        --lesgo-pink-bg: #fff0ee;
        --lesgo-blue: #93E1D8;
        --lesgo-blue-hover: #7accc2;
        --lesgo-blue-bg: #eefbf9;
        --lesgo-dark: #2F4858;
        --lesgo-muted: #5a7684;
        --lesgo-bg: #f3f7f6;
        --lesgo-card-bg: #ffffff;
        --lesgo-border: rgba(147, 225, 216, 0.4);
    }

    body {
        background-color: var(--lesgo-bg) !important;
        color: var(--lesgo-dark);
    }

    .dashboard-card {
        background: var(--lesgo-card-bg);
        border-radius: 20px;
        border: 1px solid var(--lesgo-border);
        box-shadow: 0 8px 24px rgba(47, 72, 88, 0.05);
        overflow: hidden;
    }

    /* Buttons Solid (No Gradients) */
    .btn-lesgo-primary {
        background-color: var(--lesgo-pink);
        color: #ffffff;
        border: none;
        font-weight: 600;
        padding: 10px 24px;
        border-radius: 50rem;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }
    .btn-lesgo-primary:hover {
        background-color: var(--lesgo-pink-hover);
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 153, 128, 0.3);
    }

    .btn-lesgo-secondary {
        background-color: #ffffff;
        color: var(--lesgo-dark);
        border: 1.5px solid var(--lesgo-blue);
        font-weight: 600;
        padding: 10px 20px;
        border-radius: 12px;
        transition: all 0.2s ease;
        text-decoration: none;
    }
    .btn-lesgo-secondary:hover {
        background-color: var(--lesgo-blue-bg);
        color: var(--lesgo-dark);
        border-color: var(--lesgo-blue-hover);
    }

    /* Inputs */
    .form-control-lesgo, .form-select-lesgo {
        border-radius: 12px;
        border: 1.5px solid var(--lesgo-border);
        padding: 10px 16px;
        font-size: 14px;
        color: var(--lesgo-dark);
        background-color: #ffffff;
        transition: all 0.2s ease;
    }
    .form-control-lesgo:focus, .form-select-lesgo:focus {
        border-color: var(--lesgo-blue-hover);
        box-shadow: 0 0 0 4px rgba(147, 225, 216, 0.25);
        background-color: #ffffff;
    }

    /* Table Styles */
    .custom-table {
        margin-bottom: 0;
        width: 100%;
    }
    .custom-table thead th {
        background-color: var(--lesgo-blue-bg);
        font-size: 12.5px;
        font-weight: 700;
        text-transform: uppercase;
        color: var(--lesgo-dark);
        border-bottom: 1.5px solid var(--lesgo-border);
        padding: 16px 20px;
        letter-spacing: 0.5px;
    }
    .custom-table tbody td {
        padding: 18px 20px;
        vertical-align: middle;
        border-bottom: 1px solid var(--lesgo-border);
        font-size: 14px;
        color: var(--lesgo-dark);
    }
    .custom-table tbody tr {
        transition: background-color 0.2s ease;
    }
    .custom-table tbody tr:hover {
        background-color: #f7fdfc;
    }
    .custom-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Thumbnails & Badges */
    .bimbel-thumb {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background-color: var(--lesgo-blue-bg);
        color: var(--lesgo-dark);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        border: 1px solid var(--lesgo-blue);
        overflow: hidden;
        flex-shrink: 0;
    }
    .bimbel-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .status-badge {
        padding: 5px 14px;
        border-radius: 50rem;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .status-badge.aktif {
        background-color: var(--lesgo-blue-bg);
        color: var(--lesgo-dark);
        border: 1px solid var(--lesgo-blue);
    }
    .status-badge.nonaktif {
        background-color: var(--lesgo-pink-bg);
        color: var(--lesgo-dark);
        border: 1px solid var(--lesgo-pink);
    }

    .jenjang-badge {
        background-color: #ffffff;
        color: var(--lesgo-muted);
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 500;
        border: 1px solid var(--lesgo-border);
    }

    /* Actions */
    .btn-action {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #ffffff;
        color: var(--lesgo-dark);
        border: 1px solid var(--lesgo-border);
        transition: all 0.2s ease;
        text-decoration: none;
    }
    .btn-action:hover {
        background-color: var(--lesgo-blue-bg);
        border-color: var(--lesgo-blue);
        color: var(--lesgo-dark);
    }
    .btn-action.delete:hover {
        background-color: var(--lesgo-pink-bg);
        border-color: var(--lesgo-pink);
        color: #d9534f;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 70px 20px;
        background: #ffffff;
    }
    .empty-state-icon {
        width: 80px;
        height: 80px;
        background-color: var(--lesgo-pink-bg);
        color: var(--lesgo-pink);
        border: 2px solid var(--lesgo-pink);
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 36px;
        margin-bottom: 20px;
    }
</style>
@endpush

@section('content')
<div class="container py-4">

    <!-- Header Section -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-2 gap-3">
        <div>
            <h1 class="fw-bold h3 mb-1" style="color: var(--lesgo-dark);">
                <i class="bi bi-mortarboard-fill me-2" style="color: var(--lesgo-pink);"></i> Bimbel Saya
            </h1>
            <p class="text-muted mb-0" style="font-size: 14px;">Kelola dan pantau semua lembaga bimbingan belajar terdaftar milik Anda.</p>
        </div>
        <div>
            <a href="{{ route('bimbeluser.create') }}" class="btn-lesgo-primary">
                <i class="bi bi-plus-circle-fill me-2"></i>Daftarkan Bimbel
            </a>
        </div>
    </div>

    <!-- Alert success/error -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert" style="background-color: var(--lesgo-blue-bg); color: var(--lesgo-dark); border: 1px solid var(--lesgo-blue) !important;">
            <i class="bi bi-check-circle-fill text-success me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Pengingat Masa Aktif Membership (30 Hari Limit) -->
    @php
        $expiringOrExpired = $bimbels->filter(fn($b) => $b->isExpired() || $b->remainingDays() <= 7);
    @endphp
    @if($expiringOrExpired->count() > 0)
        <div class="alert border-0 rounded-4 shadow-sm mb-4 p-3 p-md-4" style="background: linear-gradient(135deg, #fff5f3 0%, #ffffff 100%); border-left: 4px solid var(--lesgo-pink) !important; border: 1px solid rgba(255,153,128,0.3) !important;">
            <div class="d-flex align-items-start gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px; background: var(--lesgo-pink-bg); color: var(--lesgo-pink);">
                    <i class="bi bi-hourglass-split fs-4"></i>
                </div>
                <div class="flex-grow-1">
                    <h6 class="fw-bold mb-1" style="color: var(--lesgo-dark);">
                        <i class="bi bi-bell-fill me-1 text-danger"></i> Pengingat Masa Aktif Membership Bimbel
                    </h6>
                    <p class="mb-2 text-muted" style="font-size: 13.5px;">
                        Setiap bimbel hanya tampil selama 30 hari. Mohon perhatikan sisa waktu bimbel Anda sebelum tenggat pembayaran membership ulang agar tidak disembunyikan atau dihapus admin:
                    </p>
                    <div class="d-flex flex-column gap-2">
                        @foreach($expiringOrExpired as $expB)
                            <div class="d-flex align-items-center justify-content-between bg-white p-2 px-3 rounded-3 border flex-wrap gap-2">
                                <div>
                                    <span class="fw-bold me-2" style="color: var(--lesgo-dark);">{{ $expB->nama }}</span>
                                    @if($expB->isExpired())
                                        <span class="badge bg-danger rounded-pill px-2 py-1" style="font-size: 11px;">
                                            <i class="bi bi-exclamation-triangle-fill me-1"></i>Kedaluwarsa (0 Hari) - Disembunyikan dari Publik
                                        </span>
                                    @else
                                        <span class="badge bg-warning text-dark rounded-pill px-2 py-1" style="font-size: 11px;">
                                            <i class="bi bi-clock-history me-1"></i>Sisa {{ $expB->remainingDays() }} Hari Lagi
                                        </span>
                                    @endif
                                </div>
                                @php
                                    $waRenewMsg = rawurlencode("Halo Admin LesGo,\nSaya ingin melakukan pembayaran perpanjangan membership (Rp 10.000) untuk Bimbel:\n📌 *Nama Bimbel:* " . $expB->nama . "\n📌 *Pemilik:* " . auth()->user()->name . " (" . auth()->user()->email . ")\n\nMohon petunjuk pembayaran & perpanjangan akun. Terima kasih!");
                                    $waRenewUrl = "https://wa.me/6281234567890?text=" . $waRenewMsg;
                                @endphp
                                <a href="{{ $waRenewUrl }}" target="_blank" class="btn btn-sm btn-lesgo-primary px-3 py-1" style="font-size: 12px; text-decoration: none;">
                                    <i class="bi bi-whatsapp me-1"></i> Bayar Perpanjang Rp 10.000
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Filter & Pencarian -->
    <div class="dashboard-card p-4 mb-4">
        <form method="GET" action="{{ route('bimbeluser.index') }}" class="row g-3 align-items-end">
            <div class="col-md-5">
                <label class="form-label text-muted small fw-semibold mb-1">Cari Nama / Lokasi</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted" style="border: 1.5px solid var(--lesgo-border); border-radius: 12px 0 0 12px;">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="search" class="form-control form-control-lesgo border-start-0 ps-0"
                           placeholder="Ketik kata kunci pencarian..."
                           value="{{ request('search') }}"
                           style="border-radius: 0 12px 12px 0;">
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label text-muted small fw-semibold mb-1">Filter Status</label>
                <select name="status" class="form-select form-select-lesgo">
                    <option value="">Semua Status</option>
                    <option value="Aktif" {{ request('status') === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Nonaktif" {{ request('status') === 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn-lesgo-primary flex-grow-1 justify-content-center" style="border-radius: 12px; padding: 10px;">
                    <i class="bi bi-funnel me-1"></i> Cari Data
                </button>
                @if(request()->hasAny(['search','status']))
                    <a href="{{ route('bimbeluser.index') }}" class="btn-lesgo-secondary px-3 d-flex align-items-center" title="Reset Filter">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Data List -->
    <div class="dashboard-card mb-4">
        <div class="p-4 border-bottom d-flex justify-content-between align-items-center bg-white">
            <h5 class="fw-bold mb-0" style="color: var(--lesgo-dark);">Daftar Terdaftar</h5>
            <span class="badge" style="background-color: var(--lesgo-blue-bg); color: var(--lesgo-dark); border: 1px solid var(--lesgo-blue); padding: 6px 14px; border-radius: 20px; font-weight: 600;">
                {{ $bimbels->total() }} Data Bimbel
            </span>
        </div>

        @if($bimbels->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="bi bi-journal-bookmark-fill"></i>
                </div>
                <h4 class="fw-bold mb-2" style="color: var(--lesgo-dark);">Belum Ada Bimbel</h4>
                <p class="text-muted mb-4 mx-auto" style="max-width: 460px; line-height: 1.6; font-size: 14px;">
                    Anda belum mendaftarkan bimbingan belajar apapun di akun ini. Masukkan token pendaftaran yang didapatkan dari Admin untuk mulai menambahkan bimbel Anda!
                </p>
                <a href="{{ route('bimbeluser.create') }}" class="btn-lesgo-primary px-4">
                    <i class="bi bi-plus-lg me-2"></i>Tambah Bimbel Pertama
                </a>
            </div>
        @else
            <div class="table-responsive border-0">
                <table class="table custom-table align-middle">
                    <thead>
                        <tr>
                            <th style="width: 60px; text-align: center;">No</th>
                            <th>Info Bimbel</th>
                            <th>Mata Pelajaran</th>
                            <th>Jenjang & Lokasi</th>
                            <th>Status & Masa Aktif</th>
                            <th>Harga Mulai</th>
                            <th class="text-end" style="padding-right: 24px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bimbels as $i => $bimbel)
                            <tr>
                                <td class="text-muted text-center fw-medium">{{ $bimbels->firstItem() + $i }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="bimbel-thumb">
                                            @if($bimbel->logo)
                                                <img src="{{ Storage::url($bimbel->logo) }}" alt="Logo">
                                            @else
                                                <i class="bi bi-mortarboard-fill"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <span class="fw-bold d-block" style="color: var(--lesgo-dark); font-size: 15px;">{{ $bimbel->nama }}</span>
                                            <span class="text-muted small">Terdaftar: {{ $bimbel->created_at->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span style="color: var(--lesgo-dark); font-weight: 500;">{{ Str::limit($bimbel->mapel, 30) }}</span>
                                </td>
                                <td>
                                    <div class="d-flex flex-column gap-1 align-items-start">
                                        <span class="jenjang-badge">{{ $bimbel->jenjang }}</span>
                                        <span class="text-muted small d-flex align-items-center gap-1 mt-1">
                                            <i class="bi bi-geo-alt-fill text-danger"></i>
                                            {{ $bimbel->kota }}
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column gap-1 align-items-start">
                                        @if($bimbel->isExpired())
                                            <span class="status-badge nonaktif">
                                                <i class="bi bi-x-circle-fill text-danger"></i> Kedaluwarsa
                                            </span>
                                            <span class="badge bg-danger text-white rounded-pill" style="font-size: 10px;">
                                                <i class="bi bi-exclamation-triangle me-1"></i>Sisa 0 Hari (Non-Publik)
                                            </span>
                                        @elseif($bimbel->status === 'Aktif')
                                            <span class="status-badge aktif">
                                                <i class="bi bi-check-circle-fill text-success"></i> Aktif
                                            </span>
                                            @if($bimbel->remainingDays() <= 7)
                                                <span class="badge bg-warning text-dark rounded-pill" style="font-size: 10px;">
                                                    <i class="bi bi-clock-history me-1"></i>Sisa {{ $bimbel->remainingDays() }} Hari
                                                </span>
                                            @else
                                                <span class="badge bg-success-subtle text-success rounded-pill border border-success-subtle" style="font-size: 10px;">
                                                    <i class="bi bi-shield-check me-1"></i>Sisa {{ $bimbel->remainingDays() }} Hari
                                                </span>
                                            @endif
                                        @else
                                            <span class="status-badge nonaktif">
                                                <i class="bi bi-x-circle-fill text-danger"></i> Nonaktif
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-bold" style="color: var(--lesgo-dark);">
                                        Rp{{ number_format($bimbel->harga_mulai, 0, ',', '.') ?? '—' }}
                                    </span>
                                </td>
                                <td style="padding-right: 24px;">
                                    <div class="d-flex gap-2 justify-content-end align-items-center">
                                        @php
                                            $waRenewTableMsg = rawurlencode("Halo Admin LesGo,\nSaya pemilik Bimbel *" . $bimbel->nama . "* ingin melakukan perpanjangan membership 30 hari (Rp 10.000).\nMohon diproses. Terima kasih!");
                                            $waRenewTableUrl = "https://wa.me/6281234567890?text=" . $waRenewTableMsg;
                                        @endphp
                                        <a href="{{ $waRenewTableUrl }}" target="_blank" class="btn btn-sm btn-outline-success rounded-pill px-2 py-1" style="font-size: 11px;" title="Perpanjang Membership via WhatsApp">
                                            <i class="bi bi-whatsapp"></i> Perpanjang
                                        </a>
                                        <a href="{{ route('bimbeluser.show', $bimbel) }}" class="btn-action" title="Detail Bimbel">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('bimbeluser.edit', $bimbel) }}" class="btn-action" title="Edit Data">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('bimbeluser.destroy', $bimbel) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus bimbel {{ addslashes($bimbel->nama) }}? Data yang dihapus tidak dapat dikembalikan.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action delete" title="Hapus Bimbel">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-4 bg-white d-flex justify-content-between align-items-center flex-wrap gap-3" style="border-top: 1px solid var(--lesgo-border);">
                <span class="text-muted small fw-medium">
                    Menampilkan {{ $bimbels->firstItem() }} - {{ $bimbels->lastItem() }} dari total {{ $bimbels->total() }} data
                </span>
                <div class="m-0">
                    {{ $bimbels->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
