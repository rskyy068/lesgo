@extends('layouts.guest')

@section('title', 'Semua Mata Pelajaran - LesGo')

@push('style')
<style>
    .mapel-header {
        background: linear-gradient(135deg, #DDFFF7 0%, #ffffff 60%, #ffe9e7 100%);
        padding: 60px 0 40px;
        position: relative;
    }

    /* CARD MATA PELAJARAN */
    .card-mapel-item {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid rgba(147, 225, 216, 0.25);
        box-shadow: 0 6px 18px rgba(47, 72, 88, 0.05);
        transition: all 0.3s ease;
        overflow: hidden;
        text-decoration: none;
        color: inherit;
        display: block;
        height: 100%;
        position: relative;
    }

    .card-mapel-item:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 28px rgba(47, 72, 88, 0.1);
        border-color: #7ACCC2;
        color: inherit;
    }

    .card-mapel-banner {
        height: 80px;
        width: 100%;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card-mapel-icon {
        font-size: 2.2rem;
        color: rgba(255, 255, 255, 0.95);
        z-index: 2;
        transition: transform 0.3s ease;
    }

    .card-mapel-item:hover .card-mapel-icon {
        transform: scale(1.15) rotate(5deg);
    }

    .card-mapel-body {
        padding: 20px;
        text-align: center;
    }

    .card-mapel-title {
        font-weight: 700;
        font-size: 1.1rem;
        color: #2F4858;
        margin-bottom: 6px;
    }

    .card-mapel-count {
        font-size: 0.85rem;
        color: #6b8496;
        font-weight: 500;
    }
</style>
@endpush

@section('content')

<!-- Header Section -->
<section class="mapel-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="d-inline-block rounded-pill px-3 py-2 mb-3"
                      style="background: rgba(255, 166, 158, 0.25); color: #2F4858; font-weight: 700; font-size: 13px;">
                    <i class="bi bi-book-half me-2" style="color: #FFA69E;"></i> KATALOG MAPEL
                </span>
                <h2 class="display-6 fw-bold mb-2" style="color: #2F4858;">Daftar Semua Mata Pelajaran</h2>
                <p class="mb-0" style="color: #6b8496;">Temukan bimbel spesialis berdasarkan bidang pelajaran yang ingin Anda kuasai.</p>
            </div>
        </div>
    </div>
</section>

<!-- Filter & Grid Section -->
<section class="py-5" style="background-color: #f8fbfb; min-height: 65vh;">
    <div class="container">
        <!-- Search Bar -->
        <div class="row justify-content-center mb-5">
            <div class="col-lg-6 col-md-8">
                <form action="{{ route('mapel.guest') }}" method="GET">
                    <div class="input-group shadow-sm rounded-pill overflow-hidden bg-white p-1 border">
                        <span class="input-group-text bg-white border-0 ps-3">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" 
                               name="q" 
                               class="form-control border-0 shadow-none py-2" 
                               placeholder="Cari mata pelajaran..." 
                               value="{{ request('q') }}">
                        <button class="btn px-4 text-white rounded-pill font-weight-600" style="background: #FFA69E;" type="submit">
                            Cari
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Mapels Grid -->
        @php
            $defaultIcons = [
                'bi-plus-slash-minus',
                'bi-book-half',
                'bi-cpu-fill',
                'bi-lightning-charge-fill',
                'bi-tree-fill',
                'bi-globe-americas',
                'bi-funnel-fill',
                'bi-translate',
            ];

            $defaultColors = [
                '#4C9DB8',
                '#F27474',
                '#59C4BC',
                '#EBB93B',
                '#96BD4F',
                '#A78BFA',
                '#F472B6',
                '#34D399',
            ];
        @endphp

        <div class="row g-4 justify-content-center">
            @forelse($mapels as $index => $mapel)
                @php
                    $icon = trim($mapel->icon ?? '');
                    if (str_starts_with($icon, 'bi ')) $icon = substr($icon, 3);
                    if (!str_starts_with($icon, 'bi-')) $icon = 'bi-' . $icon;
                    if (empty(trim($mapel->icon ?? '')) || str_contains($mapel->icon, '/')) {
                        $icon = $defaultIcons[$index % count($defaultIcons)];
                    }

                    $warna = !empty($mapel->warna) ? $mapel->warna : $defaultColors[$index % count($defaultColors)];
                @endphp

                <div class="col-lg-3 col-md-4 col-sm-6">
                    <a href="{{ route('bimbel.guest', ['mapel' => $mapel->nama]) }}" class="card-mapel-item">
                        <div class="card-mapel-banner" style="background: {{ $warna }};">
                            <i class="bi {{ $icon }} card-mapel-icon"></i>
                        </div>
                        <div class="card-mapel-body">
                            <div class="card-mapel-title">{{ $mapel->nama }}</div>
                            <div class="card-mapel-count">
                                <i class="bi bi-building me-1"></i> {{ $mapel->jumlah_bimbel }} Bimbel
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="p-5 rounded-4 bg-white border">
                        <i class="bi bi-book-half fs-1 text-muted d-block mb-3"></i>
                        <h5 class="fw-bold text-muted">Mata pelajaran tidak ditemukan</h5>
                        <p class="text-muted small mb-3">Coba gunakan kata kunci pencarian lain.</p>
                        <a href="{{ route('mapel.guest') }}" class="btn btn-sm rounded-pill text-white px-4" style="background: #FFA69E;">
                            Lihat Semua Mapel
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>

@endsection
