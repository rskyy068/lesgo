@extends('layouts.guest')

@section('title', 'Detail Bimbel - LesGo')

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

    .detail-card {
        background: var(--lesgo-card-bg);
        border-radius: 20px;
        border: 1px solid var(--lesgo-border);
        box-shadow: 0 8px 24px rgba(47, 72, 88, 0.05);
        overflow: hidden;
    }

    .bimbel-hero {
        position: relative;
        background-color: var(--lesgo-blue-bg);
        border-radius: 20px;
        border: 1px solid var(--lesgo-border);
        padding: 30px;
        margin-bottom: 24px;
        box-shadow: 0 8px 24px rgba(47, 72, 88, 0.05);
    }

    .bimbel-hero-cover {
        height: 200px;
        width: 100%;
        object-fit: cover;
        border-radius: 14px;
        margin-bottom: 20px;
    }

    .bimbel-hero-content {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .bimbel-hero-logo {
        width: 80px;
        height: 80px;
        border-radius: 16px;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 36px;
        color: var(--lesgo-pink);
        border: 2px solid var(--lesgo-blue);
        overflow: hidden;
        flex-shrink: 0;
    }

    .bimbel-hero-logo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .info-row {
        display: flex;
        padding: 14px 0;
        border-bottom: 1px solid var(--lesgo-border);
    }
    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        width: 180px;
        font-weight: 600;
        color: var(--lesgo-muted);
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .info-value {
        flex: 1;
        font-weight: 500;
        color: var(--lesgo-dark);
        font-size: 14px;
    }

    .contact-chip {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        background-color: var(--lesgo-blue-bg);
        color: var(--lesgo-dark);
        border-radius: 50rem;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        border: 1px solid var(--lesgo-blue);
        transition: all 0.2s ease;
    }
    .contact-chip:hover {
        background-color: var(--lesgo-blue);
        color: var(--lesgo-dark);
    }

    .status-pill {
        padding: 6px 16px;
        border-radius: 50rem;
        font-size: 12px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .status-aktif {
        background-color: var(--lesgo-blue-bg);
        color: var(--lesgo-dark);
        border: 1px solid var(--lesgo-blue);
    }
    .status-nonaktif {
        background-color: var(--lesgo-pink-bg);
        color: var(--lesgo-dark);
        border: 1px solid var(--lesgo-pink);
    }

    .action-bar {
        display: flex;
        gap: 12px;
        padding-top: 20px;
        border-top: 1px dashed var(--lesgo-border);
        margin-top: 24px;
    }

    .btn-action-edit {
        background-color: var(--lesgo-pink);
        color: #ffffff;
        border: none;
        border-radius: 12px;
        padding: 10px 24px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-action-edit:hover {
        background-color: var(--lesgo-pink-hover);
        color: #ffffff;
    }

    .btn-action-danger {
        background-color: #ffffff;
        color: #dc3545;
        border: 1.5px solid #dc3545;
        border-radius: 12px;
        padding: 10px 24px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-action-danger:hover {
        background-color: #dc3545;
        color: #ffffff;
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="row align-items-center mb-4">
        <div class="col">
            <h1 class="fw-bold h2 mb-1" style="color: var(--lesgo-dark);">
                <i class="bi bi-mortarboard-fill me-2" style="color: var(--lesgo-pink);"></i>
                Detail Bimbel
            </h1>
            <p class="text-muted mb-0">Informasi lengkap lembaga bimbingan belajar terdaftar Anda.</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('bimbeluser.index') }}" class="btn btn-light rounded-pill px-3 shadow-sm border">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Hero Header -->
    <div class="bimbel-hero">
        @if($bimbel->cover)
            <img src="{{ Storage::url($bimbel->cover) }}" alt="Cover {{ $bimbel->nama }}" class="bimbel-hero-cover">
        @endif
        <div class="bimbel-hero-content">
            <div class="bimbel-hero-logo">
                @if($bimbel->logo)
                    <img src="{{ Storage::url($bimbel->logo) }}" alt="{{ $bimbel->nama }}">
                @else
                    <i class="bi bi-building"></i>
                @endif
            </div>
            <div>
                <h2 class="fw-bold mb-1" style="color: var(--lesgo-dark);">{{ $bimbel->nama }}</h2>
                <p class="mb-2 text-muted" style="font-size: 14px;">
                    <i class="bi bi-book me-1 text-primary"></i> {{ $bimbel->mapel }}
                    <span class="mx-2">•</span>
                    <i class="bi bi-layers me-1 text-success"></i> {{ $bimbel->jenjang }}
                    <span class="mx-2">•</span>
                    <i class="bi bi-geo-alt me-1 text-danger"></i> {{ $bimbel->kota }}
                </p>
                @if($bimbel->isExpired())
                    <span class="status-pill status-nonaktif"><i class="bi bi-x-circle-fill text-danger"></i> Masa Aktif Kedaluwarsa (0 Hari)</span>
                @elseif($bimbel->status === 'Aktif')
                    <span class="status-pill status-aktif"><i class="bi bi-check-circle-fill text-success"></i> Status Aktif (Sisa {{ $bimbel->remainingDays() }} Hari)</span>
                @else
                    <span class="status-pill status-nonaktif"><i class="bi bi-x-circle-fill text-danger"></i> Status Nonaktif</span>
                @endif
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Info Detail -->
        <div class="col-lg-8">
            <div class="detail-card p-4">
                <h5 class="fw-bold mb-3" style="color: var(--lesgo-dark);">
                    <i class="bi bi-info-circle-fill me-2" style="color: var(--lesgo-pink);"></i>
                    Informasi Lengkap Bimbel
                </h5>

                <div class="info-row">
                    <div class="info-label"><i class="bi bi-mortarboard-fill"></i> Nama Bimbel</div>
                    <div class="info-value">{{ $bimbel->nama }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label"><i class="bi bi-book-fill"></i> Mata Pelajaran</div>
                    <div class="info-value">{{ $bimbel->mapel }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label"><i class="bi bi-layers-fill"></i> Jenjang</div>
                    <div class="info-value">{{ $bimbel->jenjang }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label"><i class="bi bi-geo-alt-fill"></i> Kota</div>
                    <div class="info-value">{{ $bimbel->kota }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label"><i class="bi bi-geo-fill"></i> Alamat Lengkap</div>
                    <div class="info-value">{{ $bimbel->alamat }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label"><i class="bi bi-cash-stack"></i> Harga Mulai</div>
                    <div class="info-value">
                        @if($bimbel->harga_mulai)
                            <span class="fw-bold text-success">Rp{{ number_format($bimbel->harga_mulai, 0, ',', '.') }}</span>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label"><i class="bi bi-clock-fill"></i> Jam Operasional</div>
                    <div class="info-value">{{ $bimbel->jam_operasional ?? '—' }}</div>
                </div>

                <!-- Kontak -->
                <div class="mt-4 pt-3 border-top d-flex flex-wrap gap-2">
                    @if($bimbel->telepon)
                        <a href="tel:{{ $bimbel->telepon }}" class="contact-chip">
                            <i class="bi bi-telephone-fill text-success"></i>
                            {{ $bimbel->telepon }}
                        </a>
                    @endif
                    @if($bimbel->email)
                        <a href="mailto:{{ $bimbel->email }}" class="contact-chip">
                            <i class="bi bi-envelope-fill text-primary"></i>
                            {{ $bimbel->email }}
                        </a>
                    @endif
                    @if($bimbel->website)
                        <a href="{{ $bimbel->website }}" target="_blank" class="contact-chip">
                            <i class="bi bi-globe2 text-info"></i>
                            Website Resmi
                        </a>
                    @endif
                </div>

                <div class="action-bar">
                    <a href="{{ route('bimbeluser.edit', $bimbel) }}" class="btn-action-edit">
                        <i class="bi bi-pencil-square"></i> Edit Data Bimbel
                    </a>
                    <form action="{{ route('bimbeluser.destroy', $bimbel) }}"
                          method="POST"
                          onsubmit="return confirm('Hapus bimbel {{ addslashes($bimbel->nama) }}? Semua data terkait akan ikut terhapus dan TIDAK DAPAT dibatalkan.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-action-danger">
                            <i class="bi bi-trash"></i> Hapus Bimbel
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Deskripsi & Membership Card -->
        <div class="col-lg-4">
            <!-- Membership Card -->
            <div class="detail-card p-4 mb-4">
                <h5 class="fw-bold mb-3" style="color: var(--lesgo-dark);">
                    <i class="bi bi-clock-history me-2" style="color: var(--lesgo-pink);"></i>
                    Masa Aktif Membership
                </h5>
                <div class="mb-3">
                    <small class="text-muted d-block mb-1" style="font-size: 11px;">Masa Aktif Berakhir Pada:</small>
                    <span class="fw-bold text-dark">
                        {{ $bimbel->expires_at ? $bimbel->expires_at->format('d M Y H:i') : $bimbel->created_at->addDays(30)->format('d M Y H:i') }}
                    </span>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block mb-1" style="font-size: 11px;">Sisa Waktu Penayangan:</small>
                    @if($bimbel->isExpired())
                        <span class="badge bg-danger rounded-pill px-3 py-2">
                            <i class="bi bi-exclamation-octagon-fill me-1"></i>0 Hari (Kedaluwarsa)
                        </span>
                        <p class="small text-danger mt-2 mb-0" style="font-size: 12px;">
                            Bimbel ini tidak ditampilkan pada halaman publik/pencarian. Silakan lakukan pembayaran member ulang untuk mengaktifkan kembali.
                        </p>
                    @else
                        <span class="badge bg-warning text-dark rounded-pill px-3 py-2">
                            <i class="bi bi-hourglass-split me-1"></i>Sisa {{ $bimbel->remainingDays() }} Hari Lagi
                        </span>
                    @endif
                </div>

                @php
                    $waRenewShowMsg = rawurlencode("Halo Admin LesGo,\nSaya pemilik Bimbel *" . $bimbel->nama . "* ingin melakukan perpanjangan membership 30 hari (Rp 10.000).\nMohon diproses. Terima kasih!");
                    $waRenewShowUrl = "https://wa.me/6281234567890?text=" . $waRenewShowMsg;
                @endphp
                <a href="{{ $waRenewShowUrl }}" target="_blank" class="btn btn-lesgo-primary w-100 justify-content-center mt-2" style="border-radius: 12px; padding: 10px;">
                    <i class="bi bi-whatsapp me-2"></i>Perpanjang Membership (Rp 10.000)
                </a>
            </div>

            <!-- Deskripsi Card -->
            <div class="detail-card p-4">
                <h5 class="fw-bold mb-3" style="color: var(--lesgo-dark);">
                    <i class="bi bi-card-text me-2" style="color: var(--lesgo-pink);"></i>
                    Deskripsi Bimbel
                </h5>
                <p class="text-secondary small mb-0" style="line-height: 1.7; white-space: pre-line;">
                    {{ $bimbel->deskripsi }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
