@extends('layouts.admin')

@section('title', 'Detail Bimbel - LesGo Admin')

@push('style')
<style>
    .detail-card {
        background: var(--white);
        border-radius: 20px;
        border: 1px solid rgba(147, 225, 216, 0.18);
        box-shadow: 0 8px 22px -12px rgba(47, 72, 88, 0.08);
    }

    .bimbel-hero {
        background: linear-gradient(135deg, #93E1D8 0%, #DDFFF7 100%);
        border-radius: 20px;
        padding: 36px;
        display: flex;
        align-items: center;
        gap: 26px;
        box-shadow: 0 10px 26px -12px rgba(47, 72, 88, 0.16);
        margin-bottom: 22px;
        position: relative;
        overflow: hidden;
    }

    .bimbel-hero-cover {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 0;
    }

    .bimbel-hero-cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.15;
    }

    .bimbel-hero-content {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 26px;
        width: 100%;
    }

    .bimbel-hero-logo {
        width: 100px;
        height: 100px;
        border-radius: 20px;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 38px;
        color: var(--dark);
        border: 4px solid #ffffff;
        box-shadow: 0 6px 16px rgba(47, 72, 88, 0.1);
        flex-shrink: 0;
        overflow: hidden;
    }

    .bimbel-hero-logo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 16px;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 14px 0;
        border-bottom: 1px dashed rgba(147, 225, 216, 0.25);
    }

    .info-row:last-child { border-bottom: none; }

    .info-label {
        color: var(--dark-muted);
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .info-label i {
        color: #55a096;
        width: 18px;
    }

    .info-value {
        color: var(--dark);
        font-weight: 600;
        font-size: 14px;
        text-align: right;
        max-width: 55%;
    }

    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 14px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-pill.status-aktif {
        background-color: rgba(147, 225, 216, 0.22);
        color: #2f7568;
    }

    .status-pill.status-nonaktif {
        background-color: rgba(255, 166, 158, 0.22);
        color: #d87e76;
    }

    .stat-tile {
        background: #f4fbf9;
        border-radius: 14px;
        padding: 18px;
        text-align: center;
        border: 1px solid rgba(147, 225, 216, 0.15);
    }

    .stat-tile .number {
        font-size: 28px;
        font-weight: 800;
        color: var(--dark);
        margin-bottom: 4px;
    }

    .stat-tile .desc {
        font-size: 12px;
        color: var(--dark-muted);
        text-transform: uppercase;
        letter-spacing: 0.4px;
        font-weight: 500;
    }

    .action-bar {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 16px;
    }

    .btn-action {
        padding: 10px 22px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 14px;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        border: none;
    }

    .btn-action-edit {
        background-color: var(--accent);
        color: #ffffff;
    }
    .btn-action-edit:hover {
        background-color: #ff8f85;
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(255, 166, 158, 0.32);
    }

    .btn-action-secondary {
        background-color: transparent;
        color: var(--dark);
        border: 1.5px solid rgba(147, 225, 216, 0.35);
    }
    .btn-action-secondary:hover {
        background-color: rgba(147, 225, 216, 0.18);
        color: var(--dark);
    }

    .btn-action-danger {
        background-color: transparent;
        color: #dc3545;
        border: 1.5px solid #f5c2c7;
    }
    .btn-action-danger:hover {
        background-color: #dc3545;
        color: #fff;
    }

    .deskripsi-box {
        background: #f4fbf9;
        border-radius: 14px;
        padding: 20px;
        border: 1px solid rgba(147, 225, 216, 0.15);
        line-height: 1.7;
        font-size: 14px;
        color: var(--dark);
        white-space: pre-line;
    }

    .contact-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        background: #f4fbf9;
        border-radius: 10px;
        font-size: 13px;
        color: var(--dark);
        text-decoration: none;
        transition: var(--transition);
        border: 1px solid rgba(147, 225, 216, 0.15);
    }

    .contact-chip:hover {
        background: #e8f6f3;
        transform: translateY(-1px);
    }
</style>
@endpush

@section('content')
<!-- Header -->
<div class="row align-items-center mb-3">
    <div class="col">
        <h1 class="fw-bold h2 mb-1" style="color: var(--dark);">
            <i class="bi bi-mortarboard-fill me-2" style="color: var(--accent);"></i>
            Detail Bimbel
        </h1>
        <p class="text-muted mb-0">Informasi lengkap lembaga bimbingan belajar.</p>
    </div>
    <div class="col-auto">
        <a href="{{ route('admin.bimbel.index') }}" class="btn btn-light rounded-pill px-3 shadow-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<!-- Hero -->
