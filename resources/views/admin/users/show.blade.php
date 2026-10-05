@extends('layouts.admin')

@section('title', 'Detail User - LesGo Admin')

@push('style')
<style>
    .detail-card {
        background: var(--white);
        border-radius: 20px;
        border: 1px solid rgba(147, 225, 216, 0.18);
        box-shadow: 0 8px 22px -12px rgba(47, 72, 88, 0.08);
    }

    .user-hero {
        background: linear-gradient(135deg, #93E1D8 0%, #DDFFF7 100%);
        border-radius: 20px;
        padding: 36px;
        display: flex;
        align-items: center;
        gap: 26px;
        box-shadow: 0 10px 26px -12px rgba(47, 72, 88, 0.16);
        margin-bottom: 22px;
    }

    .user-hero-avatar {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 42px;
        font-weight: 700;
        color: var(--dark);
        border: 5px solid #ffffff;
        box-shadow: 0 6px 16px rgba(47, 72, 88, 0.1);
        flex-shrink: 0;
    }

    .user-hero-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
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
    }

    .info-value {
        color: var(--dark);
        font-weight: 600;
        font-size: 14px;
        text-align: right;
    }

    .role-pill {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 14px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
    }

    .role-pill.role-admin {
        background-color: rgba(255, 166, 158, 0.22);
        color: #d87e76;
    }
    .role-pill.role-user {
        background-color: rgba(147, 225, 216, 0.22);
        color: #2f7568;
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
</style>
@endpush

@section('content')
<!-- Header -->
<div class="row align-items-center mb-3">
    <div class="col">
        <h1 class="fw-bold h2 mb-1" style="color: var(--dark);">
            <i class="bi bi-person-vcard-fill me-2" style="color: var(--accent);"></i>
            Detail User
        </h1>
        <p class="text-muted mb-0">Informasi lengkap pengguna LesGo.</p>
    </div>
    <div class="col-auto">
        <a href="{{ route('admin.users.index') }}" class="btn btn-light rounded-pill px-3 shadow-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<!-- Hero -->
<div class="user-hero">
    <div class="user-hero-avatar">
        @if($user->photo)
            <img src="{{ $user->photo }}" alt="{{ $user->name }}">
        @else
            {{ strtoupper(substr($user->name, 0, 1)) }}
        @endif
    </div>
    <div>
        <h2 class="fw-bold mb-1" style="color: var(--dark);">{{ $user->name }}</h2>
        <p class="mb-2" style="color: var(--dark); opacity: 0.85;">{{ $user->email }}</p>
        @if($user->isAdmin())
            <span class="role-pill role-admin"><i class="bi bi-shield-fill-check"></i> Administrator</span>
        @else
            <span class="role-pill role-user"><i class="bi bi-person-fill"></i> User Biasa</span>
        @endif
    </div>
</div>

<div class="row g-4">
    <!-- Info Akun -->
    <div class="col-lg-7">
        <div class="detail-card p-4">
            <h5 class="fw-bold mb-3" style="color: var(--dark);">
                <i class="bi bi-info-circle-fill me-2" style="color: var(--accent);"></i>
                Informasi Akun
            </h5>

            <div class="info-row">
                <div class="info-label"><i class="bi bi-person-fill"></i> Nama Lengkap</div>
                <div class="info-value">{{ $user->name }}</div>
            </div>
            <div class="info-row">
                <div class="info-label"><i class="bi bi-envelope-fill"></i> Email</div>
                <div class="info-value">{{ $user->email }}</div>
            </div>
            <div class="info-row">
                <div class="info-label"><i class="bi bi-telephone-fill"></i> Nomor Telepon</div>
                <div class="info-value">{{ $user->phone ?? '—' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label"><i class="bi bi-shield-fill-check"></i> Role</div>
                <div class="info-value">
                    @if($user->isAdmin())
                        <span class="role-pill role-admin">Administrator</span>
                    @else
                        <span class="role-pill role-user">User Biasa</span>
                    @endif
                </div>
            </div>
            <div class="info-row">
                <div class="info-label"><i class="bi bi-calendar3"></i> Bergabung</div>
                <div class="info-value">
                    {{ $user->created_at ? $user->created_at->translatedFormat('d F Y') : '—' }}
                </div>
            </div>
            <div class="info-row">
                <div class="info-label"><i class="bi bi-clock-history"></i> Terakhir Diperbarui</div>
                <div class="info-value">
                    {{ $user->updated_at ? $user->updated_at->translatedFormat('d F Y, H:i') : '—' }}
                </div>
            </div>


            <div class="action-bar mt-4">
                

                @if($user->id === auth()->id())
                    <span class="btn-action btn-action-secondary" style="opacity: 0.6; cursor: not-allowed;" title="Tidak dapat menghapus akun sendiri">
                        <i class="bi bi-trash"></i> Hapus (akun sendiri)
                    </span>
                @else
                    <form action="{{ route('admin.users.destroy', $user) }}"
                          method="POST"
                          onsubmit="return confirm('Hapus user {{ addslashes($user->name) }}? Tindakan ini tidak dapat dibatalkan.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-action btn-action-danger">
                            <i class="bi bi-trash"></i> Hapus User
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <!-- Statistik & Status -->
    <div class="col-lg-5">
        <div class="detail-card p-4 mb-3">
            <h5 class="fw-bold mb-3" style="color: var(--dark);">
                <i class="bi bi-bar-chart-fill me-2" style="color: var(--accent);"></i>
                Statistik Aktivitas
            </h5>
            <div class="row g-3">
                <div class="col-6">
                    <div class="stat-tile">
                        <div class="number">{{ $user->reviews_count ?? 0 }}</div>
                        <div class="desc">Review</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="stat-tile">
                        <div class="number">{{ $user->favorites_count ?? 0 }}</div>
                        <div class="desc">Favorit</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="detail-card p-4" style="background: linear-gradient(135deg, #f4fbf9 0%, #ffffff 100%);">
            <h6 class="fw-bold mb-3" style="color: var(--dark);">
                <i class="bi bi-shield-check me-2" style="color: var(--accent);"></i>
                Status Akun
            </h6>

            <div class="d-flex align-items-center gap-3 mb-3">
                <i class="bi bi-check-circle-fill" style="color:#55a096; font-size: 22px;"></i>
                <div>
                    <strong style="color: var(--dark);">Aktif</strong>
                    <div class="text-secondary small">Akun dapat digunakan untuk login.</div>
                </div>
            </div>

            @if($user->id === auth()->id())
                <div class="d-flex align-items-center gap-3">
                    <i class="bi bi-person-badge-fill" style="color:#d87e76; font-size: 22px;"></i>
                    <div>
                        <strong style="color: var(--dark);">Ini adalah akun Anda</strong>
                        <div class="text-secondary small">Beberapa aksi terbatas untuk keamanan.</div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
