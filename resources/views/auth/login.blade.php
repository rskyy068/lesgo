<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - LesGo</title>

    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        :root {
            --primary: #93E1D8;
            --secondary: #DDFFF7;
            --accent: #FFA69E;
            --dark: #2F4858;
            --bg: #F6FFFD;
            --white: #FFFFFF;
            --text-muted: #6b8594;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg);
            color: var(--dark);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Layouting */
        .split-layout {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }

        /* ----- PERUBAHAN DI SINI: CSS SIDE LEFT (GAMBAR) ----- */
        .side-left {
            /* Ganti URL di bawah ini dengan gambar dari asset Laravel Anda: url('{{ asset('images/login-bg.jpg') }}') */
            background: url('{{ asset('images/login_bg.jpg') }}') center/cover no-repeat;
            position: relative;
            overflow: hidden;
            padding: 0;
        }

        /* Overlay tipis agar gambar senada dengan tema warna LesGo */
        .side-left::before {
            content: '';
            position: absolute;
            top: 0; right: 0; bottom: 0; left: 0;
            /*background: linear-gradient(135deg, rgba(147, 225, 216, 0.4), rgba(47, 72, 88, 0.5));*/
            z-index: 1;
        }
        /* ----------------------------------------------------- */

        .side-right {
            background-color: var(--bg);
            padding: 40px 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        /* Desktop & Tablet Breakpoints */
        @media (min-width: 768px) {
            .side-left {
                min-height: 50vh;
            }
            .side-right {
                min-height: 50vh;
                padding: 60px;
            }
        }

        @media (min-width: 992px) {
            .split-layout {
                flex-direction: row;
            }
            .side-left {
                width: 45%;
                min-height: 100vh;
                position: fixed;
                top: 0;
                left: 0;
                bottom: 0;
            }
            .side-right {
                width: 55%;
                min-height: 100vh;
                margin-left: 45%;
            }
        }

        /* Right Side Login Card */
        .login-card {
            width: 100%;
            max-width: 430px;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.8s ease-out;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 50px -10px rgba(47, 72, 88, 0.12);
        }

        .card-header-text {
            text-align: center;
            margin-bottom: 32px;
        }
        .card-header-text .brand {
            font-size: 28px;
            font-weight: 700;
            color: var(--dark);
            text-decoration: none;
            display: inline-block;
            margin-bottom: 24px;
        }
        .card-header-text .brand span {
            color: var(--white);
            background: var(--dark);
            padding: 4px 12px;
            border-radius: 8px;
            margin-left: 4px;
        }
        .card-header-text h2 {
            font-size: 24px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 8px;
        }
        .card-header-text p {
            color: var(--text-muted);
            font-size: 14px;
            margin: 0;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 20px;
            position: relative;
        }
        .form-label {
            font-size: 14px;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
        }
        .input-wrapper .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #9baab5;
            font-size: 18px;
            transition: color 0.3s ease;
            pointer-events: none;
        }

        .form-control-custom {
            width: 100%;
            padding: 14px 16px 14px 48px;
            font-size: 14px;
            border-radius: 16px;
            border: 2px solid #e2e8ec;
            background-color: var(--white);
            color: var(--dark);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            outline: none;
        }

        .form-control-custom:hover {
            border-color: #c9d6df;
        }

        .form-control-custom:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(147, 225, 216, 0.25);
        }

        .input-wrapper:focus-within .input-icon {
            color: var(--primary);
        }

        .form-control-custom.is-invalid {
            border-color: var(--accent);
        }
        .form-control-custom.is-invalid:focus {
            box-shadow: 0 0 0 4px rgba(255, 166, 158, 0.25);
        }

        /* Password Toggle */
        .toggle-password {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #9baab5;
            cursor: pointer;
            font-size: 18px;
            padding: 0;
            transition: color 0.3s ease;
        }
        .toggle-password:hover {
            color: var(--dark);
        }

        /* Checkbox & Links */
        .form-check-input {
            border: 2px solid #e2e8ec;
            border-radius: 6px;
            cursor: pointer;
            width: 18px;
            height: 18px;
            margin-top: 2px;
        }
        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        .form-check-input:focus {
            box-shadow: 0 0 0 4px rgba(147, 225, 216, 0.25);
        }
        .form-check-label {
            font-size: 13.5px;
            color: var(--text-muted);
            cursor: pointer;
            padding-top: 2px;
        }

        .forgot-link {
            font-size: 13.5px;
            font-weight: 600;
            color: var(--accent);
            text-decoration: none;
            transition: opacity 0.3s ease;
        }
        .forgot-link:hover {
            opacity: 0.8;
        }

        /* Button */
        .btn-submit {
            background-color: var(--primary);
            color: var(--dark);
            font-weight: 600;
            font-size: 15px;
            padding: 14px;
            border-radius: 16px;
            border: none;
            width: 100%;
            transition: all 0.3s ease;
            margin-top: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-submit:hover {
            background-color: var(--accent);
            color: var(--white);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(255, 166, 158, 0.3);
        }

        /* Register Link */
        .register-text {
            text-align: center;
            margin-top: 24px;
            font-size: 14px;
            color: var(--text-muted);
        }
        .register-text a {
            color: var(--dark);
            font-weight: 600;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .register-text a:hover {
            color: var(--primary);
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    <div class="split-layout">

        <!-- KIRI (Hanya Gambar & Overlay) -->
        <!-- Karena menggunakan d-none d-md-block, gambar tetap sembunyi di HP -->
        <div class="side-left d-none d-md-block">
            <!-- Konten dikosongkan. Gambar dipanggil lewat class CSS .side-left -->
        </div>

        <!-- KANAN (Form Login) -->
        <div class="side-right">
            <div class="login-card">

                <!-- resources/views/auth/login.blade.php (lines 328‑332) -->
                <div class="card-header-text">
                    <!-- Logo now appears in the center of the login form -->
                    <a href="{{ route('home') ?? url('/') }}" class="brand">
                        <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="logo-img" style="height:100px;" />
                    </a>

                    <h2>Selamat Datang Kembali</h2>
                    <p>Masuk untuk melanjutkan.</p>
                </div>


                <!-- Alert Messages -->
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show rounded-4 small border-0" role="alert" style="background-color: #ffe5e3; color: #d63327;">
                        <i class="bi bi-exclamation-octagon-fill me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show rounded-4 small border-0" role="alert" style="background-color: #e5f9f6; color: #1f8576;">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST">
                    @csrf

                    <!-- Email Input -->
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-wrapper">
                            <i class="bi bi-envelope input-icon"></i>
                            <input type="email"
                                   id="email"
                                   name="email"
                                   placeholder="email"
                                   class="form-control-custom @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}"
                                   required
                                   autofocus>
                        </div>
                        @error('email')
                            <div class="text-danger small mt-2 fw-medium">
                                <i class="bi bi-info-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Password Input -->
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-wrapper">
                            <i class="bi bi-lock input-icon"></i>
                            <input type="password"
                                   id="password"
                                   name="password"
                                   placeholder="password"
                                   class="form-control-custom @error('password') is-invalid @enderror"
                                   required>
                            <button type="button" class="toggle-password" onclick="togglePassword()" tabindex="-1">
                                <i class="bi bi-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="text-danger small mt-2 fw-medium">
                                <i class="bi bi-info-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check d-flex align-items-center gap-2">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                Remember Me
                            </label>
                        </div>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-link">
                                Lupa Password?
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-submit">
                        Login <i class="bi bi-arrow-right"></i>
                    </button>
                </form>

                <!-- Register Link -->
                <div class="register-text">
                    Belum punya akun?
                    @if(Route::has('register'))
                        <a href="{{ route('register') }}">Daftar di sini</a>
                    @else
                        <a href="#">Daftar di sini</a>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Scripts -->
    <script>
        // Script for Toggle Password Visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('bi-eye');
                toggleIcon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('bi-eye-slash');
                toggleIcon.classList.add('bi-eye');
            }
        }
    </script>
</body>
</html>
