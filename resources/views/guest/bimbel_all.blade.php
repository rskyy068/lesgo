@extends('layouts.guest')

@section('title', 'Semua Bimbel - LesGo')

@push('style')
<style>
    .bimbel-header {
        background: linear-gradient(135deg, #DDFFF7 0%, #ffffff 60%, #ffe9e7 100%);
        padding: 60px 0 40px;
        position: relative;
    }

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

    .filter-card {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid rgba(122, 204, 194, 0.2);
        box-shadow: 0 6px 20px rgba(47, 72, 88, 0.04);
        padding: 20px;
    }
</style>
@endpush

@section('content')

<!-- Header Section -->
<section class="bimbel-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="d-inline-block rounded-pill px-3 py-2 mb-3"
                      style="background: rgba(122, 204, 194, 0.25); color: #2F4858; font-weight: 700; font-size: 13px;">
                    <i class="bi bi-building-check me-2" style="color: #7ACCC2;"></i> MITRA LESGO
                </span>
                <h2 class="display-6 fw-bold mb-2" style="color: #2F4858;">Daftar Semua Bimbel</h2>
                <p class="mb-0" style="color: #6b8496;">Jelajahi dan pilih tempat bimbingan belajar terbaik yang sesuai dengan kebutuhan Anda.</p>
            </div>
        </div>
    </div>
</section>

<!-- Filter & Search Section -->
<section class="py-4" style="background-color: #f8fbfb;">
    <div class="container">
        <div class="filter-card mb-4">
            <form action="{{ route('bimbel.guest') }}" method="GET" class="row g-3 align-items-center">
                <div class="col-lg-5 col-md-12">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0 ps-3">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" 
                               name="q" 
                               class="form-control bg-light border-0 py-2" 
                               placeholder="Cari nama bimbel, kota, atau jenjang..."
                               value="{{ request('q') }}">
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <select name="mapel" class="form-select bg-light border-0 py-2">
                        <option value="">Semua Mata Pelajaran</option>
                        @foreach($allMapels as $mapelItem)
                            <option value="{{ $mapelItem }}" {{ request('mapel') == $mapelItem ? 'selected' : '' }}>
                                {{ $mapelItem }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-2 col-md-6">
                    <select name="kota" class="form-select bg-light border-0 py-2">
                        <option value="">Semua Kota</option>
                        @foreach($allKotas as $kotaItem)
                            <option value="{{ $kotaItem }}" {{ request('kota') == $kotaItem ? 'selected' : '' }}>
                                {{ $kotaItem }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-2 col-md-6">
                    <select name="sort" class="form-select bg-light border-0 py-2">
                        <option value="rating" {{ request('sort', 'rating') == 'rating' ? 'selected' : '' }}>⭐ Rating Tertinggi</option>
                        <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>🆕 Terbaru</option>
                        <option value="harga_asc" {{ request('sort') == 'harga_asc' ? 'selected' : '' }}>🏷️ Harga Termurah</option>
                        <option value="harga_desc" {{ request('sort') == 'harga_desc' ? 'selected' : '' }}>🏷️ Harga Tertinggi</option>
                    </select>
                </div>

                <div class="col-lg-1 col-md-12 d-flex gap-2">
                    <button type="submit" class="btn text-white w-100 rounded-pill py-2 font-weight-600 shadow-sm" style="background: #7ACCC2;">
                        Filter
                    </button>
                    @if(request()->hasAny(['q', 'mapel', 'kota', 'sort']))
                        <a href="{{ route('bimbel.guest') }}" class="btn btn-outline-secondary rounded-pill py-2" title="Reset Filter">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Cards Grid Section -->
        <div class="row g-4">
            @forelse($bimbels as $index => $bimbel)
                @php
                    $defaultCovers = [
                        'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=600&q=80',
                        'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=600&q=80',
                        'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?w=600&q=80',
                        'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=600&q=80',
                        'https://images.unsplash.com/photo-1509062522246-3755977927d7?w=600&q=80',
                    ];
                    $coverUrl = $bimbel->cover ? asset('storage/' . $bimbel->cover) : $defaultCovers[$index % count($defaultCovers)];
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
                                {{ Str::limit($bimbel->deskripsi ?? 'Bimbingan belajar berkualitas dengan pengajar berpengalaman dan metode belajar menyenangkan.', 110) }}
                            </p>

                            <!-- Card Footer / Price & Action -->
                            <div class="d-flex align-items-center justify-content-between pt-3 border-top mt-auto" style="border-color: rgba(0,0,0,0.06) !important;">
                                <div>
                                    <small class="text-muted d-block" style="font-size: 11px; font-weight: 500;">Biaya Mulai</small>
                                    <strong style="color: #2F4858; font-size: 1.15rem;">
                                        Rp {{ number_format($bimbel->harga_mulai, 0, ',', '.') }}
                                    </strong>
                                    <small class="text-muted" style="font-size: 11px;">/bln</small>
                                </div>

                                <a href="{{ route('bimbel.pendaftaran', $bimbel->id) }}" 
                                   class="btn btn-sm rounded-pill px-3 py-2 shadow-sm font-weight-600 text-white" 
                                   style="background: #7ACCC2;">
                                    Pilih Bimbel <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="p-5 rounded-4 bg-white border">
                        <i class="bi bi-search fs-1 text-muted d-block mb-3"></i>
                        <h5 class="fw-bold text-muted">Bimbel tidak ditemukan</h5>
                        <p class="text-muted small mb-3">Coba gunakan kata kunci lain atau reset filter pencarian Anda.</p>
                        <a href="{{ route('bimbel.guest') }}" class="btn btn-sm rounded-pill text-white px-4" style="background: #7ACCC2;">
                            Reset Pencarian
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-5">
            {{ $bimbels->links() }}
        </div>
    </div>
</section>

@endsection
