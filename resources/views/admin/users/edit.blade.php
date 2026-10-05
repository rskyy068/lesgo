@extends('layouts.admin')

@section('title', 'Edit User - LesGo Admin')

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

    .btn-danger-outline {
        background-color: transparent;
        color: #dc3545;
        border: 1.5px solid #f5c2c7;
        border-radius: 12px;
        padding: 10px 22px;
        font-weight: 600;
        font-size: 14px;
        transition: var(--transition);
    }

    .btn-danger-outline:hover {
        background-color: #dc3545;
        color: #fff;
    }

    /* Avatar preview */
    .avatar-preview {
        width: 84px;
        height: 84px;
        border-radius: 50%;
        background: linear-gradient(135deg, #93E1D8, #DDFFF7);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
        font-weight: 700;
        color: var(--dark);
        border: 4px solid #ffffff;
        box-shadow: 0 4px 12px rgba(47, 72, 88, 0.1);
        margin-bottom: 16px;
    }

    .avatar-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }
</style>
@endpush

@section('content')
<!-- Header -->
<div class="row align-items-center mb-4">
    <div class="col">
        <h1 class="fw-bold h2 mb-1" style="color: var(--dark);">
            <i class="bi bi-pencil-square me-2" style="color: var(--accent);"></i>
            Edit User
        </h1>
        <p class="text-muted mb-0">Ubah data untuk <strong>{{ $user->name }}</strong>.</p>
    </div>
    <div class="col-auto">
        <a href="{{ route('admin.users.index') }}" class="btn btn-light rounded-pill px-3 shadow-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<!-- Form -->
