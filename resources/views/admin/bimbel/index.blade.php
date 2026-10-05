@extends('layouts.admin')

@section('title', 'Manajemen Bimbel - LesGo Admin')

@push('style')
<style>
    .stat-mini {
        background: var(--white);
        border-radius: 16px;
        padding: 18px 22px;
        border: 1px solid rgba(147, 225, 216, 0.18);
        box-shadow: 0 4px 10px rgba(47, 72, 88, 0.04);
        display: flex;
        align-items: center;
        gap: 14px;
        transition: var(--transition);
    }

    .stat-mini:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
    }

    .stat-mini .icon-mini {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .stat-mini .label {
        font-size: 12px;
        color: var(--dark-muted);
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        margin: 0;
    }

    .stat-mini .value {
        font-size: 22px;
        font-weight: 800;
        color: var(--dark);
        margin: 0;
        line-height: 1.1;
    }

    .bimbel-thumb {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 16px;
        color: var(--dark);
        background: linear-gradient(135deg, #93E1D8, #DDFFF7);
        flex-shrink: 0;
        border: 2px solid #ffffff;
        box-shadow: 0 2px 6px rgba(47, 72, 88, 0.08);
        overflow: hidden;
    }

    .bimbel-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 12px;
    }

    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 12px;
        border-radius: 30px;
        font-size: 11.5px;
        font-weight: 600;
    }

    .status-pill.status-aktif {
        background-color: rgba(147, 225, 216, 0.22);
        color: #2f7568;
    }

    .status-pill.status-nonaktif {
        background-color: rgba(255, 166, 158, 0.18);
        color: #d87e76;
    }

    .jenjang-badge {
        display: inline-block;
        padding: 2px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
        background-color: rgba(147, 225, 216, 0.12);
        color: #55a096;
    }

    .action-buttons {
        display: flex;
        gap: 6px;
        justify-content: flex-end;
    }

    .action-buttons form { display: inline; }

    .btn-icon {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        border-width: 1.5px;
        font-size: 15px;
        transition: var(--transition);
    }

    .btn-icon:hover { transform: translateY(-2px); }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: var(--dark-muted);
    }

    .empty-state i {
        font-size: 56px;
        color: #c9ded9;
        display: block;
        margin-bottom: 12px;
    }

    .filter-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        background-color: rgba(147, 225, 216, 0.18);
        color: #2f7568;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
    }

    .pagination-wrap {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 24px;
        gap: 16px;
        flex-wrap: wrap;
    }

    .pagination {
        margin: 0;
        gap: 4px;
    }
    .pagination .page-link {
        border-radius: 10px;
        color: var(--dark);
        border: 1px solid rgba(147, 225, 216, 0.25);
        padding: 8px 14px;
        font-weight: 500;
    }
    .pagination .page-item.active .page-link {
        background-color: var(--dark);
        border-color: var(--dark);
        color: #fff;
    }
    .pagination .page-link:hover {
        background-color: rgba(147, 225, 216, 0.18);
        color: var(--dark);
    }

    .custom-table {
        margin-bottom: 0;
    }
    .custom-table th {
        font-size: 11.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        color: var(--dark-muted);
        border-bottom: 2px solid rgba(147, 225, 216, 0.2);
        padding: 14px 12px;
    }
    .custom-table td {
        padding: 14px 12px;
        vertical-align: middle;
        border-bottom: 1px solid rgba(147, 225, 216, 0.1);
        font-size: 14px;
    }
    .custom-table tbody tr:hover {
        background-color: rgba(147, 225, 216, 0.04);
    }
    .custom-table tbody tr:last-child td {
        border-bottom: none;
    }
</style>
@endpush

