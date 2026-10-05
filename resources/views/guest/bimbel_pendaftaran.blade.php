@extends('layouts.guest')

@section('title', 'Pendaftaran & Detail Bimbel - ' . $bimbel->nama)

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

    .pendaftaran-wrapper {
        min-height: 85vh;
        padding: 40px 0 60px;
    }

    .info-card, .form-card {
        background: var(--lesgo-card-bg);
        border-radius: 24px;
        border: 1px solid var(--lesgo-border);
        box-shadow: 0 10px 30px rgba(47, 72, 88, 0.05);
        overflow: hidden;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .bimbel-cover-img {
        height: 190px;
        width: 100%;
        object-fit: cover;
    }

    .bimbel-logo-avatar {
        width: 72px;
        height: 72px;
        border-radius: 20px;
        object-fit: cover;
        border: 3px solid #ffffff;
        box-shadow: 0 6px 16px rgba(47, 72, 88, 0.12);
        background: #ffffff;
        margin-top: -36px;
        position: relative;
        z-index: 2;
    }

    .form-card {
        padding: 36px;
    }

    .form-label-custom {
        color: var(--lesgo-dark);
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 6px;
    }

    .form-control-custom {
        border: 1.5px solid var(--lesgo-border);
        border-radius: 14px;
        padding: 12px 16px;
        background: #ffffff;
        font-size: 0.95rem;
        color: var(--lesgo-dark);
        transition: all 0.2s ease;
    }

    .form-control-custom:focus {
        border-color: var(--lesgo-blue-hover);
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(147, 225, 216, 0.22);
    }

    .btn-whatsapp {
        background: linear-gradient(135deg, #25D366 0%, #1da851 100%);
        color: #ffffff;
        border: none;
        border-radius: 16px;
        padding: 16px 24px;
        font-weight: 700;
        font-size: 1.05rem;
        box-shadow: 0 8px 22px rgba(37, 211, 102, 0.35);
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        width: 100%;
        text-decoration: none;
    }

    .btn-whatsapp:hover {
        background: linear-gradient(135deg, #20bd5a 0%, #199447 100%);
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(37, 211, 102, 0.45);
    }

    .info-list-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 14px;
        font-size: 0.9rem;
        color: var(--lesgo-muted);
    }

    .info-list-item i {
        font-size: 1.15rem;
        margin-top: 2px;
    }

    .badge-soft-primary {
        background: var(--lesgo-blue-bg);
        color: var(--lesgo-dark);
        border: 1px solid var(--lesgo-border);
        font-weight: 600;
    }

    .badge-soft-pink {
        background: var(--lesgo-pink-bg);
        color: var(--lesgo-dark);
        border: 1px solid rgba(255, 153, 128, 0.4);
        font-weight: 600;
    }

    /* Star Rating Widget */
    .star-rating-widget {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
        gap: 8px;
    }

    .star-rating-widget input {
        display: none;
    }

    .star-rating-widget label {
        font-size: 1.8rem;
        color: #cbd5e1;
        cursor: pointer;
        transition: color 0.2s ease, transform 0.1s ease;
    }

    .star-rating-widget label:hover,
    .star-rating-widget label:hover ~ label,
    .star-rating-widget input:checked ~ label {
        color: #f59e0b;
    }

    .star-rating-widget label:hover {
        transform: scale(1.15);
    }

    .review-item-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--lesgo-blue);
    }

    .section-divider {
        border-top: 1px dashed var(--lesgo-border);
        margin: 20px 0;
    }
</style>
@endpush

