@extends('layouts.guest')

@section('title', 'Daftarkan Bimbel')

@section('content')

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
    }

    body {
        background-color: var(--lesgo-bg) !important;
        color: var(--lesgo-dark);
    }

    .register-wrapper {
        min-height: 88vh;
        padding: 60px 20px 80px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .register-card {
        max-width: 620px;
        width: 100%;
        margin: auto;
        background: #ffffff;
        border: 1px solid rgba(147, 225, 216, 0.4);
        border-radius: 28px;
        box-shadow: 0 20px 45px rgba(47, 72, 88, 0.08);
        padding: 42px;
        position: relative;
        overflow: hidden;
    }

    .register-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        background: linear-gradient(90deg, var(--lesgo-pink) 0%, var(--lesgo-blue) 100%);
    }

    .register-title {
        color: var(--lesgo-dark);
        font-weight: 800;
        letter-spacing: -0.5px;
    }

    .form-label-custom {
        color: var(--lesgo-dark);
        font-weight: 600;
        font-size: 0.92rem;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .form-control-custom {
        border: 1.5px solid rgba(147, 225, 216, 0.5);
        border-radius: 14px;
        padding: 13px 18px;
        background: #ffffff;
        font-size: 0.95rem;
        color: var(--lesgo-dark);
        transition: all 0.25s ease;
    }

    .form-control-custom:focus {
        border-color: var(--lesgo-blue-hover);
        box-shadow: 0 0 0 4px rgba(147, 225, 216, 0.25);
        background: #ffffff;
    }

    .package-box {
        background: linear-gradient(135deg, var(--lesgo-blue-bg) 0%, #ffffff 100%);
        border: 1.5px solid var(--lesgo-blue);
        border-radius: 20px;
        padding: 20px 24px;
        box-shadow: 0 4px 15px rgba(147, 225, 216, 0.15);
    }

    .btn-submit-custom {
        background: linear-gradient(135deg, var(--lesgo-pink) 0%, #ff8566 100%);
        color: white;
        border: none;
        border-radius: 16px;
        padding: 15px 24px;
        font-weight: 700;
        font-size: 1.05rem;
        box-shadow: 0 10px 25px rgba(255, 153, 128, 0.35);
        transition: all 0.3s ease;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-submit-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 14px 30px rgba(255, 153, 128, 0.45);
        color: white;
    }
</style>

<div class="register-wrapper">

    <div class="register-card">

        <div class="text-center mb-4">
            <span class="badge rounded-pill px-3 py-1 mb-2 text-white fw-bold" style="font-size: 11px; background-color: var(--lesgo-pink);">
                <i class="bi bi-rocket-takeoff-fill me-1"></i> MITRA LESGO
            </span>
            <h2 class="register-title fs-3 mb-2">
                Daftarkan Bimbel Anda
            </h2>
            <p class="text-muted small mb-0">
                Isi data kontak Anda. Tim LesGo akan segera menghubungi untuk proses aktivasi bimbel.
            </p>
        </div>

        {{-- Paket Pemasaran Bimbel --}}
        <div class="package-box mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small d-block mb-1">Paket Kemitraan Aktif</span>
                    <h5 class="fw-bold mb-1" style="color: var(--lesgo-dark);">Paket Pemasaran Bimbel</h5>
                    <div class="d-flex align-items-baseline gap-1">
                        <span class="fw-bold fs-5" style="color: var(--lesgo-dark);">Rp 10.000</span>
                        <span class="text-muted small">/ bulan</span>
                    </div>
                </div>
                <span class="badge rounded-pill px-3 py-2" style="background: var(--lesgo-pink); color: #fff; font-size: 12px; font-weight: 700;">
                    <i class="bi bi-megaphone-fill me-1"></i> PEMASARAN
                </span>
            </div>
        </div>

        <form action="{{ route('bimbel.daftar.store') }}" method="POST">
            @csrf

            {{-- Paket Hidden --}}
            <input type="hidden" name="paket" value="{{ $paket }}">

            {{-- Nama --}}
            <div class="mb-3">
                <label class="form-label-custom">
                    <i class="bi bi-person-fill text-secondary"></i> Nama Lengkap
                </label>
                <input type="text"
                       name="nama"
                       class="form-control form-control-custom @error('nama') is-invalid @enderror"
                       value="{{ old('nama') }}"
                       placeholder="Masukkan nama pemilik / pengelola bimbel"
                       required>
                @error('nama')
                    <div class="text-danger small mt-1">
                        <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-3">
                <label class="form-label-custom">
                    <i class="bi bi-envelope-fill text-secondary"></i> Alamat Email
                </label>
                <input type="email"
                       name="email"
                       class="form-control form-control-custom @error('email') is-invalid @enderror"
                       value="{{ old('email') }}"
                       placeholder="nama@email.com"
                       required>
                @error('email')
                    <div class="text-danger small mt-1">
                        <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- WhatsApp --}}
            <div class="mb-4">
                <label class="form-label-custom">
                    <i class="bi bi-whatsapp text-success"></i> Nomor WhatsApp Active
                </label>
                <input type="tel"
                       name="no_wa"
                       class="form-control form-control-custom @error('no_wa') is-invalid @enderror"
                       value="{{ old('no_wa') }}"
                       placeholder="Contoh: 081234567890"
                       required>
                @error('no_wa')
                    <div class="text-danger small mt-1">
                        <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" id="btnSubmitDaftarBimbel" class="btn-submit-custom" style="background: linear-gradient(135deg, #25D366 0%, #1da851 100%); box-shadow: 0 10px 25px rgba(37, 211, 102, 0.35);">
                <i class="bi bi-whatsapp fs-4 me-1"></i>
                <span>Kirim Pendaftaran ke WhatsApp</span>
            </button>
        </form>

    </div>

</div>

@endsection
