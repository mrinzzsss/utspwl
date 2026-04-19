<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — MPL Lite</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --mpl-blue: #0f2b5b;
            --mpl-gold: #f5a623;
            --mpl-dark: #0a1a38;
        }
        body {
            background: linear-gradient(135deg, var(--mpl-dark) 0%, #1e3a8a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }
        .login-wrapper {
            width: 100%;
            max-width: 420px;
        }
        .login-card {
            background: #fff;
            border-radius: 20px;
            padding: 2.5rem 2rem;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .login-logo {
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--mpl-blue);
            letter-spacing: -1px;
        }
        .login-logo span { color: var(--mpl-gold); }
        .login-subtitle { color: #64748b; font-size: .9rem; }
        .form-control {
            border-radius: 10px;
            padding: .65rem 1rem;
            border: 1.5px solid #e2e8f0;
            font-size: .95rem;
        }
        .form-control:focus {
            border-color: var(--mpl-blue);
            box-shadow: 0 0 0 3px rgba(15,43,91,.15);
        }
        .input-group-text {
            border-radius: 10px 0 0 10px;
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-right: 0;
            color: #64748b;
        }
        .input-group .form-control { border-radius: 0 10px 10px 0; border-left: 0; }
        .btn-login {
            background: var(--mpl-blue);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: .75rem;
            font-weight: 600;
            font-size: 1rem;
            width: 100%;
            transition: background .2s;
        }
        .btn-login:hover { background: var(--mpl-dark); color: #fff; }
        .divider { border-color: #e2e8f0; }
        .demo-card {
            background: #f8fafc;
            border-radius: 10px;
            padding: 1rem;
            font-size: .82rem;
            color: #475569;
        }
        .demo-card strong { color: var(--mpl-blue); }
    </style>
</head>
<body>
<div class="login-wrapper">
    <div class="login-card">
        {{-- Logo --}}
        <div class="text-center mb-4">
            <div class="login-logo">
                <i class="bi bi-trophy-fill" style="color: var(--mpl-gold)"></i>
                MPL <span>LITE</span>
            </div>
            <p class="login-subtitle mt-1">Mobile Legends Professional League</p>
        </div>

        {{-- Alert errors --}}
        @if($errors->any())
            <div class="alert alert-danger py-2 rounded-3" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-1"></i>
                {{ $errors->first('email') }}
            </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('login.post') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold small text-secondary">Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        placeholder="email@domain.com" value="{{ old('email') }}" required autofocus>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold small text-secondary">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" name="password" id="passwordInput"
                        class="form-control" placeholder="••••••••" required>
                    <button type="button" class="btn btn-outline-secondary border-start-0"
                        onclick="togglePassword()" style="border-radius: 0 10px 10px 0; border-color: #e2e8f0;">
                        <i class="bi bi-eye" id="eyeIcon"></i>
                    </button>
                </div>
            </div>

            <div class="mb-4 d-flex align-items-center justify-content-between">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label small" for="remember">Ingat saya</label>
                </div>
            </div>

            <button type="submit" class="btn btn-login">
                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
            </button>
        </form>

        <hr class="divider my-4">

        {{-- Demo credentials --}}
        <div class="demo-card">
            <div class="fw-semibold mb-2" style="color: var(--mpl-blue);">
                <i class="bi bi-info-circle me-1"></i>Akun Demo
            </div>
            <div class="row g-1">
                <div class="col-12">
                    <strong>Manajemen:</strong> manajemen@mpl.id / password
                </div>
                <div class="col-12">
                    <strong>Wasit:</strong> wasit1@mpl.id / password
                </div>
                <div class="col-12">
                    <strong>Player:</strong> r7@mpl.id / password
                </div>
            </div>
        </div>

        <div class="text-center mt-3">
            <a href="{{ route('home') }}" class="text-secondary small">
                <i class="bi bi-arrow-left me-1"></i>Kembali ke beranda
            </a>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const input = document.getElementById('passwordInput');
    const icon  = document.getElementById('eyeIcon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('bi-eye', 'bi-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('bi-eye-slash', 'bi-eye');
    }
}
</script>
</body>
</html>
