@extends('layouts.admin')

@section('title', 'Pendaftaran Bimbel - Admin Panel')

@push('style')
<style>
    .token-status-badge {
        font-size: 12px;
        padding: 5px 12px;
        border-radius: 50rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .btn-wa {
        background-color: #25D366;
        color: #ffffff !important;
        border: none;
        border-radius: 50rem;
        padding: 4px 12px;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.2s ease;
        text-decoration: none;
    }
    .btn-wa:hover {
        background-color: #1ea952;
        box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);
        transform: translateY(-1px);
    }
</style>
@endpush

@section('content')
<!-- Header -->
<div class="row align-items-center mb-4">
    <div class="col">
        <h1 class="fw-bold h2 mb-1" style="color: var(--dark);">
            <i class="bi bi-card-checklist me-2" style="color: var(--accent);"></i>
            Kelola Pendaftaran Bimbel
        </h1>
        <p class="text-muted mb-0">Setujui pendaftaran dan kirimkan token ke pemesan via WhatsApp.</p>
    </div>
</div>

<!-- Alert Messages -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-3 mb-3" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-3" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Table Card -->
<div class="card main-card border-0 p-3 p-md-4 mb-4">
    <div class="table-responsive">
        <table class="table custom-table align-middle">
            <thead>
                <tr>
                    <th>Pemesan</th>
                    <th>Kontak WA</th>
                    <th>Paket</th>
                    <th>Status Pendaftaran</th>
                    <th>Token Akses</th>
                    <th class="text-center">Aksi & Pengiriman</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendaftarans as $item)
                    <tr>
                        <!-- Pemesan -->
                        <td>
                            <div class="fw-semibold text-dark">{{ $item->nama }}</div>
                            <div class="text-muted" style="font-size: 12px;">{{ $item->email }}</div>
                        </td>

                        <!-- WA -->
                        <td>
                            <div class="fw-medium text-dark"><i class="bi bi-whatsapp text-success me-1"></i>{{ $item->no_wa }}</div>
                        </td>

                        <!-- Paket -->
                        <td>
                            <span class="badge rounded-pill" style="background:#93E1D8;color:#2F4858; font-weight: 600;">
                                Paket {{ strtoupper($item->paket) }}
                            </span>
                        </td>

                        <!-- Status Pendaftaran -->
                        <td>
                            @if($item->status === 'pending' || empty($item->status))
                                <span class="badge rounded-pill bg-warning-subtle text-warning border border-warning-subtle px-3 py-1">Pending</span>
                            @elseif($item->status === 'diterima')
                                <span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle px-3 py-1">Diterima</span>
                            @else
                                <span class="badge rounded-pill bg-danger-subtle text-danger border border-danger-subtle px-3 py-1">Ditolak</span>
                            @endif
                        </td>

                        <!-- Token — hanya tampilkan STATUS, bukan nilai token -->
                        <td>
                            @if($item->token)
                                @if($item->token->status === 'unused')
                                    <span class="token-status-badge bg-success-subtle text-success border border-success-subtle">
                                        <i class="bi bi-shield-check-fill"></i> Token Aktif
                                    </span>
                                @elseif($item->token->status === 'used')
                                    <span class="token-status-badge bg-secondary-subtle text-secondary border border-secondary-subtle" title="Digunakan: {{ $item->token->used_at?->format('d M Y H:i') }}">
                                        <i class="bi bi-shield-slash-fill"></i> Telah Digunakan
                                    </span>
                                @else
                                    <span class="token-status-badge bg-danger-subtle text-danger border border-danger-subtle">
                                        <i class="bi bi-shield-x-fill"></i> Kedaluwarsa
                                    </span>
                                @endif
                            @else
                                <span class="text-muted small"><em>Belum ada token</em></span>
                            @endif
                        </td>

                        <!-- Aksi -->
                        <td>
                            <div class="d-flex justify-content-center align-items-center gap-2 flex-wrap">
                                @if($item->status === 'pending' || empty($item->status))
                                    <!-- Tombol WhatsApp Konfirmasi Pendaftar Baru -->
                                    @php
                                        $cleanPhonePending = preg_replace('/[^0-9]/', '', $item->no_wa);
                                        if (str_starts_with($cleanPhonePending, '0')) {
                                            $cleanPhonePending = '62' . substr($cleanPhonePending, 1);
                                        }
                                        $pendingWaMsg = "Halo *" . $item->nama . "*,\n\nKami dari Tim Admin *LesGo* ingin mengonfirmasi pendaftaran Bimbel Anda (Paket *" . strtoupper($item->paket) . "*).\n\nApakah ada data atau pertanyaan yang ingin disampaikan sebelum pendaftaran Anda kami proses lebih lanjut? Terima kasih!";
                                        $pendingWaUrl = "https://wa.me/" . $cleanPhonePending . "?text=" . rawurlencode($pendingWaMsg);
                                    @endphp
                                    <a href="{{ $pendingWaUrl }}" target="_blank" class="btn-wa" title="Hubungi Pendaftar via WhatsApp">
                                        <i class="bi bi-whatsapp"></i> Chat WA
                                    </a>

                                    <!-- Approve -->
                                    <form method="POST" action="{{ route('admin.pendaftaran-bimbel.approve', $item->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-success rounded-pill px-3 py-1" style="font-size: 12px;" title="Setujui & Generate Token">
                                            <i class="bi bi-check-lg me-1"></i> Setujui
                                        </button>
                                    </form>

                                    <!-- Reject -->
                                    <form method="POST" action="{{ route('admin.pendaftaran-bimbel.reject', $item->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-2 py-1" style="font-size: 12px;" title="Tolak Pendaftaran">
                                            <i class="bi bi-x-lg"></i> Tolak
                                        </button>
                                    </form>
                                @endif

                                @if($item->status === 'diterima' && !$item->token)
                                    <!-- Generate Manual -->
                                    <form method="POST" action="{{ route('admin.pendaftaran-bimbel.generate-token', $item->id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-warning text-dark rounded-pill px-3 py-1 fw-medium" style="font-size: 12px;">
                                            <i class="bi bi-magic me-1"></i> Generate Token
                                        </button>
                                    </form>
                                @endif

                                @if($item->token)
                                    {{--
                                        PENTING: Tidak ada token di HTML ini.
                                        Tombol di bawah mengarah ke route server-side yang akan
                                        meng-generate URL WhatsApp dan redirect langsung.
                                        Admin tidak pernah melihat nilai token.
                                    --}}
                                    <a href="{{ route('admin.pendaftaran-bimbel.kirim-token-wa', $item->id) }}"
                                       class="btn-wa"
                                       title="Kirim Token ke Pendaftar via WhatsApp (Token diproses di server)">
                                        <i class="bi bi-whatsapp"></i> Kirim WA Token
                                    </a>
                                @endif

                                <!-- Detail Modal Button (tanpa token) -->
                                <button type="button" class="btn btn-sm btn-light rounded-pill px-2 py-1 text-secondary border" style="font-size: 12px;"
                                    onclick="openDetailModal(
                                        '{{ addslashes($item->nama) }}',
                                        '{{ addslashes($item->email) }}',
                                        '{{ addslashes($item->no_wa) }}',
                                        '{{ strtoupper($item->paket) }}',
                                        '{{ $item->status }}',
                                        '{{ $item->token ? $item->token->status : 'none' }}',
                                        '{{ addslashes($item->catatan ?? '-') }}'
                                    )">
                                    <i class="bi bi-eye"></i> Detail
                                </button>

                                <!-- Tombol Hapus -->
                                <form method="POST" action="{{ route('admin.pendaftaran-bimbel.destroy', $item->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pendaftaran {{ addslashes($item->nama) }}? Data yang dihapus tidak dapat dikembalikan.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-2 py-1" style="font-size: 12px;" title="Hapus Pendaftaran">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Belum ada pendaftaran bimbel.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Detail (tanpa token) -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" style="color: var(--dark);">
                    <i class="bi bi-info-circle-fill text-primary me-2"></i> Detail Pendaftaran Bimbel
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="form-label text-muted small mb-0">Nama Lengkap</label>
                    <div class="fw-semibold text-dark fs-6" id="modalNama">-</div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <label class="form-label text-muted small mb-0">Email</label>
                        <div class="fw-medium text-dark" id="modalEmail">-</div>
                    </div>
                    <div class="col-6">
                        <label class="form-label text-muted small mb-0">No. WhatsApp</label>
                        <div class="fw-medium text-dark" id="modalWa">-</div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <label class="form-label text-muted small mb-0">Paket Bimbel</label>
                        <div><span class="badge bg-info-subtle text-info fs-6 px-3 py-1" id="modalPaket">-</span></div>
                    </div>
                    <div class="col-6">
                        <label class="form-label text-muted small mb-0">Status Pendaftaran</label>
                        <div id="modalStatus">-</div>
                    </div>
                </div>
                <!-- Status Token: hanya tampilkan apakah token ada/tidak dan statusnya -->
                <div class="mb-3">
                    <label class="form-label text-muted small mb-0">Status Token</label>
                    <div id="modalTokenStatus">-</div>
                </div>
                <div>
                    <label class="form-label text-muted small mb-0">Catatan</label>
                    <div class="p-3 bg-light rounded-3 text-secondary small" id="modalCatatan">-</div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    function openDetailModal(nama, email, wa, paket, status, tokenStatus, catatan) {
        document.getElementById('modalNama').textContent = nama;
        document.getElementById('modalEmail').textContent = email;
        document.getElementById('modalWa').textContent = wa;
        document.getElementById('modalPaket').textContent = paket;
        document.getElementById('modalCatatan').textContent = catatan;

        // Status pendaftaran badge
        let statusBadge = '';
        if (status === 'pending' || status === '') {
            statusBadge = '<span class="badge rounded-pill bg-warning-subtle text-warning border border-warning-subtle px-3 py-1">Pending</span>';
        } else if (status === 'diterima') {
            statusBadge = '<span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle px-3 py-1">Diterima</span>';
        } else {
            statusBadge = '<span class="badge rounded-pill bg-danger-subtle text-danger border border-danger-subtle px-3 py-1">Ditolak</span>';
        }
        document.getElementById('modalStatus').innerHTML = statusBadge;

        // Status token (tanpa nilai token)
        let tokenBadge = '';
        if (tokenStatus === 'none') {
            tokenBadge = '<span class="badge rounded-pill bg-secondary-subtle text-muted px-3 py-1"><i class="bi bi-shield-slash me-1"></i>Belum Ada Token</span>';
        } else if (tokenStatus === 'unused') {
            tokenBadge = '<span class="badge rounded-pill bg-success-subtle text-success px-3 py-1"><i class="bi bi-shield-check-fill me-1"></i>Token Aktif (Belum Digunakan)</span>';
        } else if (tokenStatus === 'used') {
            tokenBadge = '<span class="badge rounded-pill bg-secondary-subtle text-secondary px-3 py-1"><i class="bi bi-shield-slash-fill me-1"></i>Token Telah Digunakan</span>';
        } else {
            tokenBadge = '<span class="badge rounded-pill bg-danger-subtle text-danger px-3 py-1"><i class="bi bi-shield-x-fill me-1"></i>Token Kedaluwarsa</span>';
        }
        document.getElementById('modalTokenStatus').innerHTML = tokenBadge;

        const modal = new bootstrap.Modal(document.getElementById('detailModal'));
        modal.show();
    }
</script>
@endpush
