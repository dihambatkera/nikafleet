<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ isset($title) ? $title . ' — ' : '' }}{{ config('app.name', 'NikaFleet') }}</title>

        <!-- Google Fonts Call -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,300&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- AlpineJS via CDN -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="font-sans text-[#FFFFFF] antialiased bg-[#0F1117]">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[#0F1117]">
            <div class="mb-8">
                <!-- Wordmark Branding (No space, tight kerning) -->
                <a href="/" class="flex items-center gap-0">
                    <img src="{{ asset('logo.jpeg') }}" class="h-9 w-auto object-contain block mr-1" alt="NikaFleet Logo" style="height: 36px;">
                    <span class="font-sans font-bold text-sm tracking-tight text-[#FFFFFF]" style="letter-spacing: 0.18em; font-family: 'DM Sans', sans-serif;">NIKAFLEET</span>
                </a>
            </div>

            <!-- Box Container utilizing --color-surface and --color-border-dark -->
            <div class="w-full sm:max-w-md mt-2 px-8 py-8 bg-[#1C2333] border border-[#2E3A4E] shadow-2xl overflow-hidden rounded-sm">
                {{ $slot }}
            </div>
            
            <div class="mt-6">
                <p class="text-xs text-[#6B7A8D] font-mono-data" style="font-family: 'DM Mono', monospace; letter-spacing: 0.04em;">NAK SEWA? NIKA KAN ADA!</p>
            </div>
        </div>
    </body>
</html>
