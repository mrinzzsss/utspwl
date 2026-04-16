<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MPL PWL')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #0a0a0f; color: #e2e8f0; }
        .gradient-text { background: linear-gradient(135deg, #6366f1, #a855f7); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .card-glass { background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); backdrop-filter: blur(12px); }
        .nav-link { transition: color .2s; }
        .nav-link:hover { color: #a855f7; }
    </style>
</head>
<body class="min-h-screen">

    {{-- Navbar --}}
    <nav class="sticky top-0 z-50 border-b border-white/10" style="background:rgba(10,10,15,0.9);backdrop-filter:blur(16px)">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="{{ route('home') }}" class="text-xl font-black gradient-text tracking-widest">MPL PWL</a>
            <div class="flex items-center gap-6 text-sm font-medium text-slate-300">
                <a href="{{ route('home') }}" class="nav-link">Home</a>
                <a href="{{ route('tournaments.index') }}" class="nav-link">Tournaments</a>
                @auth
                    <span class="text-purple-400 text-xs border border-purple-500/30 px-2 py-1 rounded-full">
                        {{ auth()->user()->role }}
                    </span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button class="nav-link text-red-400">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-1.5 rounded-lg text-xs transition">Login</a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 mt-4">
            <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg text-sm">
                ✓ {{ session('success') }}
            </div>
        </div>
    @endif

    {{-- Main content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="border-t border-white/10 mt-20 py-8 text-center text-slate-500 text-sm">
        © {{ date('Y') }} MPL PWL &mdash; Mobile Legends Professional League
    </footer>

</body>
</html>
