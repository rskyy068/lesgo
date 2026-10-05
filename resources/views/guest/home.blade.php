@extends('layouts.guest')

@section('title', 'LesGo')

@section('content')

{{-- =========================================================
BOOTSTRAP ICONS
========================================================= --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

{{-- =========================================================
HERO SECTION
========================================================= --}}
{{-- Warna gradient diubah dari pure white menjadi soft off-white (#F4F7F6) --}}
<section style="background: linear-gradient(135deg, #DDFFF7, #F4F7F6); padding:110px 0;">
    <div class="container">
        <div class="row align-items-center">

            <div class="col-lg-6">
                <span class="badge rounded-pill px-3 py-2 mb-3" style="background:#FFA69E; color:#FAFAFA;">
                    Platform Pencarian Bimbel No.1
                </span>

                <h1 class="display-4 fw-bold mb-4" style="color:#2F4858;">
                    Temukan
                    <span style="color:#F2847B;"> {{-- Sedikit digelapkan agar kontras di background terang --}}
                        Bimbel Terbaik
                    </span>
                    untuk Masa Depanmu.
                </h1>

                <p class="lead mb-4" style="color:#52636C;">
                    Cari tempat les berdasarkan mata pelajaran, lokasi,
                    rating, hingga harga. Belajar jadi lebih mudah bersama LesGo.
                </p>

                <a href="/bimbel" class="btn btn-lg rounded-pill px-5 shadow-sm" style="background:#7ACCC2; color:#FAFAFA;">
                    Cari Bimbel
                </a>

                <a href="/register" class="btn btn-lg rounded-pill px-5 ms-2" style="border:2px solid #7ACCC2; color:#2F4858;">
                    Daftar
                </a>
            </div>

            <div class="col-lg-6 mt-5 mt-lg-0">
                <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=900" class="img-fluid rounded-4 shadow-sm" alt="Belajar bersama">
            </div>

        </div>
    </div>
</section>

{{-- =========================================================
SEARCH SECTION
========================================================= --}}
<section class="py-5" style="margin-top:-60px; position:relative; z-index:10;">
    <div class="container">
        {{-- Card background diubah ke #FDFDFD agar tidak terlalu silau --}}
        <div class="card border-0 shadow-sm rounded-4" style="background-color: #FDFDFD;">
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-5">
                        <input type="text" class="form-control form-control-lg bg-light border-0" placeholder="Cari Mata Pelajaran">
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control form-control-lg bg-light border-0" placeholder="Kota">
                    </div>
                    <div class="col-md-3">
                        <button class="btn w-100 btn-lg shadow-sm" style="background:#FFA69E; color:#FAFAFA;">
                            Cari
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- =========================================================
STYLE
========================================================= --}}
<style>
    /* Mengubah body background secara keseluruhan jika memungkinkan */
    body {
        background-color: #FAFCFB;
    }

    /* =====================================================
       CARD MATA PELAJARAN
    ===================================================== */
    .card-work {
        --primary-clr: #232859; /* Sedikit dilunakkan dari #1C204B */
        --dot-clr: #BBC0FF;
        width: 200px;
        height: 170px;
        border-radius: 10px;
        font-family: Arial, sans-serif;
        color: #FAFAFA;
        display: grid;
        grid-template-rows: 50px 1fr;
        border: none;
        position: relative;
        isolation: isolate;
        cursor: pointer;
        transition: transform .3s ease, box-shadow .3s ease;
    }

    .card-work:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(47,72,88,.08) !important;
    }

    .card-work .img-section {
        transition: .2s cubic-bezier(.25,.46,.45,.94);
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        position: relative;
    }

    .card-work:hover .img-section {
        transform: translateY(1em);
    }

    .card-work .card-desc {
        border-radius: 10px;
        padding: 15px;
        position: relative;
        top: -10px;
        display: grid;
        gap: 10px;
        background: var(--primary-clr);
    }

    .card-work .card-desc .bg-icon {
        position: absolute;
        top: -30px;
        right: -10px;
        font-size: 6.5rem;
        color: rgba(255,255,255,.10); /* Opacity dikurangi agar lebih soft */
        z-index: 0;
        pointer-events: none;
        transition: transform .4s cubic-bezier(.25,.46,.45,.94);
    }

    .card-work:hover .card-desc .bg-icon {
        transform: scale(1.1) rotate(10deg);
    }

    .card-work .card-header,
    .card-work .card-time,
    .card-work .recent {
        position: relative;
        z-index: 2;
    }

    .card-work .card-time {
        font-size: 1.2em;
        font-weight: bold;
    }

    .card-work .recent {
        line-height: 1;
        font-size: .8em;
        margin: 0;
        color: #d1d5db;
    }

    .card-work .card-menu {
        display: flex;
        gap: 4px;
        margin-left: auto;
    }

    .card-work .dot {
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: var(--dot-clr);
    }

    .card-work .card-header {
        display: flex;
        align-items: center;
        width: 100%;
        padding: 0;
        background: transparent;
        border: none;
    }

    /* =====================================================
       PRICING SECTION
    ===================================================== */
    #paket-bimbel {
        background: #F0F6F5; /* Tone background slightly muted */
    }

    .pricing-section-badge {
        display: inline-block;
        background: #D0F5EB;
        color: #2F4858;
        padding: 8px 18px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 700;
    }

    .pricing-card {
        position: relative;
        background: #FDFDFD; /* Mengganti #ffffff dengan off-white */
        border: 2px solid #E2EFEF;
        border-radius: 24px;
        padding: 32px;
        transition: all .3s ease;
        box-shadow: 0 6px 15px rgba(47,72,88,.05); /* Shadow diperhalus */
    }

    .pricing-card:hover {
        transform: translateY(-8px);
        border-color: #7ACCC2;
        box-shadow: 0 12px 25px rgba(47,72,88,.08);
    }

    .pricing-pro {
        border: 2px solid #7ACCC2;
        background: #FCFEFD;
        box-shadow: 0 8px 20px rgba(122,204,194,.15);
    }

    .popular-badge {
        position: absolute;
        top: -15px;
        right: 25px;
        background: #F2847B;
        color: #FAFAFA;
        padding: 7px 17px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 700;
        box-shadow: 0 4px 12px rgba(242,132,123,.25);
    }

    .pricing-badge {
        display: inline-block;
        padding: 7px 15px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .5px;
    }

    .pricing-badge.basic {
        background: #E8F9F5;
        color: #2F4858;
        border: 1px solid #C9EBE4;
    }

    .pricing-badge.pro {
        background: #FFF1F0;
        color: #F2847B;
        border: 1px solid #FAD1CE;
    }

    .pricing-price {
        margin: 25px 0;
        color: #2F4858;
    }

    .pricing-price span {
        font-size: 18px;
        font-weight: 600;
    }

    .pricing-price strong {
        font-size: 42px;
        font-weight: 800;
    }

    .pricing-price small {
        color: #7B8B94;
        font-size: 13px;
    }

    .pricing-features {
        margin-bottom: 30px;
    }

    .pricing-features div {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 0;
        color: #52636C;
        font-size: 14px;
    }

    .pricing-features i {
        color: #7ACCC2;
        min-width: 17px;
    }

    .pricing-features .feature-disabled {
        color: #A3B1B7;
    }

    .pricing-features .feature-disabled i {
        color: #CDD6D9;
    }

    .trusted-feature {
        background: #FFF8F7;
        border-radius: 10px;
        padding: 11px !important;
        margin: 5px 0;
    }

    .trusted-feature i {
        color: #F2847B !important;
    }

    .pricing-button {
        width: 100%;
        border-radius: 14px;
        padding: 13px;
        font-weight: 700;
        transition: all .3s ease;
    }
    /* =====================================================
       CARD BIMBEL TERSEDIA
    ===================================================== */
    .bimbel-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid rgba(122, 204, 194, 0.25);
        box-shadow: 0 8px 25px rgba(47, 72, 88, 0.05);
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        overflow: hidden;
    }

    .bimbel-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 16px 35px rgba(47, 72, 88, 0.12);
        border-color: #7ACCC2;
    }

    .bimbel-card-banner {
        height: 170px;
        width: 100%;
        object-fit: cover;
        position: relative;
    }

    .bimbel-card-overlay {
        position: absolute;
        top: 15px;
        left: 15px;
        right: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        z-index: 2;
    }

    .bimbel-logo-avatar {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        object-fit: cover;
        border: 2px solid #7ACCC2;
        box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        background: #ffffff;
    }
</style>

{{-- =========================================================
DAFTAR BIMBEL TERSEDIA (SECTION DI ATAS MATA PELAJARAN FAVORIT)
========================================================= --}}
<section class="py-5" style="background: linear-gradient(180deg, #F4F7F6 0%, #FAFCFB 100%);">
    <div class="container">
        <div class="text-center mb-5">
            <span class="d-inline-block rounded-pill px-3 py-2 mb-2" style="background: rgba(122, 204, 194, 0.2); color: #2F4858; font-weight: 700; font-size: 13px;">
                <i class="bi bi-patch-check-fill me-1" style="color: #7ACCC2;"></i> MITRA BIMBEL TERPERCAYA
            </span>
            <h2 class="fw-bold mb-2" style="color:#2F4858;">
                Daftar Bimbel Tersedia
            </h2>
            <p class="text-muted mx-auto" style="max-width: 600px; color: #6C7A82 !important;">
                Temukan tempat bimbingan belajar terbaik dengan pengajar berpengalaman untuk mendukung prestasi akademikmu.
            </p>
        </div>

        <div class="row g-4 justify-content-center">
            @forelse($bimbels as $index => $bimbel)
                @php
                    // Gambar cover fallback jika kosong
                    $defaultCovers = [
                        'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=600&q=80',
                        'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=600&q=80',
                        'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?w=600&q=80',
                        'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=600&q=80',
                        'https://images.unsplash.com/photo-1509062522246-3755977927d7?w=600&q=80',
                    ];
                    $coverUrl = $bimbel->cover ? asset('storage/' . $bimbel->cover) : $defaultCovers[$index % count($defaultCovers)];
                    
                    // Logo fallback jika kosong
                    $logoUrl = $bimbel->logo ? asset('storage/' . $bimbel->logo) : 'https://ui-avatars.com/api/?name=' . urlencode($bimbel->nama) . '&background=7ACCC2&color=FFFFFF&bold=true';
                    $avgRating = number_format($bimbel->reviews_avg_rating ?? 0, 1);
                @endphp

                <div class="col-lg-4 col-md-6">
                    <div class="bimbel-card h-100 d-flex flex-column">
                        <!-- Card Banner Image & Badges -->
                        <div class="position-relative">
                            <img src="{{ $coverUrl }}" class="bimbel-card-banner" alt="{{ $bimbel->nama }}">
                            <div class="bimbel-card-overlay">
                                <span class="badge rounded-pill px-3 py-2" style="background: rgba(255, 255, 255, 0.95); color: #2F4858; font-weight: 700; font-size: 11px; backdrop-filter: blur(4px);">
                                    <i class="bi bi-book-fill me-1" style="color: #7ACCC2;"></i> {{ Str::limit($bimbel->mapel, 20) }}
                                </span>
                                <span class="badge rounded-pill px-3 py-2" style="background: rgba(255, 166, 158, 0.95); color: #ffffff; font-weight: 700; font-size: 11px;">
                                    <i class="bi bi-mortarboard-fill me-1"></i> {{ $bimbel->jenjang }}
                                </span>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-4 flex-grow-1 d-flex flex-column">
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <img src="{{ $logoUrl }}" class="bimbel-logo-avatar" alt="Logo {{ $bimbel->nama }}">
                                <div class="w-100">
                                    <h5 class="fw-bold mb-1" style="color: #2F4858;">{{ $bimbel->nama }}</h5>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <small class="text-muted">
                                            <i class="bi bi-geo-alt-fill text-danger me-1"></i>{{ $bimbel->kota }}
                                        </small>
                                        <span class="badge rounded-pill px-2 py-1" style="background: #fff8e6; color: #b78103; border: 1px solid #ffe8a3; font-weight: 700; font-size: 11px;">
                                            <i class="bi bi-star-fill text-warning me-1"></i> {{ $avgRating > 0 ? $avgRating : 'Baru' }}
                                            @if(($bimbel->reviews_count ?? 0) > 0)
                                                <span class="text-muted font-weight-normal">({{ $bimbel->reviews_count }})</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <p class="small text-secondary mb-4 flex-grow-1" style="line-height: 1.6;">
                                {{ Str::limit($bimbel->deskripsi ?? 'Bimbingan belajar berkualitas dengan kurikulum terbaik, pengajar profesional, serta waktu fleksibel untuk membantu siswa meraih impian.', 110) }}
                            </p>

                            <!-- Card Footer / Price & Details -->
                            <div class="d-flex align-items-center justify-content-between pt-3 border-top mt-auto" style="border-color: rgba(0,0,0,0.06) !important;">
                                <div>
                                    <small class="text-muted d-block" style="font-size: 11px; font-weight: 500;">Biaya Mulai</small>
                                    <strong style="color: #2F4858; font-size: 1.15rem;">
                                        Rp {{ number_format($bimbel->harga_mulai, 0, ',', '.') }}
                                    </strong>
                                    <small class="text-muted" style="font-size: 11px;">/bln</small>
                                </div>

                                <a href="{{ route('bimbel.pendaftaran', $bimbel->id) }}" 
                                   class="btn btn-sm rounded-pill px-3 py-2 shadow-sm font-weight-600" 
                                   style="background: #7ACCC2; color: #ffffff; transition: all 0.2s;"
                                   onmouseover="this.style.background='#68bbb1';"
                                   onmouseout="this.style.background='#7ACCC2';">
                                    Pilih Bimbel <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="p-5 rounded-4" style="background: #ffffff; border: 2px dashed rgba(122, 204, 194, 0.4);">
                        <i class="bi bi-building fs-1 text-muted d-block mb-3"></i>
                        <h5 class="fw-bold text-muted">Belum ada bimbel tersedia</h5>
                        <p class="text-muted small mb-0">Bimbel yang telah terdaftar dan disetujui akan tampil di sini.</p>
                    </div>
                </div>
            @endforelse
        </div>

        @if(count($bimbels) > 0)
            <div class="text-center mt-5">
                <a href="{{ route('bimbel.guest') }}"
                   class="btn btn-lg rounded-pill px-5 shadow-sm"
                   style="border:2px solid #7ACCC2; color:#2F4858; font-weight:600; text-decoration:none;"
                   onmouseover="this.style.background='#7ACCC2'; this.style.color='#FAFAFA';"
                   onmouseout="this.style.background='transparent'; this.style.color='#2F4858';">
                    Lihat Semua Bimbel
                    <i class="bi bi-grid-fill ms-2"></i>
                </a>
            </div>
        @endif
    </div>
</section>

{{-- =========================================================
MATA PELAJARAN TERPOPULER
========================================================= --}}
<section class="py-5" style="background-color: #FAFCFB;">
    <div class="container">
        <h3 class="fw-bold text-center mb-5" style="color:#2F4858;">
            Mata Pelajaran Terpopuler
        </h3>

        @php
            $defaultIcons = [
                'bi-plus-slash-minus',
                'bi-book-half',
                'bi-cpu-fill',
                'bi-lightning-charge-fill',
                'bi-tree-fill',
            ];

            // Warna-warna sedikit diturunkan saturasinya agar tidak menusuk mata
            $defaultColors = [
                '#4C9DB8',
                '#F27474',
                '#59C4BC',
                '#EBB93B',
                '#96BD4F',
            ];
        @endphp

        <div class="row justify-content-center g-4">
            @forelse($mapels as $index => $mapel)
                @php
                    $icon = trim($mapel->icon ?? '');
                    if (str_starts_with($icon, 'bi ')) $icon = substr($icon, 3);
                    if (!str_starts_with($icon, 'bi-')) $icon = 'bi-' . $icon;
                    if (empty(trim($mapel->icon ?? ''))) $icon = $defaultIcons[$index % count($defaultIcons)];

                    $warna = !empty($mapel->warna) ? $mapel->warna : $defaultColors[$index % count($defaultColors)];
                @endphp

                <div class="col-auto">
                    <div class="card-work shadow-sm">
                        <div class="img-section" style="background: {{ $warna }};"></div>
                        <div class="card-desc">
                            <i class="bi {{ $icon }} bg-icon" aria-hidden="true"></i>
                            <div class="card-header">
                                <div class="card-title"></div>
                                <div class="card-menu">
                                    <div class="dot"></div>
                                    <div class="dot"></div>
                                    <div class="dot"></div>
                                </div>
                            </div>
                            <div class="card-time">
                                {{ $mapel->nama }}
                            </div>
                            <p class="recent">
                                {{ $mapel->jumlah_bimbel }} Bimbel
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p class="text-muted">Belum ada mata pelajaran.</p>
                </div>
            @endforelse
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('mapel.guest') }}"
               class="btn btn-lg rounded-pill px-5 shadow-sm"
               style="border:2px solid #7ACCC2; color:#2F4858; font-weight:600; text-decoration:none;"
               onmouseover="this.style.background='#7ACCC2'; this.style.color='#FAFAFA';"
               onmouseout="this.style.background='transparent'; this.style.color='#2F4858';">
                Lihat Lainnya
                <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

