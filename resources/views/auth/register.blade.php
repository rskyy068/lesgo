<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - LesGo</title>
    
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

        .side-left {
            background: url("{{ asset('images/login_bg.jpg') }}") center/cover no-repeat;
            position: relative;
            overflow: hidden;
            padding: 0;
        }

        .side-left::before {
            content: '';
            position: absolute;
            top: 0; right: 0; bottom: 0; left: 0;
            background: linear-gradient(135deg, rgba(147, 225, 216, 0.2), rgba(47, 72, 88, 0.4));
            z-index: 1;
        }

        .side-right {
            background-color: var(--bg);
            padding: 40px 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        /* Responsive Breakpoints */
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

        /* Auth Card */
        .auth-card {
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
        
        .auth-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 50px -10px rgba(47, 72, 88, 0.12);
        }

        .auth-header {
            text-align: center;
            margin-bottom: 28px;
        }
        
        .auth-brand {
            font-size: 28px;
            font-weight: 700;
            color: var(--dark);
            text-decoration: none;
            display: inline-block;
            margin-bottom: 16px;
        }
        
        .auth-brand span {
            color: var(--white);
            background: var(--dark);
            padding: 2px 10px;
            border-radius: 8px;
            margin-left: 2px;
        }
        
        .auth-title {
            font-size: 22px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 6px;
        }
        
        .auth-subtitle {
            color: var(--text-muted);
            font-size: 14px;
            margin: 0;
        }

        /* Form Styles */
        .form-group-custom {
            margin-bottom: 18px;
            position: relative;
        }
        
        .form-label-custom {
            font-size: 13.5px;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 6px;
            display: block;
        }
        
        .input-icon-wrapper {
            position: relative;
        }
        
        .input-icon-wrapper .input-icon {
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
            padding: 12px 48px 12px 48px;
            font-size: 14px;
            border-radius: 14px;
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

        .input-icon-wrapper:focus-within .input-icon {
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
            font-size: 13px;
            color: var(--text-muted);
            cursor: pointer;
        }

        /* Button */
        .btn-auth-primary {
            background-color: var(--primary);
            color: var(--dark);
            font-weight: 600;
            font-size: 15px;
            padding: 12px;
            border-radius: 14px;
            border: none;
            width: 100%;
            transition: all 0.3s ease;
            margin-top: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn-auth-primary:hover {
            background-color: var(--accent);
            color: var(--white);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(255, 166, 158, 0.3);
        }

        /* Footer Link */
        .auth-footer-link {
            text-align: center;
            margin-top: 20px;
            font-size: 13.5px;
            color: var(--text-muted);
        }
        
        .auth-footer-link a {
            color: var(--dark);
            font-weight: 600;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .auth-footer-link a:hover {
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
        
        <!-- KIRI (Gambar) -->
        <div class="side-left d-none d-md-block"></div>

        <!-- KANAN (Form) -->
        <div class="side-right">
            <div class="auth-card">
                <div class="auth-header">
                    <a href="{{ route('home') ?? url('/') }}" class="brand">
                        <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="logo-img" style="height:100px;" />
                    </a>
                    <h1 class="auth-title">Buat Akun Baru</h1>
                    <p class="auth-subtitle">Isi data diri Anda untuk mendaftar</p>
                </div>

                <form action="{{ route('register') }}" method="POST">
                    @csrf

                    <!-- Full Name -->
                    <div class="form-group-custom">
                        <label for="name" class="form-label-custom">Nama Lengkap</label>
                        <div class="input-icon-wrapper">
                            <input type="text"
                                   id="name"
                                   name="name"
                                   class="form-control-custom @error('name') is-invalid @enderror"
                                   placeholder="Nama lengkap Anda"
                                   value="{{ old('name') }}"
                                   required
                                   autofocus>
                            <i class="bi bi-person input-icon"></i>
                        </div>
                        @error('name')
                            <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-group-custom">
                        <label for="email" class="form-label-custom">Email</label>
                        <div class="input-icon-wrapper">
                            <input type="email"
                                   id="email"
                                   name="email"
                                   class="form-control-custom @error('email') is-invalid @enderror"
                                   placeholder="nama@email.com"
                                   value="{{ old('email') }}"
                                   required>
                            <i class="bi bi-envelope input-icon"></i>
                        </div>
                        @error('email')
                            <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Phone Number -->
                    <div class="form-group-custom">
                        <label for="phone" class="form-label-custom">Nomor Telepon / WhatsApp</label>
                        <div class="input-icon-wrapper">
                            <input type="tel"
                                   id="phone"
                                   name="phone"
                                   class="form-control-custom @error('phone') is-invalid @enderror"
                                   placeholder="081234567890"
                                   value="{{ old('phone') }}">
                            <i class="bi bi-telephone input-icon"></i>
                        </div>
                        @error('phone')
                            <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group-custom">
                        <label for="password" class="form-label-custom">Kata Sandi</label>
                        <div class="input-icon-wrapper">
                            <input type="password"
                                   id="password"
                                   name="password"
                                   class="form-control-custom @error('password') is-invalid @enderror"
                                   placeholder="Minimal 8 karakter"
                                   required>
                            <i class="bi bi-lock input-icon"></i>
                            <button type="button" class="toggle-password" onclick="togglePassword('password', this)" aria-label="Tampilkan kata sandi">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password Confirmation -->
                    <div class="form-group-custom">
                        <label for="password_confirmation" class="form-label-custom">Konfirmasi Kata Sandi</label>
                        <div class="input-icon-wrapper">
                            <input type="password"
                                   id="password_confirmation"
                                   name="password_confirmation"
                                   class="form-control-custom"
                                   placeholder="Ulangi kata sandi"
                                   required>
                            <i class="bi bi-shield-lock input-icon"></i>
                            <button type="button" class="toggle-password" onclick="togglePassword('password_confirmation', this)" aria-label="Tampilkan kata sandi">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Terms Checkbox -->
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                        <label class="form-check-label" for="terms">
                            Saya menyetujui <a href="#" style="color: var(--accent);" class="text-decoration-none fw-semibold">Syarat & Ketentuan</a>.
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-auth-primary">
                        <i class="bi bi-person-plus me-2"></i> Daftar Sekarang
                    </button>
                </form>

                <div class="auth-footer-link">
                    Sudah punya akun? <a href="{{ route('login') }}">Masuk</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom Script -->
    <script>
        function togglePassword(inputId, btn) {
            const passwordInput = document.getElementById(inputId);
            const icon = btn.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }
    </script>
</body>
</html>