@section('content')
<!-- Header -->
<div class="row align-items-center mb-4">
    <div class="col">
        <h1 class="fw-bold h2 mb-1" style="color: var(--dark);">
            <i class="bi bi-mortarboard-fill me-2" style="color: var(--accent);"></i>
            Manajemen Bimbel
        </h1>
        <p class="text-muted mb-0">Kelola semua lembaga bimbingan belajar di LesGo.</p>
    </div>
    <div class="col-auto">
        <a href="{{ route('admin.bimbel.create') }}" class="btn rounded-pill px-4 shadow-sm text-white"
           style="background-color: var(--accent);">
            <i class="bi bi-plus-circle-fill me-1"></i> Tambah Bimbel
        </a>
    </div>
</div>

<!-- Statistik Mini -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-mini">
            <div class="icon-mini bg-accent-light" style="color:#ea8a80;">
                <i class="bi bi-mortarboard-fill"></i>
            </div>
            <div>
                <p class="label">Total Bimbel</p>
                <p class="value">{{ number_format($stats['total']) }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-mini">
            <div class="icon-mini bg-primary-light" style="color:#55a096;">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <div>
                <p class="label">Aktif</p>
                <p class="value">{{ number_format($stats['aktif']) }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-mini">
            <div class="icon-mini" style="background-color: rgba(255, 166, 158, 0.18); color:#d87e76;">
                <i class="bi bi-x-circle-fill"></i>
            </div>
            <div>
                <p class="label">Nonaktif</p>
                <p class="value">{{ number_format($stats['nonaktif']) }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Filter & Pencarian -->
<div class="card main-card border-0 p-4 mb-4">
    <form method="GET" action="{{ route('admin.bimbel.index') }}" class="row g-3 align-items-end">
        <div class="col-md-5">
            <label class="form-label small fw-semibold" style="color: var(--dark);">
                <i class="bi bi-search me-1"></i> Cari Bimbel
            </label>
            <input type="text" name="search" class="form-control"
                   placeholder="Nama, mata pelajaran, kota, atau alamat..."
                   value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <label class="form-label small fw-semibold" style="color: var(--dark);">
                <i class="bi bi-funnel me-1"></i> Status
            </label>
            <select name="status" class="form-select">
                <option value="">-- Semua Status --</option>
                <option value="Aktif" {{ request('status') === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="Nonaktif" {{ request('status') === 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>
        <div class="col-md-4 d-flex gap-2">
            <button type="submit" class="btn rounded-pill px-4 shadow-sm flex-grow-1 text-white"
                    style="background-color: var(--dark);">
                <i class="bi bi-funnel-fill me-1"></i> Terapkan
            </button>
            @if(request()->hasAny(['search','status']))
                <a href="{{ route('admin.bimbel.index') }}" class="btn btn-light rounded-pill px-3">
                    <i class="bi bi-x-circle"></i> Reset
                </a>
            @endif
        </div>
    </form>

    @if(request()->hasAny(['search','status']))
        <div class="mt-3 d-flex flex-wrap gap-2">
            @if(request('search'))
                <span class="filter-chip"><i class="bi bi-search"></i> "{{ request('search') }}"</span>
            @endif
            @if(request('status'))
                <span class="filter-chip"><i class="bi bi-funnel"></i> Status: {{ request('status') }}</span>
            @endif
        </div>
    @endif
</div>

<!-- Tabel Bimbel -->
<div class="card main-card border-0 p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold mb-0" style="color: var(--dark);">
            Daftar Bimbel
            <span class="badge rounded-pill ms-2" style="background-color: rgba(147,225,216,0.2); color:#2f7568;">
                {{ $bimbels->total() }} total
            </span>
        </h5>
    </div>

    @if($bimbels->isEmpty())
        <div class="empty-state">
            <i class="bi bi-inbox"></i>
            <h5 class="fw-bold" style="color: var(--dark);">Tidak ada bimbel</h5>
            <p class="mb-3">Bimbel yang Anda cari tidak ditemukan.</p>
            <a href="{{ route('admin.bimbel.create') }}" class="btn rounded-pill px-4 shadow-sm text-white"
               style="background-color: var(--accent);">
                <i class="bi bi-plus-circle-fill me-1"></i> Tambah Bimbel Pertama
            </a>
        </div>
    @else
        <div class="table-responsive">
            <table class="table custom-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>BIMBEL</th>
                        <th>MAPEL</th>
                        <th>JENJANG</th>
                        <th>KOTA</th>
                        <th>STATUS</th>
                        <th>MASA AKTIF (30 HARI)</th>
                        <th>HARGA</th>
                        <th class="text-end" style="width: 200px;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bimbels as $i => $bimbel)
                        <tr>
                            <td class="text-muted small">{{ $bimbels->firstItem() + $i }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bimbel-thumb">
                                        @if($bimbel->logo)
                                            <img src="{{ Storage::url($bimbel->logo) }}" alt="{{ $bimbel->nama }}">
                                        @else
                                            <i class="bi bi-building"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <span class="fw-semibold d-block" style="color: var(--dark);">{{ $bimbel->nama }}</span>
                                        <span class="text-muted small">{{ Str::limit($bimbel->mapel, 30) }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="text-secondary small">{{ $bimbel->mapel }}</span>
                            </td>
                            <td>
                                <span class="jenjang-badge">{{ $bimbel->jenjang }}</span>
                            </td>
                            <td>
                                <span class="text-secondary">
                                    <i class="bi bi-geo-alt-fill me-1" style="color: #55a096;"></i>
                                    {{ $bimbel->kota }}
                                </span>
                            </td>
                            <td>
                                @if($bimbel->isExpired())
                                    <span class="status-pill status-nonaktif">
                                        <i class="bi bi-x-circle-fill"></i> Kedaluwarsa
                                    </span>
                                @elseif($bimbel->status === 'Aktif')
                                    <span class="status-pill status-aktif">
                                        <i class="bi bi-check-circle-fill"></i> Aktif
                                    </span>
                                @else
                                    <span class="status-pill status-nonaktif">
                                        <i class="bi bi-x-circle-fill"></i> Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($bimbel->isExpired())
                                    <span class="badge bg-danger-subtle text-danger rounded-pill px-2 py-1" style="font-size: 11px;">
                                        <i class="bi bi-exclamation-triangle-fill me-1"></i>Habis (0 Hari)
                                    </span>
                                @elseif($bimbel->remainingDays() <= 7)
                                    <span class="badge bg-warning-subtle text-warning rounded-pill px-2 py-1" style="font-size: 11px;">
                                        <i class="bi bi-clock-history me-1"></i>Sisa {{ $bimbel->remainingDays() }} Hari
                                    </span>
                                @else
                                    <span class="badge bg-success-subtle text-success rounded-pill px-2 py-1" style="font-size: 11px;">
                                        <i class="bi bi-shield-check me-1"></i>Sisa {{ $bimbel->remainingDays() }} Hari
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="fw-semibold" style="color: var(--dark);">
                                    Rp{{ number_format($bimbel->harga_mulai, 0, ',', '.') ?? '—' }}
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <form action="{{ route('admin.bimbel.perpanjang', $bimbel) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-outline-success btn-icon" title="Perpanjang Membership 30 Hari">
                                            <i class="bi bi-arrow-repeat"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.bimbel.show', $bimbel) }}"
                                       class="btn btn-outline-secondary btn-icon"
                                       title="Lihat detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.bimbel.edit', $bimbel) }}"
                                       class="btn btn-outline-primary btn-icon"
                                       title="Edit bimbel">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('admin.bimbel.destroy', $bimbel) }}"
                                          method="POST"
                                          onsubmit="return confirm('Hapus bimbel {{ addslashes($bimbel->nama) }}? Semua data terkait (review, favorit) akan ikut terhapus dan TIDAK DAPAT dibatalkan.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-icon"
                                                title="Hapus bimbel">
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

        <div class="pagination-wrap">
            <small class="text-muted">
                Menampilkan {{ $bimbels->firstItem() }}–{{ $bimbels->lastItem() }} dari {{ $bimbels->total() }} bimbel
            </small>
            {{ $bimbels->links() }}
        </div>
    @endif
</div>
@endsection