<form action="{{ route('admin.users.update', $user) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-lg-8">
            <div class="form-user-card p-4 p-md-5">
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
                               value="{{ old('name', $user->name) }}"
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
                               value="{{ old('email', $user->email) }}"
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
                               value="{{ old('phone', $user->phone) }}">
                    </div>
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
                            required
                            {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                        <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>
                            👤 User Biasa
                        </option>
                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>
                            🛡️ Administrator
                        </option>
                    </select>
                    @if($user->id === auth()->id())
                        <input type="hidden" name="role" value="{{ $user->role }}">
                        <div class="form-text-hint" style="color:#d87e76;">
                            <i class="bi bi-info-circle-fill"></i> Anda tidak dapat mengubah role akun sendiri.
                        </div>
                    @endif
                    @error('role')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="section-title mt-4">Keamanan</div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label-custom">Kata Sandi Baru</label>
                    <div class="input-icon-wrap">
                        <i class="bi bi-lock-fill"></i>
                        <input type="password"
                               id="password"
                               name="password"
                               class="form-control form-control-user @error('password') is-invalid @enderror"
                               placeholder="Kosongkan jika tidak ingin mengubah">
                    </div>
                    <div class="form-text-hint">
                        <i class="bi bi-info-circle"></i> Biarkan kosong jika tidak ingin mengubah kata sandi. Minimal 8 karakter.
                    </div>
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label-custom">Konfirmasi Kata Sandi Baru</label>
                    <div class="input-icon-wrap">
                        <i class="bi bi-shield-lock-fill"></i>
                        <input type="password"
                               id="password_confirmation"
                               name="password_confirmation"
                               class="form-control form-control-user"
                               placeholder="Ulangi kata sandi baru">
                    </div>
                </div>

                <div class="section-title mt-4">Tambahan (Opsional)</div>

                <!-- Photo URL -->
                <div class="mb-3">
                    <label for="photo" class="form-label-custom">URL Foto Profil</label>
                    <div class="input-icon-wrap">
                        <i class="bi bi-image-fill"></i>
                        <input type="url"
                               id="photo"
                               name="photo"
                               class="form-control form-control-user @error('photo') is-invalid @enderror"
                               value="{{ old('photo', $user->photo) }}">
                    </div>
                    @error('photo')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn-form-primary">
                        <i class="bi bi-check2-circle me-1"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn-form-secondary">
                        <i class="bi bi-x-lg me-1"></i> Batal
                    </a>
                </div>
            </div>
        </div>

        <!-- Avatar Preview & Tips -->
        <div class="col-lg-4">
            <div class="form-user-card p-4 mb-3">
                <h6 class="fw-bold mb-3" style="color: var(--dark);">
                    <i class="bi bi-person-bounding-box me-2" style="color: var(--accent);"></i> Preview Avatar
                </h6>
                <div class="avatar-preview" id="avatarPreview">
                    @if($user->photo)
                        <img src="{{ $user->photo }}" alt="{{ $user->name }}" id="avatarImg">
                    @else
                        <span id="avatarInitial">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                    @endif
                </div>
                <small class="text-muted d-block">Avatar akan otomatis mengikuti kolom URL Foto Profil di samping.</small>
            </div>

            <div class="form-user-card p-4" style="background: linear-gradient(135deg, #f4fbf9 0%, #ffffff 100%);">
                <h6 class="fw-bold mb-3" style="color: var(--dark);">
                    <i class="bi bi-clock-history me-2" style="color: var(--accent);"></i> Aktivitas
                </h6>
                <div class="d-flex justify-content-between text-secondary small mb-2">
                    <span>Bergabung</span>
                    <strong>{{ $user->created_at ? $user->created_at->translatedFormat('d F Y') : '—' }}</strong>
                </div>
                <div class="d-flex justify-content-between text-secondary small mb-2">
                    <span>Terakhir diubah</span>
                    <strong>{{ $user->updated_at ? $user->updated_at->translatedFormat('d F Y H:i') : '—' }}</strong>
                </div>
            </div>
        </div>
    </div>
</form>

@if($user->id !== auth()->id())
    <div class="row mt-4">
        <div class="col-lg-8">
            <div class="form-user-card p-4" style="border-color: rgba(220, 53, 69, 0.2);">
                <h6 class="fw-bold mb-2" style="color: #dc3545;">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> Zona Berbahaya
                </h6>
                <p class="text-secondary small mb-3">
                    Menghapus user akan menghapus semua data terkait (review, favorit). Tindakan ini tidak dapat dibatalkan.
                </p>
                <form action="{{ route('admin.users.destroy', $user) }}"
                      method="POST"
                      onsubmit="return confirm('Hapus user {{ addslashes($user->name) }}? Semua data terkait akan ikut terhapus dan TIDAK DAPAT dibatalkan.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger-outline">
                        <i class="bi bi-trash me-1"></i> Hapus User Ini
                    </button>
                </form>
            </div>
        </div>
    </div>
@endif
@endsection

@push('script')
<script>
    // Live preview foto profil dari URL
    document.addEventListener('DOMContentLoaded', function () {
        const photoInput = document.getElementById('photo');
        const avatarPreview = document.getElementById('avatarPreview');
        const avatarImg = document.getElementById('avatarImg');
        const avatarInitial = document.getElementById('avatarInitial');
        const nameInput = document.getElementById('name');

        if (photoInput) {
            photoInput.addEventListener('input', function () {
                const v = photoInput.value.trim();
                if (v) {
                    if (!avatarImg) {
                        const img = document.createElement('img');
                        img.id = 'avatarImg';
                        img.alt = nameInput.value;
                        avatarPreview.innerHTML = '';
                        avatarPreview.appendChild(img);
                    }
                    document.getElementById('avatarImg').src = v;
                    if (avatarInitial) avatarInitial.remove();
                } else {
                    avatarPreview.innerHTML = '<span id="avatarInitial">' + (nameInput.value ? nameInput.value.charAt(0).toUpperCase() : '?') + '</span>';
                }
            });
        }

        if (nameInput && document.getElementById('avatarInitial')) {
            nameInput.addEventListener('input', function () {
                const initialEl = document.getElementById('avatarInitial');
                if (initialEl && (!photoInput || !photoInput.value.trim())) {
                    initialEl.textContent = nameInput.value ? nameInput.value.charAt(0).toUpperCase() : '?';
                }
            });
        }
    });
</script>
@endpush
