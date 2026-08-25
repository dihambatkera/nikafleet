<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login — NikaFleet</title>
    <meta name="description" content="NikaFleet Admin Portal — Secure access for authorized administrators only.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --gold-100: #fdf6e0;
            --gold-200: #f7e4a0;
            --gold-300: #e8c84a;
            --gold-400: #d4a017;
            --gold-500: #b8870f;
            --gold-600: #9a6e0a;
            --white:    #ffffff;
            --off-white:#f9f7f1;
            --gray-100: #f3f0ea;
            --gray-200: #e5e0d4;
            --gray-400: #9a9080;
            --gray-600: #6b6255;
            --gray-900: #1c1a14;
        }

        html, body {
            height: 100%;
            font-family: 'Inter', sans-serif;
        }

        body {
            min-height: 100vh;
            background: var(--off-white);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background:
                radial-gradient(ellipse at 20% 0%, rgba(212,160,23,0.12) 0%, transparent 55%),
                radial-gradient(ellipse at 80% 100%, rgba(184,135,15,0.10) 0%, transparent 55%),
                radial-gradient(ellipse at 60% 50%, rgba(247,228,160,0.08) 0%, transparent 40%);
            pointer-events: none;
            z-index: 0;
        }

        body::after {
            content: '';
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image: repeating-linear-gradient(-45deg, transparent, transparent 60px, rgba(212,160,23,0.025) 60px, rgba(212,160,23,0.025) 61px);
            pointer-events: none;
            z-index: 0;
        }

        .login-wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 440px;
            animation: slideUp 0.5s ease-out both;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .logo-section {
            text-align: center;
            margin-bottom: 1.75rem;
        }

        .logo-img {
            height: 72px;
            width: auto;
            object-fit: contain;
            filter: drop-shadow(0 4px 12px rgba(184,135,15,0.25));
            animation: floatLogo 5s ease-in-out infinite;
        }

        @keyframes floatLogo {
            0%, 100% { transform: translateY(0); }
            50%       { transform: translateY(-6px); }
        }

        .login-card {
            background: var(--white);
            border-radius: 20px;
            padding: 2.5rem 2rem;
            box-shadow:
                0 1px 2px rgba(0,0,0,0.04),
                0 8px 32px rgba(0,0,0,0.08),
                0 0 0 1px rgba(212,160,23,0.15),
                inset 0 1px 0 rgba(255,255,255,0.9);
        }

        .card-header {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--gray-200);
            position: relative;
        }

        .card-header::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 2px;
            background: linear-gradient(90deg, var(--gold-400), var(--gold-300));
            border-radius: 2px;
        }

        .badge-admin {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: linear-gradient(135deg, var(--gold-100), var(--gold-200));
            border: 1px solid rgba(212,160,23,0.3);
            border-radius: 100px;
            padding: 4px 14px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: var(--gold-600);
            margin-bottom: 0.875rem;
        }

        .badge-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--gold-400);
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50%       { opacity: 0.6; transform: scale(0.85); }
        }

        .card-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.5rem, 4vw, 1.875rem);
            font-weight: 700;
            color: var(--gray-900);
            letter-spacing: -0.01em;
            line-height: 1.2;
        }

        .card-subtitle {
            font-size: 0.875rem;
            color: var(--gray-400);
            margin-top: 0.375rem;
        }

        .alert {
            padding: 0.75rem 1rem;
            border-radius: 10px;
            font-size: 0.875rem;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
        }

        .alert-error {
            background: #fff5f5;
            border: 1px solid #fecaca;
            color: #991b1b;
        }

        .alert-success {
            background: var(--gold-100);
            border: 1px solid rgba(212,160,23,0.3);
            color: var(--gold-600);
        }

        .form-group { margin-bottom: 1.25rem; }

        label {
            display: block;
            font-size: 0.8125rem;
            font-weight: 600;
            color: var(--gray-600);
            margin-bottom: 0.5rem;
            letter-spacing: 0.01em;
        }

        .input-wrapper { position: relative; }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-400);
            pointer-events: none;
            display: flex;
        }

        input[type="email"],
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 0.75rem 0.875rem 0.75rem 2.75rem;
            border: 1.5px solid var(--gray-200);
            border-radius: 10px;
            font-size: 0.9375rem;
            font-family: 'Inter', sans-serif;
            color: var(--gray-900);
            background: var(--off-white);
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
            outline: none;
            -webkit-appearance: none;
        }

        input[type="email"]:focus,
        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: var(--gold-400);
            background: var(--white);
            box-shadow: 0 0 0 3px rgba(212,160,23,0.12);
        }

        input.is-invalid { border-color: #f87171; }
        input::placeholder { color: #ccc5b5; }

        .toggle-pass {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--gray-400);
            display: flex;
            align-items: center;
            padding: 4px;
            border-radius: 6px;
            transition: color 0.2s;
        }

        .toggle-pass:hover { color: var(--gold-500); }

        .remember-row {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .remember-row input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: var(--gold-400);
            cursor: pointer;
            border-radius: 4px;
            flex-shrink: 0;
            padding: 0;
        }

        .remember-row label {
            margin: 0;
            font-size: 0.875rem;
            color: var(--gray-400);
            font-weight: 400;
            cursor: pointer;
        }

        .btn-submit {
            width: 100%;
            padding: 0.875rem 1.5rem;
            border: none;
            border-radius: 10px;
            font-size: 0.9375rem;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            color: var(--white);
            background: linear-gradient(135deg, var(--gold-400) 0%, var(--gold-300) 50%, var(--gold-400) 100%);
            background-size: 200% auto;
            cursor: pointer;
            transition: background-position 0.4s ease, transform 0.15s ease, box-shadow 0.2s;
            box-shadow: 0 4px 16px rgba(212,160,23,0.35), 0 1px 3px rgba(0,0,0,0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            letter-spacing: 0.01em;
            text-shadow: 0 1px 2px rgba(0,0,0,0.15);
        }

        .btn-submit:hover {
            background-position: right center;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(212,160,23,0.45), 0 2px 6px rgba(0,0,0,0.1);
        }

        .btn-submit:active {
            transform: scale(0.98) translateY(0);
            box-shadow: 0 2px 8px rgba(212,160,23,0.3);
        }

        .card-footer {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.25rem;
            border-top: 1px solid var(--gray-200);
        }

        .footer-brand {
            font-size: 0.75rem;
            color: var(--gray-400);
        }

        .footer-brand strong { color: var(--gold-500); }

        .security-note {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin-top: 0.625rem;
            font-size: 0.6875rem;
            color: var(--gray-400);
            letter-spacing: 0.02em;
        }

        .copyright {
            text-align: center;
            font-size: 0.6875rem;
            color: var(--gray-400);
            margin-top: 1.25rem;
        }

        @media (max-width: 480px) {
            .login-card { padding: 2rem 1.25rem; border-radius: 16px; }
            .logo-img { height: 58px; }
        }

        @media (max-width: 360px) {
            body { padding: 0.75rem; }
            .login-card { padding: 1.5rem 1rem; }
        }
    </style>
</head>
<body x-data="{ showPass: false }">

    <div class="login-wrapper">

        {{-- Company Logo --}}
        <div class="logo-section">
            <img
                src="{{ asset('logo-official-transparrent.png') }}"
                alt="NikaFleet"
                class="logo-img"
                loading="eager"
                onerror="this.style.display='none'"
            >
        </div>

        {{-- Login Card --}}
        <div class="login-card">

            {{-- Card Header --}}
            <div class="card-header">
                <div class="badge-admin">
                    <span class="badge-dot"></span>
                    Admin Portal
                </div>
                <h1 class="card-title">Admin Login</h1>
                <p class="card-subtitle">Sign in to access the dashboard</p>
            </div>

            {{-- Session Status --}}
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('status') }}
                </div>
            @endif

            {{-- Errors --}}
            @if ($errors->any())
                <div class="alert alert-error" role="alert">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Login Form --}}
            <form method="POST" action="{{ route('admin.login.post') }}" novalidate>
                @csrf

                {{-- Email --}}
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <div class="input-wrapper">
                        <span class="input-icon">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </span>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="your@email.com"
                            class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                        >
                    </div>
                </div>

                {{-- Password --}}
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <span class="input-icon">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </span>
                        <input
                            id="password"
                            :type="showPass ? 'text' : 'password'"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="••••••••"
                            class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                        >
                        <button type="button" class="toggle-pass" @click="showPass = !showPass" :aria-label="showPass ? 'Hide password' : 'Show password'">
                            <svg x-show="!showPass" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg x-show="showPass" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                        </button>
                    </div>
                </div>

                {{-- Remember Me --}}
                <div class="remember-row">
                    <input id="remember_me" type="checkbox" name="remember">
                    <label for="remember_me">Keep me signed in</label>
                </div>

                {{-- Submit --}}
                <button type="submit" id="btn-admin-login" class="btn-submit">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                    Sign In to Dashboard
                </button>
            </form>

            {{-- Footer --}}
            <div class="card-footer">
                <p class="footer-brand"><strong>NikaFleet</strong> &mdash; Fleet Management System</p>
                <div class="security-note">
                    <svg width="11" height="11" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/></svg>
                    Secure &middot; Encrypted &middot; Authorized Access Only
                </div>
            </div>

        </div>{{-- /.login-card --}}

        <p class="copyright">&copy; {{ date('Y') }} NikaFleet &middot; Rawang, Selangor</p>

    </div>{{-- /.login-wrapper --}}

</body>
</html>