{{-- =========================================================
PAKET DAFTARKAN BIMBEL
========================================================= --}}
<section class="py-5" id="paket-bimbel">
    <div class="container">
        <div class="text-center mb-5">
            <span class="pricing-section-badge">
                Untuk Pemilik Bimbel
            </span>
            <h2 class="fw-bold mt-3" style="color:#2F4858;">
                Pasarkan Bimbelmu di LesGo
            </h2>
            <p class="text-muted" style="color: #6C7A82 !important;">
                Satu paket lengkap untuk menjangkau lebih banyak siswa.
            </p>
        </div>

        <div class="row justify-content-center">
            {{-- PAKET PEMASARAN BIMBEL --}}
            <div class="col-lg-5 col-md-7">
                <div class="pricing-card pricing-pro h-100 text-center">
                    <div class="popular-badge">
                        <i class="bi bi-megaphone-fill me-1"></i> PAKET PEMASARAN BIMBEL
                    </div>

                    <div class="pricing-header mt-2">
                        <span class="pricing-badge pro">PEMASARAN</span>
                        <h3 class="fw-bold mt-3" style="color:#2F4858;">Paket Pemasaran Bimbel</h3>
                        <p class="text-muted">Tampilkan bimbelmu dan jangkau lebih banyak calon siswa.</p>
                    </div>

                    <div class="pricing-price">
                        <span>Rp</span><strong>10.000</strong><small>/bulan</small>
                    </div>

                    <div class="pricing-features text-start">
                        <div><i class="bi bi-check-circle-fill"></i> Profil bimbel di LesGo</div>
                        <div><i class="bi bi-check-circle-fill"></i> Tampil di hasil pencarian</div>
                        <div><i class="bi bi-check-circle-fill"></i> Informasi bimbel lengkap</div>
                        <div><i class="bi bi-check-circle-fill"></i> Daftar mata pelajaran</div>
                        <div><i class="bi bi-check-circle-fill"></i> Sistem rating & ulasan</div>
                        <div><i class="bi bi-megaphone-fill"></i> Promosi selama <strong>30 hari</strong></div>
                    </div>

                    @auth
                    <a href="{{ route('bimbel.daftar') }}"
                       class="btn w-100 pricing-button mt-3"
                       style="background:#F2847B; color:#FAFAFA; border: 2px solid #F2847B;">
                        Daftarkan Bimbel Sekarang
                    </a>
                    @else
                    <a href="{{ route('login') }}"
                       class="btn w-100 pricing-button mt-3"
                       style="background:#F2847B; color:#FAFAFA; border: 2px solid #F2847B;">
                        Login untuk Daftar
                    </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
