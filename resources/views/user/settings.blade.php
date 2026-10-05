@extends('layouts.guest')

@section('title', 'Pengaturan - LesGo')

@push('style')
<style>
    :root {
        --primary: #93E1D8;
        --primary-dark: #66c7bc;
        --secondary: #DDFFF7;
        --accent: #FFA69E;
        --dark: #2F4858;
        --dark-muted: #4a6577;
        --white: #f9f9f9;
        --input-bg: #f2f7f6;
        --border-color: #d6ede9;
    }

    body {
        background: linear-gradient(135deg, #e4f7f3 0%, #f4fbf9 50%, #fdf5f4 100%) !important;
        font-family: 'Poppins', sans-serif;
        color: var(--dark);
        min-height: 100vh;
    }

    .settings-wrap {
        max-width: 780px;
        margin: 0 auto;
        padding: 40px 16px 80px;
    }

    .settings-header {
        background: linear-gradient(135deg, #93E1D8 0%, #DDFFF7 100%);
        border-radius: 20px;
        padding: 32px;
        margin-bottom: 28px;
        display: flex;
        align-items: center;
        gap: 22px;
        box-shadow: 0 10px 26px -12px rgba(47, 72, 88, 0.16);
    }

    .settings-avatar {
        width: 88px;
        height: 88px;
        background: #ffffff;
        color: var(--dark);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 36px;
        font-weight: 700;
        border: 4px solid #ffffff;
        box-shadow: 0 6px 14px rgba(47, 72, 88, 0.08);
        flex-shrink: 0;
    }

    .settings-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }

    .settings-card {
        background: #ffffff;
        border-radius: 18px;
        padding: 28px;
        margin-bottom: 22px;
        border: 1px solid rgba(147, 225, 216, 0.18);
        box-shadow: 0 8px 22px -12px rgba(47, 72, 88, 0.08);
    }

    .settings-card .card-title {
        font-size: 17px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 4px;
    }

    .settings-card .card-subtitle {
        font-size: 13.5px;
        color: var(--dark-muted);
        margin-bottom: 18px;
    }

    .info-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 0;
        border-bottom: 1px dashed rgba(147, 225, 216, 0.35);
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        color: var(--dark-muted);
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .info-label i {
        color: var(--primary-dark);
    }

    .info-value {
        color: var(--dark);
        font-weight: 600;
        font-size: 14px;
    }

    .role-badge {
        background-color: rgba(147, 225, 216, 0.22);
        color: #2f7568;
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
    }

    .role-badge.admin {
        background-color: rgba(255, 166, 158, 0.22);
        color: #d87e76;
    }

    .btn-action {
        background-color: var(--accent);
        color: var(--white);
        border-radius: 12px;
        padding: 10px 20px;
        font-weight: 600;
        font-size: 14px;
        border: none;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        text-decoration: none;
    }

    .btn-action:hover {
        background-color: #ff8f85;
        color: var(--white);
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(255, 166, 158, 0.32);
    }

    .btn-secondary-action {
        background-color: transparent;
        color: var(--dark);
        border: 1.5px solid var(--border-color);
        border-radius: 12px;
        padding: 10px 20px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .btn-secondary-action:hover {
        background-color: var(--primary);
        border-color: var(--primary);
        color: var(--dark);
    }
</style>
@endpush

@section('content')
<div class="settings-wrap">

    <!-- Header -->
    <div class="settings-header">
        <div class="settings-avatar">
            @if($user->photo)
                <img src="{{ $user->photo }}" alt="Foto {{ $user->name }}">
            @else
                {{ strtoupper(substr($user->name, 0, 1)) }}
            @endif
        </div>
        <div>
            <h3 class="fw-bold mb-1" style="color: var(--dark);">{{ $user->name }}</h3>
            <p class="mb-2" style="color: var(--dark); opacity: 0.85;">{{ $user->email }}</p>
            @if($user->isAdmin())
                <span class="role-badge admin"><i class="bi bi-shield-fill-check me-1"></i>Administrator</span>
            @else
                <span class="role-badge"><i class="bi bi-person-fill me-1"></i>User</span>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-3 border-0 shadow-sm mb-3"
             style="background-color: #d2f4ea; color: #0f5132;">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        </div>
    @endif

    <!-- Info Akun -->
    <div class="settings-card">
        <div class="card-title"><i class="bi bi-person-circle me-2" style="color: var(--accent);"></i>Informasi Akun</div>
        <p class="card-subtitle">Detail akun Anda saat ini di LesGo.</p>

        <div class="info-row">
            <div class="info-label"><i class="bi bi-person-fill"></i>Nama Lengkap</div>
            <div class="info-value">{{ $user->name }}</div>
        </div>

        <div class="info-row">
            <div class="info-label"><i class="bi bi-envelope-fill"></i>Email</div>
            <div class="info-value">{{ $user->email }}</div>
        </div>

        <div class="info-row">
            <div class="info-label"><i class="bi bi-telephone-fill"></i>Nomor Telepon</div>
            <div class="info-value">
                {{ $user->phone ?? '—' }}
            </div>
        </div>

        <div class="info-row">
            <div class="info-label"><i class="bi bi-calendar3"></i>Bergabung Sejak</div>
            <div class="info-value">{{ $user->created_at ? $user->created_at->translatedFormat('d F Y') : '—' }}</div>
        </div>
    </div>

    <!-- Aksi Cepat -->
    <div class="settings-card">
        <div class="card-title"><i class="bi bi-sliders me-2" style="color: var(--accent);"></i>Aksi Cepat</div>
        <p class="card-subtitle">Pintasan untuk mengelola akun Anda.</p>

        <div class="d-flex flex-wrap gap-3">
            <a href="{{ route('home') }}" class="btn-secondary-action">
                <i class="bi bi-house-fill me-1"></i> Beranda
            </a>

            <a href="{{ route('bimbel') }}" class="btn-secondary-action">
                <i class="bi bi-search me-1"></i> Cari Bimbel
            </a>

            @if($user->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="btn-action">
                    <i class="bi bi-speedometer2 me-1"></i> Dashboard Admin
                </a>
            @endif

            <a href="{{ route('logout') }}" class="btn-action"
               style="background-color: #dc3545;"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right me-1"></i> Logout
            </a>

            <form action="{{ route('logout') }}" method="POST" id="logout-form" class="d-none">
                @csrf
            </form>
        </div>
    </div>

    <!-- Catatan -->
    <div class="settings-card" style="background: linear-gradient(135deg, #f4fbf9 0%, #ffffff 100%);">
        <div class="d-flex gap-3 align-items-start">
            <i class="bi bi-info-circle-fill" style="color: var(--primary-dark); font-size: 22px;"></i>
            <div>
                <strong style="color: var(--dark);">Catatan:</strong>
                <p class="text-secondary mb-0" style="font-size: 14px;">
                    Fitur edit profil dan ganti kata sandi akan segera tersedia.
                    Sementara ini, akun Anda telah terdaftar dengan aman di LesGo.
                </p>
            </div>
        </div>
    </div>

</div>
@endsection
