@extends('layouts.admin')

@section('title', 'Edit Bimbel - LesGo Admin')

@push('style')
<style>
    .form-bimbel-card {
        background: var(--white);
        border-radius: 20px;
        border: 1px solid rgba(147, 225, 216, 0.18);
        box-shadow: 0 8px 22px -12px rgba(47, 72, 88, 0.08);
    }

    .form-label-custom {
        font-size: 13px;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 6px;
    }

    .form-label-custom .required {
        color: var(--accent);
    }

    .form-control-bimbel,
    .form-select-bimbel,
    .form-textarea-bimbel {
        border-radius: 12px;
        border: 1.5px solid rgba(147, 225, 216, 0.25);
        padding: 10px 14px;
        font-size: 14px;
        color: var(--dark);
        background-color: #f9fdfc;
        transition: all 0.2s ease;
    }

    .form-control-bimbel:focus,
    .form-select-bimbel:focus,
    .form-textarea-bimbel:focus {
        border-color: #66c7bc;
        background-color: #ffffff;
        box-shadow: 0 0 0 4px rgba(147, 225, 216, 0.22);
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
        color: #8b9fae;
        font-size: 16px;
        pointer-events: none;
    }

    .input-icon-wrap .form-control-bimbel {
        padding-left: 42px;
    }

    .form-text-hint {
        font-size: 12px;
        color: var(--dark-muted);
        margin-top: 4px;
    }

    .section-title {
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--dark-muted);
        border-left: 3px solid var(--accent);
        padding-left: 10px;
        margin-bottom: 18px;
    }

    .form-actions {
        display: flex;
        gap: 10px;
        padding-top: 16px;
        border-top: 1px dashed rgba(147, 225, 216, 0.25);
        margin-top: 24px;
    }

    .btn-form-primary {
        background-color: var(--accent);
        color: #ffffff;
        border: none;
        border-radius: 12px;
        padding: 10px 26px;
        font-weight: 600;
        font-size: 14px;
        transition: var(--transition);
    }

    .btn-form-primary:hover {
        background-color: #ff8f85;
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(255, 166, 158, 0.32);
    }

    .btn-form-secondary {
        background-color: transparent;
        color: var(--dark);
        border: 1.5px solid rgba(147, 225, 216, 0.35);
        border-radius: 12px;
        padding: 10px 24px;
        font-weight: 600;
        font-size: 14px;
        transition: var(--transition);
        text-decoration: none;
    }

    .btn-form-secondary:hover {
        background-color: rgba(147, 225, 216, 0.18);
        color: var(--dark);
    }

    /* ===== Drag & Drop Upload Zone ===== */
    .dropzone-zone {
        position: relative;
        border: 2px dashed rgba(147, 225, 216, 0.4);
        border-radius: 16px;
        padding: 28px 16px;
        text-align: center;
        cursor: pointer;
        background: linear-gradient(135deg, #f9fdfc 0%, #f0f9f7 100%);
        transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        overflow: hidden;
        min-height: 140px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .dropzone-zone:hover {
        border-color: var(--accent);
        background: linear-gradient(135deg, #f4fbf9 0%, #e8f6f3 100%);
        box-shadow: 0 4px 20px rgba(147, 225, 216, 0.15);
        transform: translateY(-1px);
    }

    .dropzone-zone.drag-over {
        border-color: var(--accent);
        border-style: solid;
        background: linear-gradient(135deg, #e6f7f4 0%, #d4f0eb 100%);
        box-shadow: 0 0 0 5px rgba(147, 225, 216, 0.2), 0 6px 24px rgba(147, 225, 216, 0.2);
        transform: scale(1.01);
    }

    .dropzone-zone.has-file {
        padding: 6px;
        border-style: solid;
        border-color: rgba(147, 225, 216, 0.5);
        background: #ffffff;
        cursor: default;
    }

    .dropzone-placeholder {
        pointer-events: none;
    }

    .dropzone-icon {
        font-size: 42px;
        color: var(--accent);
        display: block;
        margin-bottom: 8px;
        transition: transform 0.3s ease;
    }

    .dropzone-text {
        font-size: 14px;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 2px;
    }

    .dropzone-subtext {
        font-size: 12px;
        color: var(--dark-muted);
        margin-bottom: 0;
    }

    .dropzone-link {
        color: var(--accent);
        font-weight: 600;
        text-decoration: underline;
        text-underline-offset: 2px;
        text-decoration-style: dotted;
    }

    .dropzone-preview {
        position: relative;
        width: 100%;
        max-width: 180px;
        margin: 0 auto;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
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
        background: rgba(0, 0, 0, 0.35);
        opacity: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        transition: opacity 0.25s ease;
        border-radius: 12px;
    }

    .dropzone-preview:hover .dropzone-preview-overlay {
        opacity: 1;
    }

    .dropzone-remove-btn,
    .dropzone-change-btn {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s ease;
        backdrop-filter: blur(4px);
    }

    .dropzone-remove-btn {
        background: rgba(220, 53, 69, 0.85);
        color: #fff;
    }

    .dropzone-remove-btn:hover {
        background: #dc3545;
        transform: scale(1.1);
    }

    .dropzone-change-btn {
        background: rgba(255, 255, 255, 0.85);
        color: var(--dark);
    }

    .dropzone-change-btn:hover {
        background: #ffffff;
        transform: scale(1.1);
    }

    .dropzone-input {
        display: none;
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-4px); }
        20%, 40%, 60%, 80% { transform: translateX(4px); }
    }

    .dropzone-zone.shake {
        animation: shake 0.5s ease-in-out;
        border-color: #dc3545;
        border-style: solid;
    }

    .existing-file-info {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 14px;
        background: #f4fbf9;
        border-radius: 10px;
        border: 1px solid rgba(147, 225, 216, 0.2);
        margin-top: 8px;
    }

    .existing-file-info i {
        font-size: 20px;
        color: #55a096;
    }

    .existing-file-info .file-name {
        font-size: 13px;
        font-weight: 500;
        color: var(--dark);
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
        border: 2px solid rgba(147, 225, 216, 0.35);
        border-radius: 14px;
        background-color: #ffffff;
        cursor: pointer;
        transition: all 0.2s ease;
        user-select: none;
        text-align: center;
    }
    .mapel-card-item:hover {
        border-color: var(--accent);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(47, 72, 88, 0.08);
    }
    .mapel-card-item.active {
        border-color: var(--accent);
        background-color: #fff0ee;
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
        color: var(--dark);
        line-height: 1.2;
    }
    .mapel-card-check {
        position: absolute;
        top: 6px;
        right: 8px;
        color: var(--accent);
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
<!-- Header -->
<div class="row align-items-center mb-4">
    <div class="col">
        <h1 class="fw-bold h2 mb-1" style="color: var(--dark);">
            <i class="bi bi-pencil-square me-2" style="color: var(--accent);"></i>
            Edit Bimbel
        </h1>
        <p class="text-muted mb-0">Ubah data untuk <strong>{{ $bimbel->nama }}</strong>.</p>
    </div>
    <div class="col-auto">
        <a href="{{ route('admin.bimbel.index') }}" class="btn btn-light rounded-pill px-3 shadow-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<!-- Form -->
<div class="row">
    <div class="col-lg-8">
        <div class="form-bimbel-card p-4 p-md-5">
            <form action="{{ route('admin.bimbel.update', $bimbel) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

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
                                       value="{{ old('nama', $bimbel->nama) }}"
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
                            <p class="form-text-hint mt-0 mb-2">Klik tombol di bawah untuk memilih mata pelajaran yang disediakan di tempat bimbel ini:</p>
                            
                            <div class="p-3 border rounded-4 bg-white d-flex flex-wrap align-items-center justify-content-between gap-3 shadow-sm" style="border-color: rgba(147, 225, 216, 0.35) !important;">
                                <div id="selected-mapels-container" class="d-flex flex-wrap gap-2 align-items-center" style="min-height: 38px;">
                                    <span class="text-muted small fst-italic" id="empty-mapel-text"><i class="bi bi-info-circle me-1"></i>Belum ada mata pelajaran dipilih</span>
                                </div>
                                <button type="button" class="btn btn-outline-primary rounded-pill px-3 py-2 fw-semibold btn-sm shadow-sm" data-bs-toggle="modal" data-bs-target="#mapelModal">
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
                                        <i class="bi bi-book-half me-2" style="color: var(--accent);"></i>Pilih Kategori Mata Pelajaran
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
                                            $isSelected = is_array(old('mapel_ids', $selectedMapelIds ?? [])) && in_array($m->id, old('mapel_ids', $selectedMapelIds ?? []));
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
                                            <div class="mapel-card-icon" style="background-color: {{ $m->warna ? $m->warna.'20' : 'rgba(147, 225, 216, 0.2)' }}; color: {{ $m->warna ?: 'var(--dark)' }};">
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
                                <span class="small text-muted fw-semibold"><span id="modal-selected-count" class="badge rounded-pill px-2 py-1 text-white bg-primary">0</span> mata pelajaran dipilih</span>
                                <button type="button" class="btn btn-primary rounded-pill px-4 fw-semibold shadow-sm" data-bs-dismiss="modal">
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
                                @php $jenjangs = ['SD', 'SMP', 'SMA', 'Mahasiswa', 'Umum']; @endphp
                                @foreach($jenjangs as $j)
                                    <option value="{{ $j }}" {{ old('jenjang', $bimbel->jenjang) === $j ? 'selected' : '' }}>{{ $j }}</option>
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
                                       value="{{ old('kota', $bimbel->kota) }}"
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
                                <option value="Aktif" {{ old('status', $bimbel->status) === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Nonaktif" {{ old('status', $bimbel->status) === 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            @error('status')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Alamat -->
                <div class="mb-3">
                    <label for="alamat" class="form-label-custom">Alamat <span class="required">*</span></label>
                    <textarea id="alamat"
                              name="alamat"
                              class="form-control form-textarea-bimbel @error('alamat') is-invalid @enderror"
                              required>{{ old('alamat', $bimbel->alamat) }}</textarea>
                    @error('alamat')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="section-title mt-4">Kontak & Media</div>

                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="telepon" class="form-label-custom">Telepon</label>
                            <div class="input-icon-wrap">
                                <i class="bi bi-telephone-fill"></i>
                                <input type="text"
                                       id="telepon"
                                       name="telepon"
                                       class="form-control form-control-bimbel @error('telepon') is-invalid @enderror"
                                       value="{{ old('telepon', $bimbel->telepon) }}">
                            </div>
                            @error('telepon')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="email" class="form-label-custom">Email</label>
                            <div class="input-icon-wrap">
                                <i class="bi bi-envelope-fill"></i>
                                <input type="email"
                                       id="email"
                                       name="email"
                                       class="form-control form-control-bimbel @error('email') is-invalid @enderror"
                                       value="{{ old('email', $bimbel->email) }}">
                            </div>
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="website" class="form-label-custom">Website</label>
                            <div class="input-icon-wrap">
                                <i class="bi bi-globe2"></i>
                                <input type="url"
                                       id="website"
                                       name="website"
                                       class="form-control form-control-bimbel @error('website') is-invalid @enderror"
                                       value="{{ old('website', $bimbel->website) }}">
                            </div>
                            @error('website')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="section-title mt-4">Detail Tambahan</div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="harga_mulai" class="form-label-custom">Harga Mulai (Rp)</label>
                            <div class="input-icon-wrap">
                                <i class="bi bi-cash-stack"></i>
                                <input type="number"
                                       id="harga_mulai"
                                       name="harga_mulai"
                                       class="form-control form-control-bimbel @error('harga_mulai') is-invalid @enderror"
                                       value="{{ old('harga_mulai', $bimbel->harga_mulai) }}"
                                       min="0">
                            </div>
                            <div class="form-text-hint">Harga terendah per bulan/program.</div>
                            @error('harga_mulai')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="jam_operasional" class="form-label-custom">Jam Operasional</label>
                            <div class="input-icon-wrap">
                                <i class="bi bi-clock-fill"></i>
                                <input type="text"
                                       id="jam_operasional"
                                       name="jam_operasional"
                                       class="form-control form-control-bimbel @error('jam_operasional') is-invalid @enderror"
                                       value="{{ old('jam_operasional', $bimbel->jam_operasional) }}">
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
                    <label for="deskripsi" class="form-label-custom">Deskripsi <span class="required">*</span></label>
                    <textarea id="deskripsi"
                              name="deskripsi"
                              class="form-control form-textarea-bimbel @error('deskripsi') is-invalid @enderror"
                              style="min-height: 160px;"
                              required>{{ old('deskripsi', $bimbel->deskripsi) }}</textarea>
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
                                <div class="dropzone-placeholder {{ $bimbel->logo ? 'd-none' : '' }}" id="logoPlaceholder">
                                    <i class="bi bi-image-fill dropzone-icon"></i>
                                    <p class="dropzone-text">Upload Logo</p>
                                    <p class="dropzone-subtext">Tarik & lepas atau <span class="dropzone-link">pilih file</span></p>
                                </div>
                                <div class="dropzone-preview {{ $bimbel->logo ? '' : 'd-none' }}" id="logoPreview">
                                    <img id="logoPreviewImg" src="{{ $bimbel->logo ? Storage::url($bimbel->logo) : '' }}" alt="Preview logo">
                                    <div class="dropzone-preview-overlay">
                                        <button type="button" class="dropzone-remove-btn" data-remove="logo" title="Hapus logo"><i class="bi bi-x-lg"></i></button>
                                        <button type="button" class="dropzone-change-btn" data-change="logo" title="Ganti logo"><i class="bi bi-pencil-fill"></i></button>
                                    </div>
                                </div>
                                <input type="file"
                                       id="logo"
                                       name="logo"
                                       accept="image/*"
                                       class="dropzone-input @error('logo') is-invalid @enderror">
                            </div>
                            @if($bimbel->logo)
                                <div class="existing-file-info">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <div>
                                        <div class="file-name">Logo tersimpan</div>
                                        <div class="file-status">Upload ulang untuk mengganti</div>
                                    </div>
                                </div>
                            @endif
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
                                <div class="dropzone-placeholder {{ $bimbel->cover ? 'd-none' : '' }}" id="coverPlaceholder">
                                    <i class="bi bi-images dropzone-icon"></i>
                                    <p class="dropzone-text">Upload Cover</p>
                                    <p class="dropzone-subtext">Tarik & lepas atau <span class="dropzone-link">pilih file</span></p>
                                </div>
                                <div class="dropzone-preview {{ $bimbel->cover ? '' : 'd-none' }}" id="coverPreview">
                                    <img id="coverPreviewImg" src="{{ $bimbel->cover ? Storage::url($bimbel->cover) : '' }}" alt="Preview cover">
                                    <div class="dropzone-preview-overlay">
                                        <button type="button" class="dropzone-remove-btn" data-remove="cover" title="Hapus cover"><i class="bi bi-x-lg"></i></button>
                                        <button type="button" class="dropzone-change-btn" data-change="cover" title="Ganti cover"><i class="bi bi-pencil-fill"></i></button>
                                    </div>
                                </div>
                                <input type="file"
                                       id="cover"
                                       name="cover"
                                       accept="image/*"
                                       class="dropzone-input @error('cover') is-invalid @enderror">
                            </div>
                            @if($bimbel->cover)
                                <div class="existing-file-info">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <div>
                                        <div class="file-name">Cover tersimpan</div>
                                        <div class="file-status">Upload ulang untuk mengganti</div>
                                    </div>
                                </div>
                            @endif
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
                        <i class="bi bi-check2-circle me-1"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.bimbel.index') }}" class="btn-form-secondary">
                        <i class="bi bi-x-lg me-1"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Ringkasan Panel -->
    <div class="col-lg-4">
        <div class="form-bimbel-card p-4 mb-3">
            <h6 class="fw-bold mb-3" style="color: var(--dark);">
                <i class="bi bi-mortarboard-fill me-2" style="color: var(--accent);"></i> Ringkasan
            </h6>
            <div class="d-flex justify-content-between text-secondary small mb-2">
                <span>Dibuat</span>
                <strong>{{ $bimbel->created_at ? $bimbel->created_at->translatedFormat('d F Y') : '—' }}</strong>
            </div>
            <div class="d-flex justify-content-between text-secondary small mb-2">
                <span>Terakhir diubah</span>
                <strong>{{ $bimbel->updated_at ? $bimbel->updated_at->translatedFormat('d F Y H:i') : '—' }}</strong>
            </div>
        </div>

        <div class="form-bimbel-card p-4" style="background: linear-gradient(135deg, #f4fbf9 0%, #ffffff 100%);">
            <h6 class="fw-bold mb-3" style="color: var(--dark);">
                <i class="bi bi-info-circle-fill me-2" style="color: var(--accent);"></i> Tips
            </h6>
            <ul class="text-secondary small mb-0" style="padding-left: 18px;">
                <li class="mb-2">Pastikan nama bimbel sudah benar sebelum menyimpan.</li>
                <li class="mb-2">Upload logo & cover baru hanya jika ingin mengganti.</li>
                <li class="mb-2">Bimbel nonaktif tidak akan tampil di halaman publik.</li>
            </ul>
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
            e.preventDefault(); e.stopPropagation();
            dragCounter++;
            if (dragCounter === 1) dropzone.classList.add('drag-over');
        });

        dropzone.addEventListener('dragover', function (e) {
            e.preventDefault(); e.stopPropagation();
        });

        dropzone.addEventListener('dragleave', function (e) {
            e.preventDefault(); e.stopPropagation();
            dragCounter--;
            if (dragCounter === 0) dropzone.classList.remove('drag-over');
        });

        dropzone.addEventListener('drop', function (e) {
            e.preventDefault(); e.stopPropagation();
            dragCounter = 0;
            dropzone.classList.remove('drag-over');
            const files = e.dataTransfer.files;
            if (files && files[0]) {
                if (!files[0].type.startsWith('image/')) { showError('Hanya file gambar yang diperbolehkan.'); return; }
                if (files[0].size > 2 * 1024 * 1024) { showError('Ukuran file maksimal 2 MB.'); return; }
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
            if (file.size > 2 * 1024 * 1024) { showError('Ukuran file maksimal 2 MB.'); fileInput.value = ''; return; }
            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
            if (!allowedTypes.includes(file.type)) { showError('Format gambar tidak didukung.'); fileInput.value = ''; return; }
            const reader = new FileReader();
            reader.onload = function (e) { previewImg.src = e.target.result; showPreview(); };
            reader.readAsDataURL(file);
        }

        function showPreview() {
            placeholder.classList.add('d-none'); placeholder.style.display = 'none';
            previewContainer.classList.remove('d-none'); previewContainer.style.display = 'block';
            dropzone.classList.add('has-file'); dropzone.classList.remove('shake');
            const err = dropzone.querySelector('.dropzone-error'); if (err) err.remove();
        }

        function clearFile() {
            fileInput.value = '';
            previewContainer.classList.add('d-none'); previewContainer.style.display = 'none';
            placeholder.classList.remove('d-none'); placeholder.style.display = '';
            dropzone.classList.remove('has-file'); dropzone.classList.remove('shake');
            const err = dropzone.querySelector('.dropzone-error'); if (err) err.remove();
        }

        function showError(msg) {
            const e = dropzone.querySelector('.dropzone-error'); if (e) e.remove();
            dropzone.classList.add('shake'); setTimeout(() => dropzone.classList.remove('shake'), 600);
            const el = document.createElement('div');
            el.className = 'dropzone-error text-danger small mt-2';
            el.innerHTML = '<i class="bi bi-exclamation-circle me-1"></i>' + msg;
            dropzone.parentNode.insertBefore(el, dropzone.nextSibling);
            setTimeout(() => { if (el.parentNode) el.remove(); }, 3000);
        }

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(ev => {
            document.body.addEventListener(ev, e => { e.preventDefault(); e.stopPropagation(); }, false);
        });
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