@section('content')
<div class="pendaftaran-wrapper">
    <div class="container">
        <!-- Back Navigation -->
        <div class="mb-4">
            <a href="{{ route('bimbel.guest') }}" class="btn btn-sm btn-light rounded-pill px-3 shadow-sm border text-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Bimbel
            </a>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert" style="background-color: var(--lesgo-blue-bg); color: var(--lesgo-dark); border: 1px solid var(--lesgo-blue) !important;">
                <i class="bi bi-check-circle-fill me-2" style="color: var(--lesgo-pink);"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            <!-- LEFT COLUMN: INFORMASI & DESKRIPSI LENGKAP BIMBEL -->
            <div class="col-lg-5">
                <div class="info-card d-flex flex-column">
                    <!-- Cover Header -->
                    @php
                        $coverUrl = $bimbel->cover ? asset('storage/' . $bimbel->cover) : 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=600&q=80';
                        $logoUrl = $bimbel->logo ? asset('storage/' . $bimbel->logo) : 'https://ui-avatars.com/api/?name=' . urlencode($bimbel->nama) . '&background=93E1D8&color=2F4858&bold=true';
                        $avgRating = number_format($bimbel->reviews_avg_rating ?? 0, 1);
                        $totalReviews = $bimbel->reviews_count ?? 0;
                    @endphp
                    <div class="position-relative">
                        <img src="{{ $coverUrl }}" class="bimbel-cover-img" alt="Cover {{ $bimbel->nama }}">
                    </div>

                    <div class="px-4 pb-4 flex-grow-1">
                        <!-- Logo & Nama Bimbel -->
                        <div class="d-flex align-items-end gap-3 mb-3">
                            <img src="{{ $logoUrl }}" class="bimbel-logo-avatar" alt="Logo {{ $bimbel->nama }}">
                            <div>
                                <span class="badge rounded-pill badge-soft-primary px-3 py-1 mb-1" style="font-size: 11px;">
                                    <i class="bi bi-building me-1"></i> MITRA TERPERCAYA
                                </span>
                                <h4 class="fw-bold mb-0" style="color: var(--lesgo-dark);">{{ $bimbel->nama }}</h4>
                            </div>
                        </div>

                        <!-- Rating Badge Summary -->
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="badge rounded-pill px-3 py-2" style="background: #fff8e6; color: #b78103; border: 1px solid #ffe8a3; font-size: 13px; font-weight: 700;">
                                <i class="bi bi-star-fill text-warning me-1"></i> {{ $avgRating > 0 ? $avgRating : 'Belum Ada Rating' }} / 5.0
                            </span>
                            <span class="text-muted small fw-semibold">({{ $totalReviews }} Ulasan Siswa)</span>
                        </div>

                        <!-- Ringkasan Badges -->
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            <span class="badge rounded-pill px-3 py-2 badge-soft-pink">
                                <i class="bi bi-mortarboard-fill me-1" style="color: var(--lesgo-pink);"></i> Jenjang {{ $bimbel->jenjang }}
                            </span>
                            <span class="badge rounded-pill px-3 py-2 badge-soft-primary">
                                <i class="bi bi-geo-alt-fill me-1 text-danger"></i> {{ $bimbel->kota }}
                            </span>
                        </div>

                        <div class="section-divider"></div>

                        <!-- Deskripsi Bimbel -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-2" style="color: var(--lesgo-dark);">
                                <i class="bi bi-card-text me-2" style="color: var(--lesgo-pink);"></i> Deskripsi Bimbel
                            </h6>
                            <p class="text-secondary small mb-0" style="line-height: 1.7; white-space: pre-line;">
                                {{ $bimbel->deskripsi ?? 'Bimbingan belajar berkualitas tinggi dengan pengajar profesional dan fasilitas lengkap untuk membantu siswa mencapai prestasi belajar optimal.' }}
                            </p>
                        </div>

                        <!-- Mata Pelajaran yang Disediakan Bimbel Ini -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-2" style="color: var(--lesgo-dark);">
                                <i class="bi bi-book-fill me-2" style="color: var(--lesgo-blue-hover);"></i> Mata Pelajaran yang Tersedia
                            </h6>
                            <div class="d-flex flex-wrap gap-2">
                                @forelse($bimbelMapels as $m)
                                    <span class="badge rounded-pill px-3 py-2" style="background: var(--lesgo-blue-bg); color: var(--lesgo-dark); border: 1px solid var(--lesgo-blue); font-weight: 600;">
                                        <i class="bi bi-check2-circle me-1" style="color: var(--lesgo-pink);"></i> {{ $m }}
                                    </span>
                                @empty
                                    <span class="text-muted small">{{ $bimbel->mapel }}</span>
                                @endforelse
                            </div>
                        </div>

                        <div class="section-divider"></div>

                        <!-- Informasi Detail Kontak & Alamat -->
                        <div class="mb-2">
                            <h6 class="fw-bold mb-3" style="color: var(--lesgo-dark);">
                                <i class="bi bi-info-circle-fill me-2" style="color: var(--lesgo-pink);"></i> Informasi Detail Kontak
                            </h6>

                            <div class="info-list-item">
                                <i class="bi bi-geo-alt-fill text-danger"></i>
                                <div>
                                    <strong class="d-block text-dark">Alamat Lengkap:</strong>
                                    <span>{{ $bimbel->alamat }}</span>
                                </div>
                            </div>

                            @if($bimbel->jam_operasional)
                                <div class="info-list-item">
                                    <i class="bi bi-clock-fill text-primary"></i>
                                    <div>
                                        <strong class="d-block text-dark">Jam Operasional:</strong>
                                        <span>{{ $bimbel->jam_operasional }}</span>
                                    </div>
                                </div>
                            @endif

                            @if($bimbel->harga_mulai)
                                <div class="info-list-item">
                                    <i class="bi bi-cash-stack text-success"></i>
                                    <div>
                                        <strong class="d-block text-dark">Biaya Mulai:</strong>
                                        <span class="fw-bold text-success">Rp {{ number_format($bimbel->harga_mulai, 0, ',', '.') }} / bulan</span>
                                    </div>
                                </div>
                            @endif

                            @if($bimbel->telepon)
                                <div class="info-list-item">
                                    <i class="bi bi-whatsapp text-success"></i>
                                    <div>
                                        <strong class="d-block text-dark">WhatsApp Bimbel:</strong>
                                        <span>{{ $bimbel->telepon }}</span>
                                    </div>
                                </div>
                            @endif

                            @if($bimbel->email)
                                <div class="info-list-item">
                                    <i class="bi bi-envelope-fill text-info"></i>
                                    <div>
                                        <strong class="d-block text-dark">Email Resmi:</strong>
                                        <span>{{ $bimbel->email }}</span>
                                    </div>
                                </div>
                            @endif

                            @if($bimbel->website)
                                <div class="info-list-item">
                                    <i class="bi bi-globe2 text-secondary"></i>
                                    <div>
                                        <strong class="d-block text-dark">Website:</strong>
                                        <a href="{{ $bimbel->website }}" target="_blank" class="text-decoration-none text-primary">{{ $bimbel->website }}</a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- KARTU RATING & ULASAN SISWA -->
                <div class="info-card mt-4 p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                        <h5 class="fw-bold mb-0" style="color: var(--lesgo-dark);">
                            <i class="bi bi-star-fill text-warning me-2"></i> Ulasan & Rating Siswa
                        </h5>
                        <span class="badge rounded-pill bg-light text-dark border">
                            {{ $totalReviews }} Ulasan
                        </span>
                    </div>

                    <!-- Form Tambah Ulasan -->
                    <div class="p-3 rounded-4 mb-4" style="background: var(--lesgo-blue-bg); border: 1px solid var(--lesgo-border);">
                        @auth
                            <h6 class="fw-bold mb-2" style="color: var(--lesgo-dark);">Beri Rating & Ulasan Bimbel Ini</h6>
                            <form action="{{ route('bimbel.review.store', $bimbel->id) }}" method="POST">
                                @csrf
                                <div class="mb-2">
                                    <label class="form-label-custom small text-muted mb-1">Pilih Rating Bintang:</label>
                                    <div class="star-rating-widget">
                                        @for($i = 5; $i >= 1; $i--)
                                            <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" {{ old('rating', 5) == $i ? 'checked' : '' }}>
                                            <label for="star{{ $i }}" title="{{ $i }} Bintang">★</label>
                                        @endfor
                                    </div>
                                    @error('rating')
                                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <textarea name="komentar" rows="3" class="form-control form-control-custom" placeholder="Tuliskan pengalaman atau pendapat Anda tentang bimbel ini..." required>{{ old('komentar') }}</textarea>
                                    @error('komentar')
                                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-sm text-white rounded-pill px-4 shadow-sm fw-semibold" style="background: var(--lesgo-pink);">
                                    <i class="bi bi-send me-1"></i> Kirim Ulasan
                                </button>
                            </form>
                        @else
                            <div class="text-center py-2">
                                <i class="bi bi-lock-fill fs-3 text-muted mb-1 d-block"></i>
                                <p class="small text-muted mb-2">Ingin memberikan rating dan ulasan untuk bimbel ini?</p>
                                <a href="{{ route('login') }}" class="btn btn-sm rounded-pill text-white px-4 fw-semibold" style="background: var(--lesgo-pink);">
                                    Login untuk Memberi Ulasan
                                </a>
                            </div>
                        @endauth
                    </div>

                    <!-- Daftar Ulasan Siswa -->
                    <div class="review-list">
                        @forelse($reviews as $rev)
                            @php
                                $revAvatar = $rev->user?->photo 
                                    ? (str_starts_with($rev->user->photo, 'http') ? $rev->user->photo : asset('storage/' . $rev->user->photo))
                                    : 'https://ui-avatars.com/api/?name=' . urlencode($rev->user?->name ?? 'Siswa') . '&background=93E1D8&color=2F4858&bold=true';
                            @endphp
                            <div class="p-3 mb-3 rounded-3" style="background: #ffffff; border: 1px solid var(--lesgo-border);">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ $revAvatar }}" alt="{{ $rev->user?->name }}" class="review-item-avatar">
                                        <div>
                                            <strong class="d-block text-dark small" style="line-height: 1.2;">{{ $rev->user?->name ?? 'Pengguna' }}</strong>
                                            <small class="text-muted" style="font-size: 11px;">{{ $rev->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                    <div>
                                        @for($s = 1; $s <= 5; $s++)
                                            <i class="bi bi-star-fill {{ $s <= $rev->rating ? 'text-warning' : 'text-muted opacity-25' }}" style="font-size: 13px;"></i>
                                        @endfor
                                    </div>
                                </div>
                                <p class="small text-secondary mb-0" style="line-height: 1.6;">
                                    "{{ $rev->komentar }}"
                                </p>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <i class="bi bi-chat-square-heart fs-2 text-muted d-block mb-2"></i>
                                <p class="small text-muted mb-0">Belum ada ulasan untuk bimbel ini. Jadilah yang pertama memberikan ulasan!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN: FORM PENDAFTARAN SISWA (TANPA PEMILIHAN MAPEL) -->
            <div class="col-lg-7">
                <div class="form-card">
                    <div class="mb-4">
                       
                        <h4 class="fw-bold mb-1" style="color: var(--lesgo-dark);">Form Pendaftaran Siswa</h4>
                        <p class="text-muted small mb-0">Lengkapi data di bawah ini untuk mendaftar. Pendaftaran akan langsung terkirim secara otomatis ke WhatsApp resmi {{ $bimbel->nama }}.</p>
                    </div>

                    <form id="formPendaftaranBimbel">
                        <div class="row g-3">
                            {{-- Nama Pendaftar --}}
                            <div class="col-md-6">
                                <label for="nama" class="form-label-custom">
                                    Nama Lengkap <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       id="nama" 
                                       name="nama" 
                                       class="form-control form-control-custom" 
                                       placeholder="Masukkan nama siswa / orang tua"
                                       value="{{ auth()->check() ? auth()->user()->name : '' }}" 
                                       required>
                            </div>

                            {{-- Nomor WA --}}
                            <div class="col-md-6">
                                <label for="no_wa" class="form-label-custom">
                                    Nomor WhatsApp <span class="text-danger">*</span>
                                </label>
                                <input type="tel" 
                                       id="no_wa" 
                                       name="no_wa" 
                                       class="form-control form-control-custom" 
                                       placeholder="Contoh: 081234567890"
                                       required>
                            </div>

                            {{-- Email --}}
                            <div class="col-md-6">
                                <label for="email" class="form-label-custom">Email Pendaftar</label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       class="form-control form-control-custom" 
                                       placeholder="nama@email.com"
                                       value="{{ auth()->check() ? auth()->user()->email : '' }}">
                            </div>

                            {{-- Jenjang / Kelas --}}
                            <div class="col-md-6">
                                <label for="jenjang" class="form-label-custom">Jenjang / Kelas Siswa</label>
                                <input type="text" 
                                       id="jenjang" 
                                       name="jenjang" 
                                       class="form-control form-control-custom" 
                                       value="{{ $bimbel->jenjang }}" 
                                       placeholder="Contoh: Kelas 10 SMA / SMP / SD">
                            </div>

                            {{-- Catatan / Pesan --}}
                            <div class="col-12">
                                <label for="catatan" class="form-label-custom">Catatan / Pesan Tambahan</label>
                                <textarea id="catatan" 
                                          name="catatan" 
                                          rows="4" 
                                          class="form-control form-control-custom" 
                                          placeholder="Tuliskan pertanyaan atau informasi catatan khusus untuk pihak bimbel (opsional)..."></textarea>
                            </div>
                        </div>

                        <!-- WhatsApp Submit Section -->
                        <div class="mt-4 pt-3 border-top">
                            <button type="submit" class="btn-whatsapp">
                                <i class="bi bi-whatsapp fs-4"></i>
                                Kirim Pendaftaran ke WhatsApp
                            </button>
                            <p class="text-center text-muted small mt-2 mb-0">
                                <i class="bi bi-shield-check text-success me-1"></i>
                                Formulir ini akan otomatis membuka aplikasi WhatsApp menuju kontak resmi <strong>{{ $bimbel->nama }}</strong>.
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('formPendaftaranBimbel');
    
    // Nomor Telepon / WA Bimbel dari Database
    const rawBimbelPhone = @json($bimbel->telepon ?? '081234567890');
    const bimbelNama = @json($bimbel->nama);

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const nama = document.getElementById('nama').value.trim();
        const noWa = document.getElementById('no_wa').value.trim();
        const email = document.getElementById('email').value.trim();
        const jenjang = document.getElementById('jenjang').value.trim();
        const catatan = document.getElementById('catatan').value.trim();

        if (!nama || !noWa) {
            alert('Mohon lengkapi Nama Lengkap dan Nomor WhatsApp Anda.');
            return;
        }

        // Format nomor target Bimbel ke format internasional (62xxx)
        let formattedPhone = rawBimbelPhone.replace(/[^\d]/g, '');
        if (formattedPhone.startsWith('0')) {
            formattedPhone = '62' + formattedPhone.substring(1);
        }

        // Susun template pesan WhatsApp yang rapi dan profesional
        let message = `*FORM PENDAFTARAN SISWA - LESGO*\n\n`;
        message += `Halo *${bimbelNama}*,\n`;
        message += `Saya tertarik untuk mendaftar bimbingan belajar melalui platform LesGo. Berikut data pendaftaran saya:\n\n`;
        message += `📌 *Nama Lengkap:* ${nama}\n`;
        message += `📱 *No. WhatsApp:* ${noWa}\n`;
        if (email) {
            message += `✉️ *Email:* ${email}\n`;
        }
        if (jenjang) {
            message += `🎓 *Jenjang / Kelas:* ${jenjang}\n`;
        }
        if (catatan) {
            message += `💬 *Catatan / Pesan:* ${catatan}\n`;
        }
        message += `\nMohon informasi selengkapnya mengenai proses pendaftaran, rincian biaya, dan jadwal kelas yang tersedia. Terima kasih!`;

        // Direct / Buka WhatsApp Web / App secara langsung tanpa terblokir popup blocker
        const waUrl = `https://wa.me/${formattedPhone}?text=${encodeURIComponent(message)}`;
        window.location.href = waUrl;
    });
});
</script>
@endpush
@endsection
