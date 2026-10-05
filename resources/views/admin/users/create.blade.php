@extends('layouts.admin')

@section('title', 'Tambah User - LesGo Admin')

@push('style')
<style>
    .form-user-card {
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

    .form-control-user,
    .form-select-user {
        border-radius: 12px;
        border: 1.5px solid rgba(147, 225, 216, 0.25);
        padding: 10px 14px;
        font-size: 14px;
        color: var(--dark);
        background-color: #f9fdfc;
        transition: all 0.2s ease;
    }

    .form-control-user:focus,
    .form-select-user:focus {
        border-color: #66c7bc;
        background-color: #ffffff;
        box-shadow: 0 0 0 4px rgba(147, 225, 216, 0.22);
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

    .input-icon-wrap .form-control-user {
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
        padding: 32px 20px;
        text-align: center;
        cursor: pointer;
        background: linear-gradient(135deg, #f9fdfc 0%, #f0f9f7 100%);
        transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        overflow: hidden;
        min-height: 160px;
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

    .dropzone-zone.drag-over .dropzone-icon {
        transform: translateY(-6px) scale(1.1);
    }

    .dropzone-zone.has-file {
        padding: 6px;
        border-style: solid;
        border-color: rgba(147, 225, 216, 0.5);
        background: #ffffff;
        cursor: default;
    }

    .dropzone-zone.has-file:hover {
        box-shadow: 0 4px 20px rgba(147, 225, 216, 0.12);
        transform: none;
    }

    /* Placeholder (empty state) */
    .dropzone-placeholder {
        pointer-events: none;
    }

    .dropzone-icon {
        font-size: 48px;
        color: var(--accent);
        display: block;
        margin-bottom: 12px;
        transition: transform 0.3s ease;
    }

    .dropzone-text {
        font-size: 15px;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 4px;
    }

    .dropzone-subtext {
        font-size: 13px;
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

    /* Preview state */
    .dropzone-preview {
        position: relative;
        width: 100%;
        max-width: 200px;
        margin: 0 auto;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
    }

    .dropzone-preview img {
        width: 100%;
        height: 140px;
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
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
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

    /* Hidden file input */
    .dropzone-input {
        display: none;
    }

    /* Shake animation for invalid state */
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

    /* File size indicator badge */
    .file-size-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 11px;
        font-weight: 500;
        color: #fff;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
        padding: 2px 10px;
        border-radius: 20px;
        position: absolute;
        bottom: 8px;
        right: 8px;
    }</style>
@endpush

@section('content')
<!-- Header -->
<div class="row align-items-center mb-4">
    <div class="col">
        <h1 class="fw-bold h2 mb-1" style="color: var(--dark);">
            <i class="bi bi-person-plus-fill me-2" style="color: var(--accent);"></i>
            Tambah User Baru
        </h1>
        <p class="text-muted mb-0">Daftarkan user baru ke sistem LesGo.</p>
    </div>
    <div class="col-auto">
        <a href="{{ route('admin.users.index') }}" class="btn btn-light rounded-pill px-3 shadow-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<!-- Form -->
<div class="row">
    <div class="col-lg-8">
        <div class="form-user-card p-4 p-md-5">
            <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="section-title">Informasi Akun</div>

                <!-- Name -->
                <div class="mb-3">
                    <label for="name" class="form-label-custom">Nama Lengkap <span class="required">*</span></label>
                    <div class="input-icon-wrap">
                        <i class="bi bi-person-fill"></i>
                        <input type="text"
                               id="name"
                               name="name"
                               class="form-control form-control-user @error('name') is-invalid @enderror"
                               placeholder="Cth: Budi Santoso"
                               value="{{ old('name') }}"
                               required>
                    </div>
                    @error('name')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label-custom">Email <span class="required">*</span></label>
                    <div class="input-icon-wrap">
                        <i class="bi bi-envelope-fill"></i>
                        <input type="email"
                               id="email"
                               name="email"
                               class="form-control form-control-user @error('email') is-invalid @enderror"
                               placeholder="nama@email.com"
                               value="{{ old('email') }}"
                               required>
                    </div>
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Phone -->
                <div class="mb-3">
                    <label for="phone" class="form-label-custom">Nomor Telepon</label>
                    <div class="input-icon-wrap">
                        <i class="bi bi-telephone-fill"></i>
                        <input type="text"
                               id="phone"
                               name="phone"
                               class="form-control form-control-user @error('phone') is-invalid @enderror"
                               placeholder="081234567890"
                               value="{{ old('phone') }}">
                    </div>
                    <div class="form-text-hint">Opsional, maksimal 20 karakter.</div>
                    @error('phone')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="section-title mt-4">Hak Akses</div>

                <!-- Role -->
                <div class="mb-3">
                    <label for="role" class="form-label-custom">Role <span class="required">*</span></label>
                    <select id="role"
                            name="role"
                            class="form-select form-select-user @error('role') is-invalid @enderror"
                            required>
                        <option value="">-- Pilih Role --</option>
                        <option value="user" {{ old('role', 'user') === 'user' ? 'selected' : '' }}>
                            👤 User — Pengguna biasa (lihat bimbel, review, favorit)
                        </option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>
                            🛡️ Administrator — Akses penuh ke panel admin
                        </option>
                    </select>
                    @error('role')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="section-title mt-4">Keamanan</div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label-custom">Kata Sandi <span class="required">*</span></label>
                    <div class="input-icon-wrap">
                        <i class="bi bi-lock-fill"></i>
                        <input type="password"
                               id="password"
                               name="password"
                               class="form-control form-control-user @error('password') is-invalid @enderror"
                               placeholder="Minimal 8 karakter"
                               required>
                    </div>
                    <div class="form-text-hint">User dapat mengubah kata sandi setelah masuk.</div>
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password Confirmation -->
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label-custom">Konfirmasi Kata Sandi <span class="required">*</span></label>
                    <div class="input-icon-wrap">
                        <i class="bi bi-shield-lock-fill"></i>
                        <input type="password"
                               id="password_confirmation"
                               name="password_confirmation"
                               class="form-control form-control-user"
                               placeholder="Ulangi kata sandi"
                               required>
                    </div>
                </div>

                <div class="section-title mt-4">Tambahan (Opsional)</div>

                <!-- Photo Upload Dropzone -->
                <div class="mb-3">
                    <label class="form-label-custom">Foto Profil</label>
                    <div class="dropzone-zone" id="photo-dropzone">
                        <div class="dropzone-placeholder" id="dropzonePlaceholder">
                            <i class="bi bi-cloud-arrow-up-fill dropzone-icon"></i>
                            <p class="dropzone-text">Tarik & lepas gambar di sini</p>
                            <p class="dropzone-subtext">atau <span class="dropzone-link">klik untuk memilih file</span></p>
                        </div>
                        <div class="dropzone-preview d-none" id="dropzonePreview">
                            <img id="photoPreview" alt="Preview foto profil">
                            <div class="dropzone-preview-overlay">
                                <button type="button" class="dropzone-remove-btn" id="removePhotoBtn" title="Hapus foto">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                                <button type="button" class="dropzone-change-btn" id="changePhotoBtn" title="Ganti foto">
                                    <i class="bi bi-pencil-fill"></i>
                                </button>
                            </div>
                        </div>
                        <input type="file"
                               id="photo"
                               name="photo"
                               accept="image/*"
                               class="dropzone-input @error('photo') is-invalid @enderror">
                    </div>
                    <div class="form-text-hint">
                        <i class="bi bi-info-circle me-1"></i>Unggah gambar profil. Format: JPG, PNG, WebP. Maksimal 2 MB. Jika kosong, akan menggunakan inisial nama.
                    </div>
                    @error('photo')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn-form-primary">
                        <i class="bi bi-check2-circle me-1"></i> Simpan User
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn-form-secondary">
                        <i class="bi bi-x-lg me-1"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tips Panel -->
    <div class="col-lg-4">
        <div class="form-user-card p-4" style="background: linear-gradient(135deg, #f4fbf9 0%, #ffffff 100%);">
            <h6 class="fw-bold mb-3" style="color: var(--dark);">
                <i class="bi bi-info-circle-fill me-2" style="color: var(--accent);"></i> Tips
            </h6>
            <ul class="text-secondary small mb-0" style="padding-left: 18px;">
                <li class="mb-2">Pastikan email belum pernah terdaftar sebelumnya.</li>
                <li class="mb-2">Gunakan kata sandi minimal 8 karakter.</li>
                <li class="mb-2">Hati-hati memberikan role <strong>Administrator</strong>.</li>
                <li class="mb-2">User dengan role Admin akan otomatis masuk ke Dashboard Admin saat login.</li>
            </ul>
        </div>
    </div>
</div>
@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dropzone = document.getElementById('photo-dropzone');
        const fileInput = document.getElementById('photo');
        const placeholder = document.getElementById('dropzonePlaceholder');
        const previewContainer = document.getElementById('dropzonePreview');
        const previewImg = document.getElementById('photoPreview');
        const removeBtn = document.getElementById('removePhotoBtn');
        const changeBtn = document.getElementById('changePhotoBtn');

        let currentFile = null;

        // ─── Open file manager on click ───
        dropzone.addEventListener('click', function (e) {
            // Don't trigger if clicking the remove/change buttons
            if (e.target.closest('.dropzone-remove-btn') || e.target.closest('.dropzone-change-btn')) {
                return;
            }
            fileInput.click();
        });

        // ─── File selected via file manager ───
        fileInput.addEventListener('change', function () {
            if (fileInput.files && fileInput.files[0]) {
                handleFile(fileInput.files[0]);
            }
        });

        // ─── Drag events ───
        let dragCounter = 0;

        dropzone.addEventListener('dragenter', function (e) {
            e.preventDefault();
            e.stopPropagation();
            dragCounter++;
            if (dragCounter === 1) {
                dropzone.classList.add('drag-over');
            }
        });

        dropzone.addEventListener('dragover', function (e) {
            e.preventDefault();
            e.stopPropagation();
        });

        dropzone.addEventListener('dragleave', function (e) {
            e.preventDefault();
            e.stopPropagation();
            dragCounter--;
            if (dragCounter === 0) {
                dropzone.classList.remove('drag-over');
            }
        });

        dropzone.addEventListener('drop', function (e) {
            e.preventDefault();
            e.stopPropagation();
            dragCounter = 0;
            dropzone.classList.remove('drag-over');

            const files = e.dataTransfer.files;
            if (files && files[0]) {
                // Validate it's an image
                if (!files[0].type.startsWith('image/')) {
                    showError('Hanya file gambar yang diperbolehkan.');
                    return;
                }
                // Validate file size (max 2MB)
                if (files[0].size > 2 * 1024 * 1024) {
                    showError('Ukuran file maksimal 2 MB.');
                    return;
                }
                handleFile(files[0]);
            }
        });

        // ─── Remove photo ───
        removeBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            clearFile();
        });

        // ─── Change photo ───
        changeBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            fileInput.click();
        });

        // ─── Handle file: validate, preview, store ───
        function handleFile(file) {
            // Validate file size
            if (file.size > 2 * 1024 * 1024) {
                showError('Ukuran file maksimal 2 MB.');
                fileInput.value = '';
                return;
            }

            // Validate image type
            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
            if (!allowedTypes.includes(file.type)) {
                showError('Format gambar tidak didukung. Gunakan JPG, PNG, GIF, atau WebP.');
                fileInput.value = '';
                return;
            }

            currentFile = file;

            // Show preview
            const reader = new FileReader();
            reader.onload = function (e) {
                previewImg.src = e.target.result;
                showPreview();
            };
            reader.readAsDataURL(file);
        }

        function showPreview() {
            placeholder.classList.add('d-none');
            placeholder.style.display = 'none';
            previewContainer.classList.remove('d-none');
            previewContainer.style.display = 'block';
            dropzone.classList.add('has-file');
            dropzone.classList.remove('shake');

            // Remove any error state
            const errorEl = dropzone.querySelector('.dropzone-error');
            if (errorEl) errorEl.remove();
        }

        function clearFile() {
            currentFile = null;
            fileInput.value = '';
            previewContainer.classList.add('d-none');
            previewContainer.style.display = 'none';
            placeholder.classList.remove('d-none');
            placeholder.style.display = '';
            dropzone.classList.remove('has-file');
            dropzone.classList.remove('shake');

            const errorEl = dropzone.querySelector('.dropzone-error');
            if (errorEl) errorEl.remove();
        }

        function showError(message) {
            // Remove existing error if any
            const existingError = dropzone.querySelector('.dropzone-error');
            if (existingError) existingError.remove();

            dropzone.classList.add('shake');
            setTimeout(() => dropzone.classList.remove('shake'), 600);

            const errorEl = document.createElement('div');
            errorEl.className = 'dropzone-error text-danger small mt-2';
            errorEl.innerHTML = `<i class="bi bi-exclamation-circle me-1"></i>${message}`;
            dropzone.parentNode.insertBefore(errorEl, dropzone.nextSibling);

            // Auto-dismiss after 3 seconds
            setTimeout(() => {
                if (errorEl.parentNode) errorEl.remove();
            }, 3000);
        }

        // ─── Optional: drag-and-drop from outside the browser (e.g., desktop) ───
        // Prevent default drag behaviors on the whole page
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            document.body.addEventListener(eventName, function (e) {
                e.preventDefault();
                e.stopPropagation();
            }, false);
        });
    });
</script>
@endpush

@endsection
