<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar – MPL PWL</title>
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
        .strength-bar { height: 4px; border-radius: 2px; transition: width .3s, background .3s; }
    </style>
</head>
<body class="min-h-screen flex flex-col">

    {{-- Navbar minimal --}}
    <nav class="border-b border-white/10" style="background:rgba(10,10,15,0.9)">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="{{ route('home') }}" class="text-xl font-black gradient-text tracking-widest">MPL PWL</a>
            <a href="{{ route('login') }}" class="text-slate-400 hover:text-slate-200 text-sm transition">
                <i class="fa fa-arrow-left mr-1"></i> Login
            </a>
        </div>
    </nav>

    {{-- Main --}}
    <main class="flex-1 flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">

            {{-- Header --}}
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl mb-4"
                     style="background: linear-gradient(135deg,#6366f1,#a855f7)">
                    <i class="fa fa-user-plus text-2xl text-white"></i>
                </div>
                <h1 class="text-3xl font-black gradient-text">Daftar</h1>
                <p class="text-slate-400 text-sm mt-1">Buat akun baru MPL PWL</p>
            </div>

            {{-- Alert error general --}}
            @if ($errors->any() && !$errors->has('name') && !$errors->has('email') && !$errors->has('password'))
                <div class="mb-4 bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-xl text-sm">
                    <i class="fa fa-circle-exclamation mr-2"></i>{{ $errors->first() }}
                </div>
            @endif

            {{-- Card --}}
            <div class="card-glass rounded-2xl p-8 glow">
                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    {{-- Nama --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1.5">Nama Lengkap</label>
                        <div class="relative">
                            <i class="fa fa-user absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 text-sm"></i>
                            <input
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="Nama kamu"
                                required autofocus
                                class="input-field w-full rounded-xl px-4 py-2.5 pl-10 text-sm @error('name') border-red-500/50 @enderror"
                            >
                        </div>
                        @error('name')
                            <p class="text-red-400 text-xs mt-1"><i class="fa fa-triangle-exclamation mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1.5">Email</label>
                        <div class="relative">
                            <i class="fa fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 text-sm"></i>
                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="nama@email.com"
                                required
                                class="input-field w-full rounded-xl px-4 py-2.5 pl-10 text-sm @error('email') border-red-500/50 @enderror"
                            >
                        </div>
                        @error('email')
                            <p class="text-red-400 text-xs mt-1"><i class="fa fa-triangle-exclamation mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1.5">Password</label>
                        <div class="relative">
                            <i class="fa fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 text-sm"></i>
                            <input
                                type="password"
                                name="password"
                                id="passwordInput"
                                placeholder="Min. 8 karakter"
                                required
                                oninput="checkStrength(this.value)"
                                class="input-field w-full rounded-xl px-4 py-2.5 pl-10 pr-10 text-sm @error('password') border-red-500/50 @enderror"
                            >
                            <button type="button" onclick="togglePwd('passwordInput','eye1')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-300 transition text-sm">
                                <i class="fa fa-eye" id="eye1"></i>
                            </button>
                        </div>
                        {{-- Password strength indicator --}}
                        <div class="mt-2 flex gap-1">
                            <div class="flex-1 h-1 rounded-full bg-white/10 overflow-hidden">
                                <div id="str1" class="strength-bar w-0 bg-red-500"></div>
                            </div>
                            <div class="flex-1 h-1 rounded-full bg-white/10 overflow-hidden">
                                <div id="str2" class="strength-bar w-0 bg-orange-500"></div>
                            </div>
                            <div class="flex-1 h-1 rounded-full bg-white/10 overflow-hidden">
                                <div id="str3" class="strength-bar w-0 bg-yellow-500"></div>
                            </div>
                            <div class="flex-1 h-1 rounded-full bg-white/10 overflow-hidden">
                                <div id="str4" class="strength-bar w-0 bg-green-500"></div>
                            </div>
                        </div>
                        <p class="text-slate-600 text-xs mt-1" id="strLabel"></p>
                        @error('password')
                            <p class="text-red-400 text-xs mt-1"><i class="fa fa-triangle-exclamation mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1.5">Konfirmasi Password</label>
                        <div class="relative">
                            <i class="fa fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 text-sm"></i>
                            <input
                                type="password"
                                name="password_confirmation"
                                id="passwordConfirm"
                                placeholder="Ulangi password"
                                required
                                class="input-field w-full rounded-xl px-4 py-2.5 pl-10 pr-10 text-sm"
                            >
                            <button type="button" onclick="togglePwd('passwordConfirm','eye2')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-300 transition text-sm">
                                <i class="fa fa-eye" id="eye2"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Info role --}}
                    <div class="bg-purple-500/10 border border-purple-500/20 rounded-xl px-4 py-3 text-xs text-purple-300">
                        <i class="fa fa-circle-info mr-1.5"></i>
                        Akun baru otomatis mendapat role <strong>Manajemen</strong>. Role dapat diubah oleh Admin.
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="btn-primary w-full py-2.5 rounded-xl font-semibold text-white text-sm tracking-wide">
                        <i class="fa fa-user-plus mr-2"></i>Buat Akun
                    </button>
                </form>

                {{-- Divider --}}
                <div class="flex items-center gap-3 my-5">
                    <div class="flex-1 h-px bg-white/10"></div>
                    <span class="text-slate-600 text-xs">atau</span>
                    <div class="flex-1 h-px bg-white/10"></div>
                </div>

                <p class="text-center text-sm text-slate-400">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-purple-400 hover:text-purple-300 font-medium transition">
                        Login di sini
                    </a>
                </p>
            </div>
        </div>
    </main>

    <script>
        function togglePwd(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon  = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        function checkStrength(val) {
            const bars   = ['str1','str2','str3','str4'];
            const labels = ['', 'Lemah', 'Cukup', 'Kuat', 'Sangat Kuat'];
            let score = 0;
            if (val.length >= 8)                    score++;
            if (/[A-Z]/.test(val))                  score++;
            if (/[0-9]/.test(val))                  score++;
            if (/[^A-Za-z0-9]/.test(val))           score++;

            bars.forEach((id, i) => {
                document.getElementById(id).style.width = i < score ? '100%' : '0%';
            });
            document.getElementById('strLabel').textContent = val.length ? labels[score] : '';
        }
    </script>
</body>
</html>
