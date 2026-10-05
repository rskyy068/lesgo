<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LesGo - Admin Panel')</title>

    {{-- Google Fonts - Poppins --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Bootstrap 5.3.3 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --bg-main: #f3f7f6;
            --sidebar-left: #A8D5D2;
            --card-bg: #FFFFFF;
            --sidebar-right: #DDEFEA;
            --accent: #FF9980;
            --dark: #2F4858;
            --dark-muted: #5a7684;
            --white: #FFFFFF;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --shadow-sm: 0 4px 6px -1px rgba(47, 72, 88, 0.05), 0 2px 4px -1px rgba(47, 72, 88, 0.03);
            --shadow-md: 0 10px 15px -3px rgba(47, 72, 88, 0.07), 0 4px 6px -2px rgba(47, 72, 88, 0.03);
            --shadow-lg: 0 20px 25px -5px rgba(47, 72, 88, 0.1), 0 10px 10px -5px rgba(47, 72, 88, 0.04);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-main);
            color: var(--dark);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Layout Grid */
        .admin-layout {
            display: flex;
            min-height: 100vh;
            position: relative;
        }

        /* Sidebar Kiri */
        .sidebar-left {
            width: 260px;
            background-color: var(--sidebar-left);
            color: var(--dark);
            display: flex;
            flex-direction: column;
            padding: 24px 16px;
            transition: var(--transition);
            z-index: 100;
            box-shadow: 4px 0 20px rgba(47, 72, 88, 0.05);
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
        }

        .sidebar-brand {
            font-size: 26px;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: var(--dark);
            text-decoration: none;
            padding: 8px 12px;
            margin-bottom: 32px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-brand span {
            color: var(--white);
            background-color: var(--accent);
            padding: 2px 10px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            box-shadow: 0 4px 10px rgba(255, 166, 158, 0.3);
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 8px;
            flex-grow: 1;
        }

        .menu-item {
            width: 100%;
        }

        .menu-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: var(--dark);
            text-decoration: none;
            font-weight: 500;
            font-size: 15px;
            border-radius: 12px;
            transition: var(--transition);
        }

        .menu-link i {
            font-size: 18px;
            transition: var(--transition);
        }

        .menu-link:hover {
            background-color: rgba(255, 255, 255, 0.3);
            color: var(--dark);
            transform: translateX(4px);
        }

        .menu-item.active .menu-link {
            background-color: var(--accent);
            color: var(--white);
            font-weight: 600;
            box-shadow: 0 6px 15px rgba(255, 166, 158, 0.4);
        }

        .menu-item.active .menu-link i {
            color: var(--white);
        }

        .menu-link-logout {
            margin-top: auto;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
        }

        .menu-link-logout:hover {
            background-color: rgba(255, 255, 255, 0.3);
            color: #dc3545 !important;
        }

        /* Area Utama */
        .main-wrapper {
            flex-grow: 1;
            margin-left: 260px;
            margin-right: 320px;
            min-height: 100vh;
            padding: 32px;
            transition: var(--transition);
        }

        /* Sidebar Kanan */
        .sidebar-right {
            width: 320px;
            background-color: var(--sidebar-right);
            border-left: 1px solid rgba(147, 225, 216, 0.2);
            padding: 32px 24px;
            transition: var(--transition);
            z-index: 99;
            box-shadow: -4px 0 20px rgba(47, 72, 88, 0.02);
            position: fixed;
            top: 0;
            bottom: 0;
            right: 0;
            overflow-y: auto;
        }

        /* Custom Scrollbar untuk Sidebar Kanan */
        .sidebar-right::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-right::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-right::-webkit-scrollbar-thumb {
            background: rgba(147, 225, 216, 0.5);
            border-radius: 10px;
        }

        .sidebar-right::-webkit-scrollbar-thumb:hover {
            background: var(--accent);
        }

        /* Header Ponsel */
        .mobile-header {
            display: none;
            background-color: var(--sidebar-left);
            padding: 12px 20px;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1010;
            box-shadow: 0 4px 10px rgba(47, 72, 88, 0.05);
        }

        .mobile-brand {
            font-size: 20px;
            font-weight: 800;
            color: var(--dark);
            text-decoration: none;
        }

        .mobile-brand span {
            color: var(--white);
            background-color: var(--accent);
            padding: 1px 6px;
            border-radius: 8px;
            font-size: 13px;
        }

        .btn-toggle-sidebar {
            background: none;
            border: none;
            font-size: 24px;
            color: var(--dark);
            cursor: pointer;
            padding: 4px;
            display: flex;
            align-items: center;
        }

        /* Responsive styling */
        @media (max-width: 1200px) {
            .sidebar-right {
                transform: translateX(100%);
            }
            .sidebar-right.show {
                transform: translateX(0);
            }
            .main-wrapper {
                margin-right: 0;
            }
            .btn-toggle-right-sidebar {
                display: flex !important;
            }
        }

        @media (max-width: 991.98px) {
            .sidebar-left {
                transform: translateX(-100%);
            }
            .sidebar-left.show {
                transform: translateX(0);
            }
            .main-wrapper {
                margin-left: 0;
                padding: 20px;
                padding-top: 32px;
            }
            .mobile-header {
                display: flex;
            }
        }

        /* Overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(47, 72, 88, 0.4);
            backdrop-filter: blur(4px);
            z-index: 90;
            transition: var(--transition);
        }

        .sidebar-overlay.show {
            display: block;
        }
        
        /* Modern Cards */
        .main-card {
            background-color: var(--card-bg);
            border-radius: 20px;
            border: 1px solid rgba(147, 225, 216, 0.15);
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
        }

        .main-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }

        /* Accent Badge / Highlights */
        .bg-accent-light {
            background-color: rgba(255, 166, 158, 0.15);
            color: #d87e76;
        }

        .bg-primary-light {
            background-color: rgba(147, 225, 216, 0.15);
            color: #55a096;
        }
    </style>
    @stack('style')
</head>
<body>

    <!-- Mobile Header -->
    <header class="mobile-header">
        <button class="btn-toggle-sidebar" id="toggle-left-sidebar" aria-label="Buka Menu Navigasi">
            <i class="bi bi-list"></i>
        </button>
        <a href="#" class="mobile-brand">Les<span>Go</span></a>
        <button class="btn-toggle-sidebar" id="toggle-right-sidebar" aria-label="Buka Profil & Utilitas" style="display: none;">
            <i class="bi bi-person-circle"></i>
        </button>
    </header>

    <!-- Overlay -->
    <div class="sidebar-overlay" id="sidebar-overlay"></div>

    <div class="admin-layout">
        <!-- Sidebar Kiri -->
        <aside class="sidebar-left" id="sidebar-left">
            <a href="{{ route('home') }}" class="sidebar-brand">
                LES<span>GO</span>
            </a>

            <ul class="sidebar-menu">
                <li class="menu-item {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class="menu-link">
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="menu-item {{ Route::is('admin.pendaftaran-bimbel.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.pendaftaran-bimbel.index') }}" class="menu-link">
                        <i class="bi bi-card-checklist"></i>
                        <span>Pendaftaran & Token</span>
                    </a>
                </li>
                <li class="menu-item {{ Route::is('admin.bimbel.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.bimbel.index') }}" class="menu-link">
                        <i class="bi bi-mortarboard-fill"></i>
                        <span>Bimbel</span>
                    </a>
                </li>
                <li class="menu-item {{ Route::is('admin.mapel.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.mapel.index') }}" class="menu-link">
                        <i class="bi bi-book-fill"></i>
                        <span>Mata Pel.</span>
                    </a>
                </li>
                <li class="menu-item {{ Route::is('admin.users.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.users.index') }}" class="menu-link">
                        <i class="bi bi-people-fill"></i>
                        <span>User</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <i class="bi bi-chat-left-heart-fill"></i>
                        <span>Review</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <i class="bi bi-gear-fill"></i>
                        <span>Pengaturan</span>
                    </a>
                </li>
                
                <li class="menu-item menu-link-logout">
                    <form action="{{ route('logout') }}" method="POST" id="logout-form" class="d-none">
                        @csrf
                    </form>
                    <a href="{{ route('logout') }}" class="menu-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Area Utama (Main Content) -->
        <main class="main-wrapper">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert" style="background-color: #d2f4ea; color: #0f5132;">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert" style="background-color: #f8d7da; color: #842029;">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Sidebar Kanan -->
        <aside class="sidebar-right" id="sidebar-right">
            <h5 class="fw-bold mb-4">Recent Activity</h5>

            @forelse(($activities ?? []) as $activity)
                <div class="main-card p-3 mb-3">
                    <div class="d-flex">
                        <div class="me-3">
                            <i class="bi bi-clock-history fs-4 text-primary"></i>
                        </div>
                        <div>
                            <div class="fw-semibold">{{ $activity->causer?->name ?? 'System' }}</div>
                            <small class="text-muted">{{ $activity->description }}</small><br>
                            <small class="text-secondary">{{ $activity->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center text-muted mt-5">
                    <i class="bi bi-clock-history fs-1"></i>
                    <p class="mt-3">Belum ada aktivitas.</p>
                </div>
            @endforelse
        </aside>

        
    </div>

    {{-- Bootstrap 5.3.3 Bundle --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Toggle sidebars on mobile/tablet
        const toggleLeft = document.getElementById('toggle-left-sidebar');
        const toggleRight = document.getElementById('toggle-right-sidebar');
        const sidebarLeft = document.getElementById('sidebar-left');
        const sidebarRight = document.getElementById('sidebar-right');
        const overlay = document.getElementById('sidebar-overlay');

        if(toggleLeft) {
            toggleLeft.addEventListener('click', () => {
                sidebarLeft.classList.toggle('show');
                overlay.classList.toggle('show');
            });
        }

        if(toggleRight) {
            // Check if right sidebar toggle needs to be shown based on viewport
            const checkRightToggle = () => {
                if (window.innerWidth <= 1200) {
                    toggleRight.style.display = 'flex';
                } else {
                    toggleRight.style.display = 'none';
                }
            };
            
            window.addEventListener('resize', checkRightToggle);
            checkRightToggle();

            toggleRight.addEventListener('click', () => {
                sidebarRight.classList.toggle('show');
                overlay.classList.toggle('show');
            });
        }

        if(overlay) {
            overlay.addEventListener('click', () => {
                sidebarLeft.classList.remove('show');
                sidebarRight.classList.remove('remove'); // Reset if needed
                sidebarRight.classList.remove('show');
                overlay.classList.remove('show');
            });
        }
    </script>
    @stack('script')
</body>
</html>
