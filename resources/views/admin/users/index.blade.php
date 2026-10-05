@extends('layouts.admin')

@section('title', 'Manajemen User - LesGo Admin')

@push('style')
<style>
    /* Stats mini cards */
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

    /* User avatar circle */
    .user-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 14px;
        color: var(--dark);
        background: linear-gradient(135deg, #93E1D8, #DDFFF7);
        flex-shrink: 0;
        border: 2px solid #ffffff;
        box-shadow: 0 2px 6px rgba(47, 72, 88, 0.08);
    }

    .user-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }

    /* Role pill */
    .role-pill {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 12px;
        border-radius: 30px;
        font-size: 11.5px;
        font-weight: 600;
    }

    .role-pill.role-admin {
        background-color: rgba(255, 166, 158, 0.18);
        color: #d87e76;
    }

    .role-pill.role-user {
        background-color: rgba(147, 225, 216, 0.22);
        color: #2f7568;
    }

    /* Action buttons */
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

    /* Empty state */
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

    /* Filter chip */
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

    /* Pagination wrapper */
    .pagination-wrap {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 24px;
        gap: 16px;
        flex-wrap: wrap;
    }

    /* Make Laravel pagination look like Bootstrap */
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
</style>
@endpush

@section('content')
<!-- Header -->
<div class="row align-items-center mb-4">
    <div class="col">
        <h1 class="fw-bold h2 mb-1" style="color: var(--dark);">
            <i class="bi bi-people-fill me-2" style="color: var(--accent);"></i>
            Manajemen User
        </h1>
        <p class="text-muted mb-0">Kelola semua pengguna terdaftar di LesGo.</p>
    </div>
    {{-- <div class="col-auto">
        <a href="{{ route('admin.users.create') }}" class="btn rounded-pill px-4 shadow-sm text-white"
           style="background-color: var(--accent);">
            <i class="bi bi-person-plus-fill me-1"></i> Tambah User
        </a>
    </div> --}}
</div>

<!-- Statistik Mini -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-mini">
            <div class="icon-mini bg-accent-light" style="color:#ea8a80;">
                <i class="bi bi-people-fill"></i>
            </div>
            <div>
                <p class="label">Total User</p>
                <p class="value">{{ number_format($stats['total']) }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-mini">
            <div class="icon-mini" style="background-color: rgba(255, 166, 158, 0.18); color:#d87e76;">
                <i class="bi bi-shield-fill-check"></i>
            </div>
            <div>
                <p class="label">Administrator</p>
                <p class="value">{{ number_format($stats['admin']) }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-mini">
            <div class="icon-mini bg-primary-light" style="color:#55a096;">
                <i class="bi bi-person-fill"></i>
            </div>
            <div>
                <p class="label">User Biasa</p>
                <p class="value">{{ number_format($stats['user']) }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Filter & Pencarian -->
<div class="card main-card border-0 p-4 mb-4">
    <form method="GET" action="{{ route('admin.users.index') }}" class="row g-3 align-items-end">
        <div class="col-md-5">
            <label class="form-label small fw-semibold" style="color: var(--dark);">
                <i class="bi bi-search me-1"></i> Cari User
            </label>
            <input type="text" name="search" class="form-control"
                   placeholder="Nama, email, atau nomor telepon..."
                   value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <label class="form-label small fw-semibold" style="color: var(--dark);">
                <i class="bi bi-funnel me-1"></i> Role
            </label>
            <select name="role" class="form-select">
                <option value="">-- Semua Role --</option>
                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Administrator</option>
                <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>User Biasa</option>
            </select>
        </div>
        <div class="col-md-4 d-flex gap-2">
            <button type="submit" class="btn rounded-pill px-4 shadow-sm flex-grow-1 text-white"
                    style="background-color: var(--dark);">
                <i class="bi bi-funnel-fill me-1"></i> Terapkan
            </button>
            @if(request()->hasAny(['search','role']))
                <a href="{{ route('admin.users.index') }}" class="btn btn-light rounded-pill px-3">
                    <i class="bi bi-x-circle"></i> Reset
                </a>
            @endif
        </div>
    </form>

    @if(request()->hasAny(['search','role']))
        <div class="mt-3 d-flex flex-wrap gap-2">
            @if(request('search'))
                <span class="filter-chip"><i class="bi bi-search"></i> "{{ request('search') }}"</span>
            @endif
            @if(request('role'))
                <span class="filter-chip"><i class="bi bi-funnel"></i> Role: {{ request('role') === 'admin' ? 'Administrator' : 'User Biasa' }}</span>
            @endif
        </div>
    @endif
</div>

<!-- Tabel User -->
<div class="card main-card border-0 p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold mb-0" style="color: var(--dark);">
            Daftar User
            <span class="badge rounded-pill ms-2" style="background-color: rgba(147,225,216,0.2); color:#2f7568;">
                {{ $users->total() }} total
            </span>
        </h5>
    </div>

    @if($users->isEmpty())
        <div class="empty-state">
            <i class="bi bi-inbox"></i>
            <h5 class="fw-bold" style="color: var(--dark);">Tidak ada user</h5>
            <p class="mb-3">User yang Anda cari tidak ditemukan.</p>
            <a href="{{ route('admin.users.create') }}" class="btn rounded-pill px-4 shadow-sm text-white"
               style="background-color: var(--accent);">
                <i class="bi bi-person-plus-fill me-1"></i> Tambah User Pertama
            </a>
        </div>
    @else
        <div class="table-responsive">
            <table class="table custom-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>USER</th>
                        <th>TELEPON</th>
                        <th>ROLE</th>
                        <th>BERGABUNG</th>
                        <th class="text-end" style="width: 170px;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $i => $user)
                        <tr>
                            <td class="text-muted small">{{ $users->firstItem() + $i }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="user-avatar">
                                        @if($user->photo)
                                            <img src="{{ $user->photo }}" alt="{{ $user->name }}">
                                        @else
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        @endif
                                    </div>
                                    <div>
                                        <span class="fw-semibold d-block" style="color: var(--dark);">{{ $user->name }}</span>
                                        <span class="text-muted small">{{ $user->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="text-secondary">{{ $user->phone ?? '—' }}</span>
                            </td>
                            <td>
                                @if($user->isAdmin())
                                    <span class="role-pill role-admin">
                                        <i class="bi bi-shield-fill-check"></i> Admin
                                    </span>
                                @else
                                    <span class="role-pill role-user">
                                        <i class="bi bi-person-fill"></i> User
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="text-secondary small">
                                    {{ $user->created_at ? $user->created_at->translatedFormat('d M Y') : '—' }}
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.users.show', $user) }}"
                                       class="btn btn-outline-secondary btn-icon"
                                       title="Lihat detail">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user) }}"
                                              method="POST"
                                              onsubmit="return confirm('Hapus user {{ addslashes($user->name) }}? Tindakan ini tidak dapat dibatalkan.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-icon"
                                                    title="Hapus user">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @else
                                        <button class="btn btn-outline-secondary btn-icon" disabled
                                                title="Tidak dapat menghapus akun sendiri">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pagination-wrap">
            <small class="text-muted">
                Menampilkan {{ $users->firstItem() }}–{{ $users->lastItem() }} dari {{ $users->total() }} user
            </small>
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection
