<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login — NikaFleet</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        .car-bg {
            background: radial-gradient(ellipse at 60% 0%, #0d9488 0%, transparent 60%),
                        radial-gradient(ellipse at 0% 80%, #134e4a 0%, transparent 50%),
                        linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
        }
        .glass-card {
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255,255,255,0.1);
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        .float-anim { animation: float 4s ease-in-out infinite; }
        @keyframes glow-pulse {
            0%, 100% { box-shadow: 0 0 20px rgba(13,148,136,0.3); }
            50% { box-shadow: 0 0 40px rgba(13,148,136,0.6); }
        }
        .glow-pulse { animation: glow-pulse 3s ease-in-out infinite; }
        @keyframes slide-in {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .slide-in { animation: slide-in 0.6s ease-out forwards; }
    </style>
</head>
<body class="h-full car-bg flex items-center justify-center min-h-screen p-4" x-data="{ showPass: false }">

    <!-- Decorative blobs -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 right-20 w-72 h-72 rounded-full bg-teal-500/10 blur-3xl"></div>
        <div class="absolute bottom-20 left-10 w-96 h-96 rounded-full bg-teal-700/10 blur-3xl"></div>
        <div class="absolute top-1/2 left-1/3 w-48 h-48 rounded-full bg-cyan-500/5 blur-2xl"></div>
    </div>

    <div class="relative w-full max-w-md slide-in">

        <!-- Logo Block -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-gradient-to-br from-teal-400 to-teal-700 shadow-2xl glow-pulse float-anim mb-4">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2.34.34M5 16H4M19 16h1M15 16H9m10 0l-2-6H9l-2 6"/>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-white tracking-tight" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                NikaFleet
            </h1>
            <p class="text-teal-400 text-sm font-medium italic mt-1">Nak sewa? Nika kan ada!</p>
            <div class="mt-3 inline-flex items-center gap-1.5 bg-teal-500/20 border border-teal-500/30 rounded-full px-3 py-1">
                <div class="w-1.5 h-1.5 rounded-full bg-teal-400"></div>
                <span class="text-teal-300 text-xs font-medium">Admin Portal</span>
            </div>
        </div>

        <!-- Login Card -->
        <div class="glass-card rounded-3xl p-8 shadow-2xl">
            <div class="mb-6">
                <h2 class="text-xl font-bold text-white">Welcome back</h2>
                <p class="text-slate-400 text-sm mt-1">Sign in to access the admin dashboard</p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 p-3 rounded-xl bg-teal-500/20 border border-teal-500/30 text-teal-300 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Errors -->
            @if ($errors->any())
                <div class="mb-4 p-3 rounded-xl bg-red-500/20 border border-red-500/30 text-red-300 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.post') }}" class="space-y-5">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-300 mb-2">Email Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                            </svg>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                               required autofocus autocomplete="username"
                               placeholder="admin@nikafleet.com"
                               class="w-full pl-10 pr-4 py-3 rounded-xl bg-white/10 border border-white/15 text-white placeholder-slate-500 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all duration-200 @error('email') border-red-500/50 @enderror">
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-300 mb-2">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <input id="password" :type="showPass ? 'text' : 'password'" name="password"
                               required autocomplete="current-password"
                               placeholder="••••••••••"
                               class="w-full pl-10 pr-12 py-3 rounded-xl bg-white/10 border border-white/15 text-white placeholder-slate-500 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all duration-200 @error('password') border-red-500/50 @enderror">
                        <button type="button" @click="showPass = !showPass"
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-500 hover:text-slate-300 transition-colors">
                            <svg x-show="!showPass" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg x-show="showPass" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input id="remember_me" type="checkbox" name="remember"
                           class="w-4 h-4 rounded border-slate-600 bg-white/10 text-teal-500 focus:ring-teal-500 focus:ring-offset-0">
                    <label for="remember_me" class="ml-2 text-sm text-slate-400">Ingat saya</label>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                        class="w-full py-3 px-4 rounded-xl font-semibold text-sm text-white bg-gradient-to-r from-teal-500 to-teal-700 hover:from-teal-400 hover:to-teal-600 active:scale-[0.98] transition-all duration-200 shadow-lg shadow-teal-900/50 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 focus:ring-offset-transparent flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    Log Masuk
                </button>
            </form>

            <!-- Credentials hint (dev only) -->
            @if(config('app.debug'))
            <div class="mt-5 p-3 rounded-xl bg-slate-800/50 border border-slate-700/50">
                <p class="text-xs text-slate-500 font-medium mb-1">🔑 Default credentials</p>
                <p class="text-xs text-slate-400 font-mono">admin@nikafleet.com</p>
                <p class="text-xs text-slate-400 font-mono">password123</p>
            </div>
            @endif
        </div>

        <!-- Footer -->
        <p class="text-center text-xs text-slate-600 mt-6">
            &copy; {{ date('Y') }} NikaFleet · Rawang, Selangor
        </p>
    </div>

</body>
</html>
