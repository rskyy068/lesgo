@extends('layouts.guest')

@section('content')
<style>
    /* Styling khusus nuansa Marketplace */
    body {
        background-color: #f3f4f5;
    }
    .card-marketplace {
        border: none;
        border-radius: 12px;
        box-shadow: 0 1px 6px 0 rgba(49, 53, 59, 0.12);
        background-color: #ffffff;
    }
    .text-mp-primary {
        color: #03AC0E !important; /* Warna hijau khas marketplace */
    }
    .bg-mp-primary {
        background-color: #03AC0E !important;
    }
    .btn-mp-primary {
        background-color: #03AC0E;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s;
    }
    .btn-mp-primary:hover {
        background-color: #028C0B;
        color: #fff;
    }
    .timer-alert {
        background-color: #FFF2ED;
        border: 1px solid #FFD3C6;
        color: #EF144A;
        border-radius: 8px;
    }
    .accordion-button:not(.collapsed) {
        background-color: #F3FDF5;
        color: #03AC0E;
        box-shadow: none;
        font-weight: 600;
    }
    .accordion-button:focus {
        box-shadow: none;
    }
    .sticky-summary {
        position: sticky;
        top: 24px;
    }
    .payment-logo {
        height: 24px;
        object-fit: contain;
    }
    .copy-btn {
        color: #03AC0E;
        background: none;
        border: none;
        font-weight: 600;
        font-size: 0.9rem;
    }
    .copy-btn:hover {
        color: #028C0B;
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <!-- Header & Timer -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="{{ route('pesanan') }}" class="text-decoration-none text-muted fw-semibold">
                    <i class="bi bi-chevron-left me-1"></i> Kembali
                </a>
                <h4 class="fw-bold mb-0 text-dark">Pembayaran</h4>
                <div style="width: 80px;"></div> <!-- Spacer -->
            </div>

            <div class="timer-alert d-flex justify-content-between align-items-center p-3 mb-4 shadow-sm">
                <div class="d-flex align-items-center">
                    <i class="bi bi-clock-history fs-4 me-3"></i>
                    <div>
                        <div class="small fw-semibold">Selesaikan pembayaran dalam</div>
                        <div class="fw-bold fs-5 timer-countdown">23:59:59</div>
                    </div>
                </div>
                <div class="text-end small d-none d-md-block">
                    Jatuh tempo:<br>
                    <strong>{{ \Carbon\Carbon::now()->addDay()->format('d M Y, H:i') }}</strong>
                </div>
            </div>

            <div class="row g-4">
                <!-- KIRI: Metode Pembayaran -->
                <div class="col-md-7">
                    <div class="card-marketplace p-4 mb-4">
                        <h5 class="fw-bold mb-3">Pilih Metode Pembayaran</h5>
                        <p class="text-muted small mb-4">Pilih metode pembayaran yang paling nyaman untuk Anda.</p>

                        <div class="accordion" id="accordionPayment">

                            <!-- QRIS -->
                            <div class="accordion-item border rounded mb-3 overflow-hidden">
                                <h2 class="accordion-header" id="headingQris">
                                    <button class="accordion-button collapsed bg-white text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseQris">
                                        <div class="d-flex align-items-center w-100">
                                            <i class="bi bi-qr-code-scan fs-5 text-mp-primary me-3"></i>
                                            <span class="fw-semibold">QRIS (GoPay, OVO, Dana, LinkAja)</span>
                                        </div>
                                    </button>
                                </h2>
                                <div id="collapseQris" class="accordion-collapse collapse" data-bs-parent="#accordionPayment">
                                    <div class="accordion-body bg-light text-center border-top">
                                        <p class="text-muted small mb-3">Scan kode QR ini menggunakan aplikasi E-Wallet atau M-Banking Anda.</p>
                                        <div class="bg-white p-3 d-inline-block border rounded shadow-sm mb-2">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/d/d0/QR_code_for_mobile_English_Wikipedia.svg" alt="QRIS" width="160">
                                        </div>
                                        <h6 class="fw-bold text-dark mt-2 mb-0">NMID: ID1029384756</h6>
                                        <small class="text-muted">a.n Bimbel Lesgo</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Transfer Bank / Virtual Account -->
                            <div class="accordion-item border rounded mb-3 overflow-hidden">
                                <h2 class="accordion-header" id="headingBank">
                                    <button class="accordion-button collapsed bg-white text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBank">
                                        <div class="d-flex align-items-center w-100">
                                            <i class="bi bi-bank fs-5 text-mp-primary me-3"></i>
                                            <span class="fw-semibold">Transfer Bank (Virtual Account)</span>
                                        </div>
                                    </button>
                                </h2>
                                <div id="collapseBank" class="accordion-collapse collapse" data-bs-parent="#accordionPayment">
                                    <div class="accordion-body p-0 border-top">
                                        <ul class="list-group list-group-flush border-0">
                                            <li class="list-group-item p-3 d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <div class="me-3 fw-bold text-primary" style="font-style: italic;">BCA</div>
                                                    <div>
                                                        <div class="small text-muted mb-1">BCA Virtual Account</div>
                                                        <div class="fw-bold text-dark fs-6">8732 1092 33</div>
                                                    </div>
                                                </div>
                                                <button class="copy-btn">Salin</button>
                                            </li>
                                            <li class="list-group-item p-3 d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <div class="me-3 fw-bold text-warning" style="font-style: italic;">Mandiri</div>
                                                    <div>
                                                        <div class="small text-muted mb-1">Mandiri Virtual Account</div>
                                                        <div class="fw-bold text-dark fs-6">1370 0019 2839</div>
                                                    </div>
                                                </div>
                                                <button class="copy-btn">Salin</button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Minimarket -->
                            <div class="accordion-item border rounded overflow-hidden">
                                <h2 class="accordion-header" id="headingMinimarket">
                                    <button class="accordion-button collapsed bg-white text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMinimarket">
                                        <div class="d-flex align-items-center w-100">
                                            <i class="bi bi-shop fs-5 text-mp-primary me-3"></i>
                                            <span class="fw-semibold">Minimarket (Indomaret / Alfamart)</span>
                                        </div>
                                    </button>
                                </h2>
                                <div id="collapseMinimarket" class="accordion-collapse collapse" data-bs-parent="#accordionPayment">
                                    <div class="accordion-body bg-light border-top">
                                        <div class="d-flex justify-content-between align-items-center bg-white p-3 border rounded">
                                            <div>
                                                <div class="small text-muted mb-1">Kode Pembayaran</div>
                                                <div class="fw-bold text-dark fs-5 tracking-wide">LGO-{{ $pesanan->no_wa }}</div>
                                            </div>
                                            <button class="copy-btn">Salin</button>
                                        </div>
                                        <p class="text-muted small mt-3 mb-0"><i class="bi bi-info-circle me-1"></i> Tunjukkan kode di atas kepada kasir minimarket untuk menyelesaikan pembayaran.</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- KANAN: Detail Pemesanan (Sticky) -->
                <div class="col-md-5">
                    <div class="card-marketplace p-4 sticky-summary">
                        <h5 class="fw-bold mb-4">Ringkasan Belanja</h5>

                        <div class="d-flex justify-content-between mb-2 small">
                            <span class="text-muted">Nomor Pesanan</span>
                            <span class="fw-semibold text-dark">#ORD-{{ str_pad($pesanan->id, 4, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2 small">
                            <span class="text-muted">Nama Pendaftar</span>
                            <span class="text-dark">{{ $pesanan->nama }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-4 small">
                            <span class="text-muted">Paket Pilihan</span>
                            <span class="text-dark">Paket Pemasaran Bimbel</span>
                        </div>

                        <hr class="text-muted opacity-25">

                        <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
                            <span class="fw-semibold text-dark">Total Tagihan</span>
                            <span class="fs-4 fw-bold text-mp-primary">Rp {{ number_format($harga, 0, ',', '.') }}</span>
                        </div>

                        <!-- Tombol Konfirmasi -->
                        <button type="button" class="btn btn-mp-primary w-100 py-2 mb-3 shadow-sm">
                            Saya Sudah Bayar
                        </button>

                        <div class="text-center text-muted small">
                            <i class="bi bi-shield-check text-mp-primary fs-6 align-middle me-1"></i>
                            <span>Pembayaran Anda aman dan dilindungi</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