<div class="bimbel-hero">
    @if($bimbel->cover)
        <div class="bimbel-hero-cover">
            <img src="{{ Storage::url($bimbel->cover) }}" alt="Cover {{ $bimbel->nama }}">
        </div>
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
            <h2 class="fw-bold mb-1" style="color: var(--dark);">{{ $bimbel->nama }}</h2>
            <p class="mb-2" style="color: var(--dark); opacity: 0.85;">
                <i class="bi bi-book me-1"></i> {{ $bimbel->mapel }}
                <span class="mx-2">•</span>
                <i class="bi bi-layers me-1"></i> {{ $bimbel->jenjang }}
                <span class="mx-2">•</span>
                <i class="bi bi-geo-alt me-1"></i> {{ $bimbel->kota }}
            </p>
            @if($bimbel->status === 'Aktif')
                <span class="status-pill status-aktif"><i class="bi bi-check-circle-fill"></i> Aktif</span>
            @else
                <span class="status-pill status-nonaktif"><i class="bi bi-x-circle-fill"></i> Nonaktif</span>
            @endif
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Info Detail -->
    <div class="col-lg-7">
        <div class="detail-card p-4">
            <h5 class="fw-bold mb-3" style="color: var(--dark);">
                <i class="bi bi-info-circle-fill me-2" style="color: var(--accent);"></i>
                Informasi Lengkap
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
                <div class="info-label"><i class="bi bi-geo-fill"></i> Alamat</div>
                <div class="info-value">{{ $bimbel->alamat }}</div>
            </div>
            <div class="info-row">
                <div class="info-label"><i class="bi bi-cash-stack"></i> Harga Mulai</div>
                <div class="info-value">
                    @if($bimbel->harga_mulai)
                        Rp{{ number_format($bimbel->harga_mulai, 0, ',', '.') }}
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
            <div class="mt-4 d-flex flex-wrap gap-2">
                @if($bimbel->telepon)
                    <a href="tel:{{ $bimbel->telepon }}" class="contact-chip">
                        <i class="bi bi-telephone-fill" style="color: #55a096;"></i>
                        {{ $bimbel->telepon }}
                    </a>
                @endif
                @if($bimbel->email)
                    <a href="mailto:{{ $bimbel->email }}" class="contact-chip">
                        <i class="bi bi-envelope-fill" style="color: #55a096;"></i>
                        {{ $bimbel->email }}
                    </a>
                @endif
                @if($bimbel->website)
                    <a href="{{ $bimbel->website }}" target="_blank" class="contact-chip">
                        <i class="bi bi-globe2" style="color: #55a096;"></i>
                        Website
                    </a>
                @endif
            </div>

            <div class="action-bar">
                <a href="{{ route('admin.bimbel.edit', $bimbel) }}" class="btn-action btn-action-edit">
                    <i class="bi bi-pencil-square"></i> Edit Bimbel
                </a>
                <form action="{{ route('admin.bimbel.destroy', $bimbel) }}"
                      method="POST"
                      onsubmit="return confirm('Hapus bimbel {{ addslashes($bimbel->nama) }}? Semua data terkait akan ikut terhapus dan TIDAK DAPAT dibatalkan.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-action btn-action-danger">
                        <i class="bi bi-trash"></i> Hapus Bimbel
                    </button>
                </form>
            </div>
        </div>

        <!-- Deskripsi -->
        <div class="detail-card p-4 mt-4">
            <h5 class="fw-bold mb-3" style="color: var(--dark);">
                <i class="bi bi-file-text-fill me-2" style="color: var(--accent);"></i>
                Deskripsi
            </h5>
            <div class="deskripsi-box">{{ $bimbel->deskripsi }}</div>
        </div>
    </div>

    <!-- Statistik & Info Tambahan -->
    <div class="col-lg-5">
        <div class="detail-card p-4 mb-3">
            <h5 class="fw-bold mb-3" style="color: var(--dark);">
                <i class="bi bi-bar-chart-fill me-2" style="color: var(--accent);"></i>
                Statistik Aktivitas
            </h5>
            <div class="row g-3">
                <div class="col-6">
                    <div class="stat-tile">
                        <div class="number">{{ $bimbel->reviews_count ?? 0 }}</div>
                        <div class="desc">Review</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="stat-tile">
                        <div class="number">{{ $bimbel->favorites_count ?? 0 }}</div>
                        <div class="desc">Favorit</div>
                    </div>
                </div>
            </div>
        </div>

        @if($bimbel->cover)
        <div class="detail-card p-4 mb-3">
            <h6 class="fw-bold mb-3" style="color: var(--dark);">
                <i class="bi bi-image me-2" style="color: var(--accent);"></i>
                Cover Bimbel
            </h6>
            <img src="{{ Storage::url($bimbel->cover) }}"
                 alt="Cover {{ $bimbel->nama }}"
                 class="img-fluid rounded-3"
                 style="border: 1px solid rgba(147, 225, 216, 0.2);">
        </div>
        @endif

        <div class="detail-card p-4" style="background: linear-gradient(135deg, #f4fbf9 0%, #ffffff 100%);">
            <h6 class="fw-bold mb-3" style="color: var(--dark);">
                <i class="bi bi-clock-history me-2" style="color: var(--accent);"></i>
                Timeline
            </h6>

            <div class="d-flex align-items-center gap-3 mb-3">
                <i class="bi bi-calendar-plus-fill" style="color:#55a096; font-size: 18px;"></i>
                <div>
                    <strong style="color: var(--dark); font-size: 14px;">Dibuat</strong>
                    <div class="text-secondary small">{{ $bimbel->created_at ? $bimbel->created_at->translatedFormat('d F Y, H:i') : '—' }}</div>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-arrow-repeat" style="color: var(--accent); font-size: 18px;"></i>
                <div>
                    <strong style="color: var(--dark); font-size: 14px;">Terakhir diperbarui</strong>
                    <div class="text-secondary small">{{ $bimbel->updated_at ? $bimbel->updated_at->translatedFormat('d F Y, H:i') : '—' }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
