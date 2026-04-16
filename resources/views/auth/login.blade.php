<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login – MPL PWL</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #0a0a0f; color: #e2e8f0; }
        .gradient-text { background: linear-gradient(135deg, #6366f1, #a855f7); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .card-glass {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            backdrop-filter: blur(12px);
        }
        .input-field {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            color: #e2e8f0;
            transition: border-color .2s, background .2s;
        }
        .input-field:focus {
            outline: none;
            border-color: #a855f7;
            background: rgba(168,85,247,0.05);
        }
        .input-field::placeholder { color: #64748b; }
        .btn-primary {
            background: linear-gradient(135deg, #6366f1, #a855f7);
            transition: opacity .2s, transform .1s;
        }
        .btn-primary:hover { opacity: .9; transform: translateY(-1px); }
        .btn-primary:active { transform: translateY(0); }
        .glow { box-shadow: 0 0 40px rgba(168,85,247,0.15); }
    </style>
</head>
<body class="min-h-screen flex flex-col">

    {{-- Navbar minimal --}}
    <nav class="border-b border-white/10" style="background:rgba(10,10,15,0.9)">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="{{ route('home') }}" class="text-xl font-black gradient-text tracking-widest">MPL PWL</a>
            <a href="{{ route('home') }}" class="text-slate-400 hover:text-slate-200 text-sm transition">
                <i class="fa fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>
    </nav>

    {{-- Main --}}
    <main class="flex-1 flex items-center justify-center px-4 py-16">
        <div class="w-full max-w-md">

            {{-- Header --}}
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl mb-4"
                     style="background: linear-gradient(135deg,#6366f1,#a855f7)">
                    <i class="fa fa-gamepad text-2xl text-white"></i>
                </div>
                <h1 class="text-3xl font-black gradient-text">Masuk</h1>
                <p class="text-slate-400 text-sm mt-1">Login ke akun MPL PWL kamu</p>
            </div>

            {{-- Alert error --}}
            @if ($errors->any())
                <div class="mb-4 bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-xl text-sm">
                    <i class="fa fa-circle-exclamation mr-2"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Flash success --}}
            @if (session('success'))
                <div class="mb-4 bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-xl text-sm">
                    <i class="fa fa-check mr-2"></i> {{ session('success') }}
                </div>
            @endif

            {{-- Card --}}
            <div class="card-glass rounded-2xl p-8 glow">
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1.5">
                            Email
                        </label>
                        <div class="relative">
                            <i class="fa fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 text-sm"></i>
                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="nama@email.com"
                                required autofocus
                                class="input-field w-full rounded-xl px-4 py-2.5 pl-10 text-sm @error('email') border-red-500/50 @enderror"
                            >
                        </div>
                        @error('email')
                            <p class="text-red-400 text-xs mt-1"><i class="fa fa-triangle-exclamation mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1.5">
                            Password
                        </label>
                        <div class="relative">
                            <i class="fa fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 text-sm"></i>
                            <input
                                type="password"
                                name="password"
                                id="passwordInput"
                                placeholder="••••••••"
                                required
                                class="input-field w-full rounded-xl px-4 py-2.5 pl-10 pr-10 text-sm @error('password') border-red-500/50 @enderror"
                            >
                            <button type="button" onclick="togglePassword()"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-300 transition text-sm">
                                <i class="fa fa-eye" id="eyeIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-red-400 text-xs mt-1"><i class="fa fa-triangle-exclamation mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Remember me --}}
                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember"
                            class="w-4 h-4 rounded border-white/20 bg-white/5 text-purple-500 focus:ring-purple-500/50">
                        <label for="remember" class="ml-2 text-sm text-slate-400">Ingat saya</label>
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="btn-primary w-full py-2.5 rounded-xl font-semibold text-white text-sm tracking-wide">
                        <i class="fa fa-right-to-bracket mr-2"></i>Masuk
                    </button>
                </form>

                {{-- Divider --}}
                <div class="flex items-center gap-3 my-5">
                    <div class="flex-1 h-px bg-white/10"></div>
                    <span class="text-slate-600 text-xs">atau</span>
                    <div class="flex-1 h-px bg-white/10"></div>
                </div>

                {{-- Register link --}}
                <p class="text-center text-sm text-slate-400">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-purple-400 hover:text-purple-300 font-medium transition">
                        Daftar sekarang
                    </a>
                </p>
            </div>
        </div>
    </main>

    <script>
        function togglePassword() {
            const input = document.getElementById('passwordInput');
            const icon  = document.getElementById('eyeIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</body>
</html>
