@extends('layouts.guest')

@section('title', 'Tambah Bimbel Baru - LesGo')

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

    .form-bimbel-card {
        background: var(--lesgo-card-bg);
        border-radius: 20px;
        border: 1px solid var(--lesgo-border);
        box-shadow: 0 8px 24px rgba(47, 72, 88, 0.05);
    }

    .form-label-custom {
        font-size: 13px;
        font-weight: 600;
        color: var(--lesgo-dark);
        margin-bottom: 6px;
    }

    .form-label-custom .required {
        color: var(--lesgo-pink);
    }

    .form-control-bimbel,
    .form-select-bimbel,
    .form-textarea-bimbel {
        border-radius: 12px;
        border: 1.5px solid var(--lesgo-border);
        padding: 10px 14px;
        font-size: 14px;
        color: var(--lesgo-dark);
        background-color: #ffffff;
        transition: all 0.2s ease;
    }
    .form-control-bimbel::placeholder,
    .form-select-bimbel::placeholder,
    .form-textarea-bimbel::placeholder {
        color: var(--lesgo-muted);
        opacity: 0.7;
    }

    .form-control-bimbel:focus,
    .form-select-bimbel:focus,
    .form-textarea-bimbel:focus {
        border-color: var(--lesgo-blue-hover);
        background-color: #ffffff;
        box-shadow: 0 0 0 4px rgba(147, 225, 216, 0.25);
    }

    .form-textarea-bimbel {
        min-height: 120px;
        resize: vertical;
    }

    .input-icon-wrap {
        position: relative;
    }

    .input-icon-wrap > i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--lesgo-muted);
        font-size: 16px;
        pointer-events: none;
    }

    .input-icon-wrap .form-control-bimbel {
        padding-left: 42px;
    }

    .form-text-hint {
        font-size: 12px;
        color: var(--lesgo-muted);
        margin-top: 4px;
    }

    .section-title {
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--lesgo-muted);
        border-left: 3.5px solid var(--lesgo-pink);
        padding-left: 10px;
        margin-bottom: 18px;
    }

    .form-actions {
        display: flex;
        gap: 12px;
        padding-top: 16px;
        border-top: 1px dashed var(--lesgo-border);
        margin-top: 24px;
    }

    .btn-form-primary {
        background-color: var(--lesgo-pink);
        color: #ffffff;
        border: none;
        border-radius: 12px;
        padding: 10px 26px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }

    .btn-form-primary:hover {
        background-color: var(--lesgo-pink-hover);
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 153, 128, 0.3);
    }

    .btn-form-secondary {
        background-color: #ffffff;
        color: var(--lesgo-dark);
        border: 1.5px solid var(--lesgo-blue);
        border-radius: 12px;
        padding: 10px 24px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .btn-form-secondary:hover {
        background-color: var(--lesgo-blue-bg);
        color: var(--lesgo-dark);
    }

    /* ===== Drag & Drop Upload Zone (Solid Colors) ===== */
    .dropzone-zone {
        position: relative;
        border: 2px dashed var(--lesgo-blue);
        border-radius: 16px;
        padding: 24px 16px;
        text-align: center;
        cursor: pointer;
        background-color: var(--lesgo-blue-bg);
        transition: all 0.2s ease;
        overflow: hidden;
        min-height: 140px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .dropzone-zone:hover {
        border-color: var(--lesgo-blue-hover);
        background-color: #ffffff;
        box-shadow: 0 4px 16px rgba(147, 225, 216, 0.2);
    }

    .dropzone-zone.drag-over {
        border-color: var(--lesgo-pink);
        background-color: var(--lesgo-pink-bg);
    }

    .dropzone-placeholder {
        pointer-events: none;
    }

    .dropzone-icon {
        font-size: 38px;
        color: var(--lesgo-pink);
        display: block;
        margin-bottom: 6px;
    }

    .dropzone-text {
        font-size: 14px;
        font-weight: 600;
        color: var(--lesgo-dark);
        margin-bottom: 2px;
    }

    .dropzone-subtext {
        font-size: 12px;
        color: var(--lesgo-muted);
        margin-bottom: 0;
    }

    .dropzone-link {
        color: var(--lesgo-pink);
        font-weight: 600;
        text-decoration: underline;
    }

    .dropzone-preview {
        position: relative;
        width: 100%;
        max-width: 180px;
        margin: 0 auto;
        border-radius: 12px;
        overflow: hidden;
    }

    .dropzone-preview img {
        width: 100%;
        height: 120px;
        object-fit: cover;
        display: block;
        border-radius: 12px;
    }

    .dropzone-preview-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(47, 72, 88, 0.4);
        opacity: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: opacity 0.2s ease;
        border-radius: 12px;
    }

    .dropzone-preview:hover .dropzone-preview-overlay {
        opacity: 1;
    }

    .dropzone-remove-btn,
    .dropzone-change-btn {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        cursor: pointer;
    }

    .dropzone-remove-btn {
        background-color: var(--lesgo-pink);
        color: #ffffff;
    }

    .dropzone-change-btn {
        background-color: #ffffff;
        color: var(--lesgo-dark);
    }

    .dropzone-input {
        display: none;
    }

    /* ===== Mapel Category Picker ===== */
    .mapel-picker-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
        gap: 12px;
        margin-top: 8px;
    }
    .mapel-card-item {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 14px 10px;
        border: 2px solid var(--lesgo-border);
        border-radius: 14px;
        background-color: #ffffff;
        cursor: pointer;
        transition: all 0.2s ease;
        user-select: none;
        text-align: center;
    }
    .mapel-card-item:hover {
        border-color: var(--lesgo-pink);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(47, 72, 88, 0.08);
    }
    .mapel-card-item.active {
        border-color: var(--lesgo-pink);
        background-color: var(--lesgo-pink-bg);
        box-shadow: 0 4px 14px rgba(255, 153, 128, 0.2);
    }
    .mapel-card-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        margin-bottom: 8px;
        transition: transform 0.2s ease;
    }
    .mapel-card-item.active .mapel-card-icon {
        transform: scale(1.1);
    }
    .mapel-card-label {
        font-size: 13px;
        font-weight: 600;
        color: var(--lesgo-dark);
        line-height: 1.2;
    }
    .mapel-card-check {
        position: absolute;
        top: 6px;
        right: 8px;
        color: var(--lesgo-pink);
        font-size: 16px;
        opacity: 0;
        transform: scale(0.5);
        transition: all 0.2s ease;
    }
    .mapel-card-item.active .mapel-card-check {
        opacity: 1;
        transform: scale(1);
    }
    .mapel-checkbox {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
        pointer-events: none;
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="row align-items-center mb-4">
        <div class="col">
            <h1 class="fw-bold h2 mb-1" style="color: var(--lesgo-dark);">
                <i class="bi bi-plus-circle-fill me-2" style="color: var(--lesgo-pink);"></i>
                Tambah Bimbel Baru
            </h1>
            <p class="text-muted mb-0">Daftarkan lembaga bimbingan belajar baru Anda ke platform LesGo.</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('bimbeluser.index') }}" class="btn btn-light rounded-pill px-3 shadow-sm border">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Alert error jika ada -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert" style="background-color: var(--lesgo-pink-bg); color: var(--lesgo-dark); border: 1px solid var(--lesgo-pink) !important;">
            <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill text-danger me-2"></i>Terdapat kesalahan pengisian form:</div>
            <ul class="mb-0 ps-3 small">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Form -->
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="form-bimbel-card p-4 p-md-5">
                <form action="{{ route('bimbeluser.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Token Input Banner (Solid Colors) -->
                    <div class="p-4 rounded-4 mb-4" style="background-color: var(--lesgo-pink-bg); border: 1.5px solid var(--lesgo-pink);">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="badge text-white px-2 py-1 rounded-pill fw-bold" style="font-size: 11px; background-color: var(--lesgo-pink);">VERIFIKASI TOKEN</span>
                            <h6 class="fw-bold mb-0" style="color: var(--lesgo-dark);">Token Pembayaran Member</h6>
                        </div>
                        <p class="text-muted small mb-3">
                            Masukkan token unik yang Anda dapatkan dari Admin via WhatsApp setelah melakukan pembayaran paket member.
                        </p>
                        <div>
                            <label for="token" class="form-label-custom">Token Pembuatan Bimbel <span class="required">*</span></label>
                            <div class="input-icon-wrap">
                                <i class="bi bi-key-fill text-warning"></i>
                                <input type="text"
                                       id="token"
                                       name="token"
                                       class="form-control form-control-bimbel text-uppercase fw-bold @error('token') is-invalid @enderror"
                                       placeholder="Cth: LESGO-A1B2C3D4"
                                       value="{{ old('token', request('token')) }}"
                                       style="letter-spacing: 1.5px; font-size: 15px; background-color: #ffffff;"
                                       required>
                            </div>
                            @error('token')
                                <div class="text-danger small mt-2 fw-semibold"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="section-title">Informasi Bimbel</div>

                    <div class="row g-3">
                        <!-- Nama -->
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="nama" class="form-label-custom">Nama Bimbel <span class="required">*</span></label>
                                <div class="input-icon-wrap">
                                    <i class="bi bi-mortarboard-fill"></i>
                                    <input type="text"
                                           id="nama"
                                           name="nama"
                                           class="form-control form-control-bimbel @error('nama') is-invalid @enderror"
                                           placeholder="Cth: Ruang Belajar Pintar"
                                           value="{{ old('nama') }}"
                                           required>
                                </div>
                                @error('nama')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Mapel Categories -->
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label-custom">Kategori Mata Pelajaran <span class="required">*</span></label>
                                <p class="form-text-hint mt-0 mb-2">Klik tombol di bawah untuk memilih mata pelajaran yang disediakan di tempat bimbel Anda:</p>
                                
                                <div class="p-3 border rounded-4 bg-white d-flex flex-wrap align-items-center justify-content-between gap-3 shadow-sm" style="border-color: var(--lesgo-border) !important;">
                                    <div id="selected-mapels-container" class="d-flex flex-wrap gap-2 align-items-center" style="min-height: 38px;">
                                        <span class="text-muted small fst-italic" id="empty-mapel-text"><i class="bi bi-info-circle me-1"></i>Belum ada mata pelajaran dipilih</span>
                                    </div>
                                    <button type="button" class="btn btn-outline-primary rounded-pill px-3 py-2 fw-semibold btn-sm shadow-sm" data-bs-toggle="modal" data-bs-target="#mapelModal" style="border-color: var(--lesgo-pink); color: var(--lesgo-pink);">
                                        <i class="bi bi-grid-plus me-1"></i> Pilih Mata Pelajaran (<span id="selected-count">0</span>)
                                    </button>
                                </div>

                                @error('mapel_ids')
                                    <div class="text-danger small mt-2 fw-semibold"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Modal Pilih Mapel -->
                    <div class="modal fade" id="mapelModal" tabindex="-1" aria-labelledby="mapelModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                            <div class="modal-content rounded-4 border-0 shadow-lg">
                                <div class="modal-header border-bottom px-4 py-3 bg-light rounded-top-4">
                                    <div>
                                        <h5 class="modal-title fw-bold text-dark" id="mapelModalLabel">
                                            <i class="bi bi-book-half me-2" style="color: var(--lesgo-pink);"></i>Pilih Kategori Mata Pelajaran
                                        </h5>
                                        <p class="text-muted small mb-0">Pilih satu atau lebih mata pelajaran yang diajarkan.</p>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <!-- Search filter -->
                                    <div class="mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0 rounded-start-3"><i class="bi bi-search text-muted"></i></span>
                                            <input type="text" id="searchMapelInput" class="form-control border-start-0 rounded-end-3" placeholder="Cari mata pelajaran (cth: Matematika, Fisika...)" style="box-shadow: none;">
                                        </div>
                                    </div>

                                    <!-- Grid Mapel Cards -->
                                    <div class="mapel-picker-grid" id="mapelGrid">
                                        @foreach($mapels as $m)
                                            @php
                                                $isSelected = is_array(old('mapel_ids')) && in_array($m->id, old('mapel_ids'));
                                            @endphp
                                            <label class="mapel-card-item {{ $isSelected ? 'active' : '' }}" data-nama="{{ strtolower($m->nama) }}">
                                                <input type="checkbox"
                                                       name="mapel_ids[]"
                                                       value="{{ $m->id }}"
                                                       data-nama="{{ $m->nama }}"
                                                       data-icon="{{ $m->icon ?: 'bi-book' }}"
                                                       data-warna="{{ $m->warna ?: '#2F4858' }}"
                                                       class="mapel-checkbox"
                                                       {{ $isSelected ? 'checked' : '' }}>
                                                <div class="mapel-card-icon" style="background-color: {{ $m->warna ? $m->warna.'20' : 'rgba(147, 225, 216, 0.2)' }}; color: {{ $m->warna ?: 'var(--lesgo-dark)' }};">
                                                    <i class="bi {{ $m->icon ?: 'bi-book' }}"></i>
                                                </div>
                                                <span class="mapel-card-label">{{ $m->nama }}</span>
                                                <div class="mapel-card-check">
                                                    <i class="bi bi-check-circle-fill"></i>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="modal-footer border-top px-4 py-3 bg-light rounded-bottom-4 d-flex justify-content-between align-items-center">
                                    <span class="small text-muted fw-semibold"><span id="modal-selected-count" class="badge rounded-pill px-2 py-1 text-white" style="background-color: var(--lesgo-pink);">0</span> mata pelajaran dipilih</span>
                                    <button type="button" class="btn text-white rounded-pill px-4 fw-semibold shadow-sm" data-bs-dismiss="modal" style="background-color: var(--lesgo-pink);">
                                        <i class="bi bi-check-lg me-1"></i> Simpan Pilihan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3">
                        <!-- Jenjang -->
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="jenjang" class="form-label-custom">Jenjang <span class="required">*</span></label>
                                <select id="jenjang"
                                        name="jenjang"
                                        class="form-select form-select-bimbel @error('jenjang') is-invalid @enderror"
                                        required>
                                    <option value="">-- Pilih Jenjang --</option>
                                    @php
                                        $jenjangs = ['SD', 'SMP', 'SMA', 'Mahasiswa', 'Umum'];
                                    @endphp
                                    @foreach($jenjangs as $j)
                                        <option value="{{ $j }}" {{ old('jenjang') === $j ? 'selected' : '' }}>{{ $j }}</option>
                                    @endforeach
                                </select>
                                @error('jenjang')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Kota -->
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="kota" class="form-label-custom">Kota <span class="required">*</span></label>
                                <div class="input-icon-wrap">
                                    <i class="bi bi-geo-alt-fill"></i>
                                    <input type="text"
                                           id="kota"
                                           name="kota"
                                           class="form-control form-control-bimbel @error('kota') is-invalid @enderror"
                                           placeholder="Cth: Jakarta"
                                           value="{{ old('kota') }}"
                                           required>
                                </div>
                                @error('kota')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="status" class="form-label-custom">Status <span class="required">*</span></label>
                                <select id="status"
                                        name="status"
                                        class="form-select form-select-bimbel @error('status') is-invalid @enderror"
                                        required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="Aktif" {{ old('status', 'Aktif') === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="Nonaktif" {{ old('status') === 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                </select>
                                @error('status')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div class="mb-3">
                        <label for="alamat" class="form-label-custom">Alamat Lengkap <span class="required">*</span></label>
                        <textarea id="alamat"
                                  name="alamat"
                                  class="form-control form-textarea-bimbel @error('alamat') is-invalid @enderror"
                                  placeholder="Jl. Contoh No. 123, Kelurahan, Kecamatan, Kota..."
                                  required>{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="section-title mt-4">Kontak & Media</div>

                    <div class="row g-3">
                        <!-- Telepon -->
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="telepon" class="form-label-custom">Telepon</label>
                                <div class="input-icon-wrap">
                                    <i class="bi bi-telephone-fill"></i>
                                    <input type="text"
                                           id="telepon"
                                           name="telepon"
                                           class="form-control form-control-bimbel @error('telepon') is-invalid @enderror"
                                           placeholder="08123456789"
                                           value="{{ old('telepon') }}">
                                </div>
                                @error('telepon')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="email" class="form-label-custom">Email</label>
                                <div class="input-icon-wrap">
                                    <i class="bi bi-envelope-fill"></i>
                                    <input type="email"
                                           id="email"
                                           name="email"
                                           class="form-control form-control-bimbel @error('email') is-invalid @enderror"
                                           placeholder="bimbel@email.com"
                                           value="{{ old('email') }}">
                                </div>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Website -->
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="website" class="form-label-custom">Website</label>
                                <div class="input-icon-wrap">
                                    <i class="bi bi-globe2"></i>
                                    <input type="url"
                                           id="website"
                                           name="website"
                                           class="form-control form-control-bimbel @error('website') is-invalid @enderror"
                                           placeholder="https://bimbel.example.com"
                                           value="{{ old('website') }}">
                                </div>
                                @error('website')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="section-title mt-4">Detail Tambahan</div>

                    <div class="row g-3">
                        <!-- Harga Mulai -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="harga_mulai" class="form-label-custom">Harga Mulai (Rp)</label>
                                <div class="input-icon-wrap">
                                    <i class="bi bi-cash-stack"></i>
                                    <input type="number"
                                           id="harga_mulai"
                                           name="harga_mulai"
                                           class="form-control form-control-bimbel @error('harga_mulai') is-invalid @enderror"
                                           placeholder="500000"
                                           value="{{ old('harga_mulai') }}"
                                           min="0">
                                </div>
                                <div class="form-text-hint">Harga terendah per bulan/program.</div>
                                @error('harga_mulai')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Jam Operasional -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="jam_operasional" class="form-label-custom">Jam Operasional</label>
                                <div class="input-icon-wrap">
                                    <i class="bi bi-clock-fill"></i>
                                    <input type="text"
                                           id="jam_operasional"
                                           name="jam_operasional"
                                           class="form-control form-control-bimbel @error('jam_operasional') is-invalid @enderror"
                                           placeholder="Sen–Jum 08:00–18:00"
                                           value="{{ old('jam_operasional') }}">
                                </div>
                                <div class="form-text-hint">Contoh: Sen–Jum 08:00–18:00.</div>
                                @error('jam_operasional')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label-custom">Deskripsi Bimbel <span class="required">*</span></label>
                        <textarea id="deskripsi"
                                  name="deskripsi"
                                  class="form-control form-textarea-bimbel @error('deskripsi') is-invalid @enderror"
                                  placeholder="Jelaskan tentang bimbel ini, program yang ditawarkan, keunggulan, dll..."
                                  style="min-height: 140px;"
                                  required>{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- File Uploads -->
                    <div class="section-title mt-4">Upload Gambar (Opsional)</div>

                    <div class="row g-3">
                        <!-- Logo -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label-custom">Logo Bimbel</label>
                                <div class="dropzone-zone" id="logo-dropzone">
                                    <div class="dropzone-placeholder" id="logoPlaceholder">
                                        <i class="bi bi-image-fill dropzone-icon"></i>
                                        <p class="dropzone-text">Upload Logo</p>
                                        <p class="dropzone-subtext">Pilih atau <span class="dropzone-link">tarik file</span></p>
                                    </div>
                                    <div class="dropzone-preview d-none" id="logoPreview">
                                        <img id="logoPreviewImg" alt="Preview logo">
                                        <div class="dropzone-preview-overlay">
                                            <button type="button" class="dropzone-remove-btn" data-remove="logo" title="Hapus"><i class="bi bi-x-lg"></i></button>
                                            <button type="button" class="dropzone-change-btn" data-change="logo" title="Ganti"><i class="bi bi-pencil-fill"></i></button>
                                        </div>
                                    </div>
                                    <input type="file"
                                           id="logo"
                                           name="logo"
                                           accept="image/*"
                                           class="dropzone-input @error('logo') is-invalid @enderror">
                                </div>
                                <div class="form-text-hint">Format: JPG, PNG, WebP. Maks 2 MB.</div>
                                @error('logo')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Cover -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label-custom">Cover / Foto Bimbel</label>
                                <div class="dropzone-zone" id="cover-dropzone">
                                    <div class="dropzone-placeholder" id="coverPlaceholder">
                                        <i class="bi bi-images dropzone-icon"></i>
                                        <p class="dropzone-text">Upload Cover</p>
                                        <p class="dropzone-subtext">Pilih atau <span class="dropzone-link">tarik file</span></p>
                                    </div>
                                    <div class="dropzone-preview d-none" id="coverPreview">
                                        <img id="coverPreviewImg" alt="Preview cover">
                                        <div class="dropzone-preview-overlay">
                                            <button type="button" class="dropzone-remove-btn" data-remove="cover" title="Hapus"><i class="bi bi-x-lg"></i></button>
                                            <button type="button" class="dropzone-change-btn" data-change="cover" title="Ganti"><i class="bi bi-pencil-fill"></i></button>
                                        </div>
                                    </div>
                                    <input type="file"
                                           id="cover"
                                           name="cover"
                                           accept="image/*"
                                           class="dropzone-input @error('cover') is-invalid @enderror">
                                </div>
                                <div class="form-text-hint">Format: JPG, PNG, WebP. Maks 2 MB.</div>
                                @error('cover')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="form-actions">
                        <button type="submit" class="btn-form-primary">
                            <i class="bi bi-check2-circle me-1"></i> Simpan Bimbel
                        </button>
                        <a href="{{ route('bimbeluser.index') }}" class="btn-form-secondary">
                            <i class="bi bi-x-lg me-1"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tips Panel -->
        <div class="col-lg-4">
            <div class="form-bimbel-card p-4" style="background-color: #ffffff; border: 1px solid var(--lesgo-border);">
                <h6 class="fw-bold mb-3" style="color: var(--lesgo-dark);">
                    <i class="bi bi-info-circle-fill me-2" style="color: var(--lesgo-pink);"></i> Tips Pengisian
                </h6>
                <ul class="text-secondary small mb-0" style="padding-left: 18px; line-height: 1.6;">
                    <li class="mb-2">Gunakan <strong>Token Pembuatan Bimbel</strong> yang aktif & valid dari Admin.</li>
                    <li class="mb-2">Gunakan nama bimbel yang jelas dan mudah dikenali calon siswa.</li>
                    <li class="mb-2">Isi deskripsi selengkap mungkin mengenai fasilitas & keunggulan.</li>
                    <li class="mb-2">Upload logo dan cover untuk tampilan yang profesional.</li>
                    <li class="mb-2">Bimbel dengan status <strong>Aktif</strong> akan langsung tayang di katalog publik.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        initDropzone('logo');
        initDropzone('cover');
    });

    function initDropzone(name) {
        const dropzone = document.getElementById(name + '-dropzone');
        const fileInput = document.getElementById(name);
        const placeholder = document.getElementById(name + 'Placeholder');
        const previewContainer = document.getElementById(name + 'Preview');
        const previewImg = document.getElementById(name + 'PreviewImg');
        const removeBtn = previewContainer.querySelector('[data-remove="' + name + '"]');
        const changeBtn = previewContainer.querySelector('[data-change="' + name + '"]');

        let dragCounter = 0;

        dropzone.addEventListener('click', function (e) {
            if (e.target.closest('.dropzone-remove-btn') || e.target.closest('.dropzone-change-btn')) {
                return;
            }
            fileInput.click();
        });

        fileInput.addEventListener('change', function () {
            if (fileInput.files && fileInput.files[0]) {
                handleFile(fileInput.files[0]);
            }
        });

        dropzone.addEventListener('dragenter', function (e) {
            e.preventDefault();
            dragCounter++;
            if (dragCounter === 1) dropzone.classList.add('drag-over');
        });

        dropzone.addEventListener('dragover', function (e) {
            e.preventDefault();
        });

        dropzone.addEventListener('dragleave', function (e) {
            e.preventDefault();
            dragCounter--;
            if (dragCounter === 0) dropzone.classList.remove('drag-over');
        });

        dropzone.addEventListener('drop', function (e) {
            e.preventDefault();
            dragCounter = 0;
            dropzone.classList.remove('drag-over');
            const files = e.dataTransfer.files;
            if (files && files[0]) {
                handleFile(files[0]);
            }
        });

        removeBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            clearFile();
        });

        changeBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            fileInput.click();
        });

        function handleFile(file) {
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file maksimal 2 MB.');
                fileInput.value = '';
                return;
            }
            const reader = new FileReader();
            reader.onload = function (e) {
                previewImg.src = e.target.result;
                placeholder.style.display = 'none';
                previewContainer.classList.remove('d-none');
                previewContainer.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }

        function clearFile() {
            fileInput.value = '';
            previewImg.src = '';
            previewContainer.classList.add('d-none');
            previewContainer.style.display = 'none';
            placeholder.style.display = 'block';
        }
    }

    // ===== Mapel Modal Picker JS =====
    document.addEventListener('DOMContentLoaded', function () {
        const checkboxes = document.querySelectorAll('.mapel-checkbox');
        const container = document.getElementById('selected-mapels-container');
        const emptyText = document.getElementById('empty-mapel-text');
        const selectedCount = document.getElementById('selected-count');
        const modalSelectedCount = document.getElementById('modal-selected-count');
        const searchInput = document.getElementById('searchMapelInput');

        function updateSelectedDisplay() {
            let count = 0;
            // Clear existing preview badges
            if (container) {
                container.querySelectorAll('.mapel-badge-preview').forEach(el => el.remove());
            }

            checkboxes.forEach(cb => {
                const card = cb.closest('.mapel-card-item');
                if (cb.checked) {
                    count++;
                    if (card) card.classList.add('active');

                    const nama = cb.dataset.nama || '';
                    const icon = cb.dataset.icon || 'bi-book';
                    const warna = cb.dataset.warna || '#2F4858';

                    if (container) {
                        const badge = document.createElement('span');
                        badge.className = 'mapel-badge-preview badge rounded-pill px-3 py-2 d-inline-flex align-items-center gap-1 shadow-sm';
                        badge.style.backgroundColor = warna + '18';
                        badge.style.color = warna;
                        badge.style.border = '1px solid ' + warna + '40';
                        badge.innerHTML = `<i class="bi ${icon}"></i> <span>${nama}</span>`;
                        container.appendChild(badge);
                    }
                } else {
                    if (card) card.classList.remove('active');
                }
            });

            if (emptyText) {
                emptyText.style.display = count > 0 ? 'none' : 'inline-block';
            }

            if (selectedCount) selectedCount.textContent = count;
            if (modalSelectedCount) modalSelectedCount.textContent = count;
        }

        // Attach change listener to checkboxes
        checkboxes.forEach(cb => {
            cb.addEventListener('change', updateSelectedDisplay);
        });

        // Search filter inside modal
        if (searchInput) {
            searchInput.addEventListener('input', function () {
                const query = this.value.toLowerCase().trim();
                document.querySelectorAll('#mapelGrid .mapel-card-item').forEach(card => {
                    const nama = card.dataset.nama || '';
                    if (nama.includes(query)) {
                        card.style.display = 'flex';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        }

        // Initial render
        updateSelectedDisplay();
    });
</script>
@endpush
