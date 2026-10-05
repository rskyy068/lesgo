<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    :root {
        --primary: #7ACCC2;
        --primary-light: #DDFFF7;
        --accent: #FFA69E;
        --dark: #2F4858;
        --white: #ffffff;
        --gray-soft: #f8faf9;
    }

    body {
        font-family: 'Poppins', sans-serif;
    }

    /* ================= NAVBAR ================= */
    .lesgo-navbar {
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-bottom: 1px solid rgba(47, 72, 88, 0.08);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        padding: 12px 0;
        transition: all 0.3s ease;
    }

    /* Logo Image Styling */
    .lesgo-navbar .logo-img {
        height: 38px;
        width: auto;
        object-fit: contain;
        border-radius: 8px;
        transition: transform 0.2s ease;
    }

    .lesgo-navbar .navbar-brand:hover .logo-img {
        transform: scale(1.03);
    }

    /* ================= NAV MENU (CENTERED) ================= */
    .lesgo-nav-list {
        background: rgba(240, 246, 245, 0.75);
        padding: 4px 10px;
        border-radius: 40px;
        border: 1px solid rgba(122, 204, 194, 0.25);
    }

    .lesgo-link {
        color: var(--dark) !important;
        font-weight: 500;
        font-size: 0.95rem;
        padding: 8px 18px !important;
        border-radius: 30px;
        transition: all 0.25s ease;
        position: relative;
    }

    .lesgo-link:hover {
        color: var(--dark) !important;
        background: rgba(122, 204, 194, 0.2);
    }

    .lesgo-link.active {
        background: var(--primary);
        color: #ffffff !important;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(122, 204, 194, 0.4);
    }

    /* ================= PROFILE & GUEST BUTTONS ================= */
    .btn-login {
        background: transparent;
        border: 1.5px solid var(--primary);
        color: var(--dark);
        border-radius: 30px;
        padding: 7px 20px;
        font-size: 0.9rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-login:hover {
        background: var(--primary);
        color: white;
        box-shadow: 0 4px 12px rgba(122, 204, 194, 0.3);
    }

    .btn-register {
        background: var(--accent);
        color: white;
        border: 1.5px solid var(--accent);
        border-radius: 30px;
        padding: 7px 20px;
        font-size: 0.9rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-register:hover {
        background: #f2847b;
        border-color: #f2847b;
        color: white;
        box-shadow: 0 4px 12px rgba(255, 166, 158, 0.3);
    }

    /* Profile Pill Button */
    .profile-pill {
        background: #ffffff;
        border: 1px solid rgba(122, 204, 194, 0.4);
        padding: 4px 14px 4px 6px;
        border-radius: 30px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
        transition: all 0.25s ease;
        text-decoration: none;
        color: var(--dark) !important;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .profile-pill:hover,
    .profile-pill[aria-expanded="true"] {
        background: var(--primary-light);
        border-color: var(--primary);
        box-shadow: 0 4px 14px rgba(122, 204, 194, 0.25);
    }

    .profile-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--primary);
    }

    .profile-name {
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--dark);
        max-width: 120px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Profile Dropdown Menu */
    .dropdown-menu-custom {
        border-radius: 18px;
        border: 1px solid rgba(122, 204, 194, 0.25);
        box-shadow: 0 10px 30px rgba(47, 72, 88, 0.12);
        padding: 12px;
        min-width: 240px;
        margin-top: 10px !important;
        animation: fadeIn 0.2s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-8px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .dropdown-header-custom {
        padding: 8px 12px 12px 12px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.06);
        margin-bottom: 8px;
    }

    .dropdown-header-name {
        font-weight: 700;
        color: var(--dark);
        font-size: 0.95rem;
    }

    .dropdown-header-email {
        font-size: 0.8rem;
        color: #7b8b94;
    }

    .dropdown-item-custom {
        padding: 9px 14px;
        border-radius: 12px;
        color: var(--dark);
        font-weight: 500;
        font-size: 0.88rem;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: all 0.2s ease;
    }

    .dropdown-item-custom:hover {
        background: var(--primary-light);
        color: var(--dark);
        transform: translateX(3px);
    }

    .dropdown-item-custom.text-danger:hover {
        background: #fff1f0;
        color: #dc3545;
    }

    .role-badge {
        font-size: 0.7rem;
        padding: 2px 8px;
        border-radius: 10px;
        background: var(--primary);
        color: white;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
</style>

<nav class="navbar navbar-expand-lg lesgo-navbar fixed-top">
    <div class="container">
        <!-- BRAND / LOGO -->
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
            <img src="{{ asset('images/logo.jpg') }}" alt="LesGo Logo" class="logo-img" />
        </a>

        <!-- MOBILE TOGGLER -->
        <button class="navbar-toggler border-0 shadow-none p-2"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#lesgoNavbarContent"
                aria-controls="lesgoNavbarContent"
                aria-expanded="false"
                aria-label="Toggle navigation">
            <i class="bi bi-list fs-2 text-dark"></i>
        </button>

        <!-- NAVBAR COLLAPSE CONTENT -->
        <div class="collapse navbar-collapse" id="lesgoNavbarContent">
            <!-- CENTERED NAV ITEMS -->
            <div class="mx-auto my-3 my-lg-0">
                <ul class="navbar-nav lesgo-nav-list align-items-center gap-1">
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link lesgo-link {{ request()->routeIs('home') ? 'active' : '' }}">
                            <i class="bi bi-house-door me-1 d-lg-none"></i> Beranda
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('bimbel.guest') }}" class="nav-link lesgo-link {{ request()->routeIs('bimbel.guest') ? 'active' : '' }}">
                            <i class="bi bi-building me-1 d-lg-none"></i> Cari Bimbel
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('mapel.guest') }}" class="nav-link lesgo-link {{ request()->routeIs('mapel.guest') ? 'active' : '' }}">
                            <i class="bi bi-book-half me-1 d-lg-none"></i> Mata Pelajaran
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('pesanan') }}" class="nav-link lesgo-link {{ request()->routeIs('pesanan') ? 'active' : '' }}">
                            <i class="bi bi-bag-check me-1 d-lg-none"></i> Pesanan
                        </a>
                    </li>
                </ul>
            </div>

            <!-- RIGHT ACTION / USER PROFILE -->
            <div class="d-flex align-items-center gap-2 mt-3 mt-lg-0 justify-content-center justify-content-lg-end">
                @guest
                    <a href="{{ route('login') }}" class="btn btn-login">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-register">
                        Daftar
                    </a>
                @endguest

                @auth
                    @php
                        $user = Auth::user();
                        $userAvatar = $user->photo 
                            ? (str_starts_with($user->photo, 'http') ? $user->photo : asset('storage/' . $user->photo))
                            : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=7ACCC2&color=FFFFFF&bold=true';
                    @endphp

                    <div class="dropdown">
                        <a href="#" 
                           class="profile-pill dropdown-toggle" 
                           id="profileDropdown" 
                           role="button" 
                           data-bs-toggle="dropdown" 
                           aria-expanded="false">
                            <img src="{{ $userAvatar }}" alt="{{ $user->name }}" class="profile-avatar">
                            <span class="profile-name d-none d-sm-inline">{{ $user->name }}</span>
                            <i class="bi bi-chevron-down ms-1 text-muted fs-7"></i>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom border-0" aria-labelledby="profileDropdown">
                            <div class="dropdown-header-custom">
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <div class="dropdown-header-name">{{ $user->name }}</div>
                                    <span class="role-badge">{{ $user->role ?? 'User' }}</span>
                                </div>
                                <div class="dropdown-header-email">{{ $user->email }}</div>
                            </div>

                            @if(($user->role ?? 'user') === 'admin')
                                <li>
                                    <a class="dropdown-item dropdown-item-custom" href="{{ route('admin.dashboard') }}">
                                        <i class="bi bi-speedometer2 text-primary fs-6"></i>
                                        <span>Dashboard Admin</span>
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider opacity-50 my-1"></li>
                            @endif

                            <li>
                                <a class="dropdown-item dropdown-item-custom" href="{{ route('user.settings') }}">
                                    <i class="bi bi-gear fs-6" style="color: #7ACCC2;"></i>
                                    <span>Pengaturan Akun</span>
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item dropdown-item-custom" href="{{ route('bimbeluser.index') }}">
                                    <i class="bi bi-journal-bookmark fs-6" style="color: #FFA69E;"></i>
                                    <span>Kelola Bimbel</span>
                                </a>
                            </li>

                            <li><hr class="dropdown-divider opacity-50 my-1"></li>

                            <li>
                                <a class="dropdown-item dropdown-item-custom text-danger" href="{{ route('logout') }}">
                                    <i class="bi bi-box-arrow-right fs-6"></i>
                                    <span>Keluar / Logout</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>
