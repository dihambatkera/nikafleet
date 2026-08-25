<!DOCTYPE html>
<html lang="ms" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'NikaFleet — Nak Sewa? Nika Kan Ada! | Rawang, Selangor')</title>
    <meta name="description" content="@yield('meta_description', 'Sewa kereta mudah dan selesa di Rawang, Selangor. Pelbagai pilihan kereta tersedia. Hubungi NikaFleet sekarang! 📲 +60 11-6824 7599')">

    <!-- Open Graph -->
    <meta property="og:title" content="@yield('title', 'NikaFleet — Nak Sewa? Nika Kan Ada! | Rawang, Selangor')">
    <meta property="og:description" content="Sewa kereta mudah dan selesa di Rawang, Selangor. Pelbagai pilihan kereta tersedia. Hubungi NikaFleet sekarang! 📲 +60 11-6824 7599">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{{ asset('logo.jpeg') }}">
    <meta property="og:url" content="{{ url()->current() }}">

    <!-- Google Fonts call exactly as specified -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,300&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">

    <!-- Vite Styles and Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- AlpineJS via CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
    </style>

    @stack('styles')
</head>
<body class="antialiased bg-[#F4F6F9] text-[#374151] font-sans">

<!-- ═══ NAVBAR (THE TYPE-LOCK NAVBAR) ═══ -->
<nav class="sticky top-0 z-50 w-full bg-[#0F1117] border-b border-[#2E3A4E] h-[60px] md:h-[68px] flex items-center" x-data="{ mobileOpen: false }">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 w-full flex items-center justify-between">
        
        <!-- Left: Logo & Wordmark (No space, tight kerning) -->
        <a href="{{ route('home') }}" class="flex items-center gap-0">
            <img src="{{ asset('logo.jpeg') }}" class="h-9 w-auto object-contain block mr-1" alt="NikaFleet Logo" style="height: 36px;">
            <span class="font-sans font-bold text-sm tracking-tight text-[#FFFFFF]" style="letter-spacing: 0.18em; font-family: 'DM Sans', sans-serif;">NIKAFLEET</span>
        </a>

        <!-- Center (desktop nav links) -->
        <div class="hidden md:flex items-center gap-8">
            <a href="{{ route('home') }}"
               class="font-sans font-medium text-sm tracking-normal uppercase transition-colors duration-200 py-1.5 {{ request()->routeIs('home') ? 'text-[#FFFFFF] border-b border-[#C5A94B]' : 'text-[#A8B3C4] hover:text-[#FFFFFF]' }}"
               style="letter-spacing: 0.06em; font-family: 'DM Sans', sans-serif;">
                Laman Utama
            </a>
            <a href="{{ route('cars.index') }}"
               class="font-sans font-medium text-sm tracking-normal uppercase transition-colors duration-200 py-1.5 {{ request()->routeIs('cars.*') ? 'text-[#FFFFFF] border-b border-[#C5A94B]' : 'text-[#A8B3C4] hover:text-[#FFFFFF]' }}"
               style="letter-spacing: 0.06em; font-family: 'DM Sans', sans-serif;">
                Kereta
            </a>
            <a href="{{ route('contact') }}"
               class="font-sans font-medium text-sm tracking-normal uppercase transition-colors duration-200 py-1.5 {{ request()->routeIs('contact') ? 'text-[#FFFFFF] border-b border-[#C5A94B]' : 'text-[#A8B3C4] hover:text-[#FFFFFF]' }}"
               style="letter-spacing: 0.06em; font-family: 'DM Sans', sans-serif;">
                Hubungi
            </a>
        </div>

        <!-- Right (desktop CTA + phone number) -->
        <div class="hidden md:flex items-center gap-6">
            <span class="font-mono-data text-xs text-[#6B7A8D] font-medium" style="font-family: 'DM Mono', monospace; letter-spacing: 0.04em;">
                +60 11-6824 7599
            </span>
            <a href="{{ route('cars.index') }}" class="btn-brass py-2 px-6 text-xs">
                Sewa Sekarang
            </a>
        </div>

        <!-- Mobile: hamburger right (three thin lines) -->
        <button @click="mobileOpen = !mobileOpen"
                class="md:hidden flex flex-col gap-1.5 justify-center items-end w-6 h-6 focus:outline-none"
                aria-label="Menu">
            <span class="block w-6 h-[1.5px] bg-[#A8B3C4] transition-all duration-300" :class="mobileOpen ? 'rotate-45 translate-y-[7.5px]' : ''"></span>
            <span class="block w-5 h-[1.5px] bg-[#A8B3C4] transition-all duration-300" :class="mobileOpen ? 'opacity-0' : ''"></span>
            <span class="block w-6 h-[1.5px] bg-[#A8B3C4] transition-all duration-300" :class="mobileOpen ? '-rotate-45 -translate-y-[7.5px]' : ''"></span>
        </button>

    </div>

    <!-- Mobile Slide-down drawer -->
    <div x-show="mobileOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         x-cloak
         class="absolute top-[60px] left-0 w-full bg-[#1C2333] border-b border-[#2E3A4E] shadow-xl md:hidden z-50">
        <div class="px-6 py-6 flex flex-col gap-4">
            <a href="{{ route('home') }}"
               class="font-sans font-medium text-sm tracking-normal uppercase py-2 {{ request()->routeIs('home') ? 'text-[#FFFFFF]' : 'text-[#A8B3C4]' }}"
               style="letter-spacing: 0.06em; font-family: 'DM Sans', sans-serif;"
               @click="mobileOpen = false">
                Laman Utama
            </a>
            <a href="{{ route('cars.index') }}"
               class="font-sans font-medium text-sm tracking-normal uppercase py-2 {{ request()->routeIs('cars.*') ? 'text-[#FFFFFF]' : 'text-[#A8B3C4]' }}"
               style="letter-spacing: 0.06em; font-family: 'DM Sans', sans-serif;"
               @click="mobileOpen = false">
                Kereta
            </a>
            <a href="{{ route('contact') }}"
               class="font-sans font-medium text-sm tracking-normal uppercase py-2 {{ request()->routeIs('contact') ? 'text-[#FFFFFF]' : 'text-[#A8B3C4]' }}"
               style="letter-spacing: 0.06em; font-family: 'DM Sans', sans-serif;"
               @click="mobileOpen = false">
                Hubungi
            </a>
            
            <div class="divider-dark my-2"></div>
            
            <div class="flex items-center justify-between text-[#6B7A8D]">
                <span class="text-xs font-semibold uppercase">Pertanyaan</span>
                <span class="font-mono-data text-xs" style="font-family: 'DM Mono', monospace; letter-spacing: 0.04em;">+60 11-6824 7599</span>
            </div>
            
            <a href="{{ route('cars.index') }}" 
               class="btn-brass w-full text-center text-sm py-3 justify-center"
               @click="mobileOpen = false">
                Sewa Sekarang
            </a>
        </div>
    </div>
</nav>

<!-- ═══ PAGE CONTENT ═══ -->
<main class="min-h-screen">
    @yield('content')
</main>

<!-- ═══ FOOTER ═══ -->
<footer class="bg-[#0F1117] text-[#A8B3C4] border-t border-[#2E3A4E]">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

            <!-- Brand Column -->
            <div class="md:col-span-2 space-y-4">
                <a href="{{ route('home') }}" class="flex items-center gap-0">
                    <img src="{{ asset('logo.jpeg') }}" class="h-9 w-auto object-contain block mr-1" alt="NikaFleet Logo" style="height: 36px;">
                    <span class="font-sans font-bold text-sm tracking-tight text-[#FFFFFF]" style="letter-spacing: 0.18em; font-family: 'DM Sans', sans-serif;">NIKAFLEET</span>
                </a>
                <p class="text-xs sm:text-sm leading-relaxed max-w-sm text-[#A8B3C4]">
                    Perkhidmatan sewa kereta pandu sendiri terbaik di Rawang, Selangor. Ditubuhkan pada November 2025 untuk memenuhi keperluan perjalanan anda.
                </p>
                <div class="flex items-center gap-1.5 text-xs text-[#6B7A8D] font-mono-data" style="font-family: 'DM Mono', monospace;">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#16A34A] animate-pulse"></span>
                    <span>Est. November 2025</span>
                </div>
            </div>

            <!-- Navigation Links -->
            <div class="space-y-4">
                <h3 class="text-[#FFFFFF] font-bold text-xs uppercase tracking-widest" style="font-family: 'DM Sans', sans-serif;">Navigasi</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('home') }}" class="text-[#A8B3C4] hover:text-[#FFFFFF] transition-colors">Laman Utama</a></li>
                    <li><a href="{{ route('cars.index') }}" class="text-[#A8B3C4] hover:text-[#FFFFFF] transition-colors">Koleksi Kereta</a></li>
                    <li><a href="{{ route('contact') }}" class="text-[#A8B3C4] hover:text-[#FFFFFF] transition-colors">Hubungi Kami</a></li>
                </ul>
            </div>

            <!-- Contact Information -->
            <div class="space-y-4">
                <h3 class="text-[#FFFFFF] font-bold text-xs uppercase tracking-widest" style="font-family: 'DM Sans', sans-serif;">Hubungi</h3>
                <ul class="space-y-3 text-sm">
                    <li>
                        <a href="tel:+601168247599" class="flex items-center gap-2 text-[#A8B3C4] hover:text-[#FFFFFF] transition-colors">
                            <span class="text-sm">📲</span>
                            <span class="font-mono-data" style="font-family: 'DM Mono', monospace;">+60 11-6824 7599</span>
                        </a>
                    </li>
                    <li>
                        <a href="https://wa.me/601168247599" target="_blank" rel="noopener noreferrer" class="flex items-center gap-2 text-[#A8B3C4] hover:text-[#C5A94B] transition-colors">
                            <span class="text-sm">💬</span>
                            <span>WhatsApp</span>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.tiktok.com/@nika.fleet" target="_blank" rel="noopener noreferrer" class="flex items-center gap-2 text-[#A8B3C4] hover:text-[#C5A94B] transition-colors">
                            <span class="text-sm">🎵</span>
                            <span>@nika.fleet</span>
                        </a>
                    </li>
                    <li class="flex items-start gap-2 text-[#6B7A8D] text-xs">
                        <span class="text-sm mt-0.5">📍</span>
                        <span>Rawang, Selangor, Malaysia</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Bottom copyright bar -->
    <div class="border-t border-[#2E3A4E] bg-[#0A0C10]">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-[#6B7A8D]">
            <p>&copy; {{ date('Y') }} NikaFleet. All rights reserved.</p>
            <p class="font-mono-data" style="font-family: 'DM Mono', monospace; letter-spacing: 0.04em;">NAK SEWA? NIKA KAN ADA!</p>
        </div>
    </div>
</footer>

@stack('scripts')

<!-- Toast Notification System -->
<div x-data="toastComponent()"
     @toast.window="add($event.detail)"
     class="fixed top-5 right-5 z-[9999] flex flex-col gap-3 w-full max-w-sm pointer-events-none"
     x-cloak>
    <template x-for="toast in toasts" :key="toast.id">
        <div class="p-4 rounded-sm shadow-lg border text-white flex items-start gap-3 pointer-events-auto transition-all duration-300 transform translate-y-0"
             :class="{
                'bg-green-600 border-green-700': toast.type === 'success',
                'bg-red-600 border-red-700': toast.type === 'error',
                'bg-amber-500 border-amber-600': toast.type === 'warning',
                'bg-blue-600 border-blue-700': toast.type === 'info'
             }"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-2 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">
            <!-- Icon -->
            <div class="flex-shrink-0 text-lg">
                <template x-if="toast.type === 'success'"><span>✅</span></template>
                <template x-if="toast.type === 'error'"><span>❌</span></template>
                <template x-if="toast.type === 'warning'"><span>⚠️</span></template>
                <template x-if="toast.type === 'info'"><span>ℹ️</span></template>
            </div>
            <!-- Body -->
            <div class="flex-1 min-w-0">
                <p class="text-xs font-semibold font-sans" x-text="toast.message"></p>
            </div>
            <!-- Close button -->
            <button @click="remove(toast.id)" class="text-white hover:text-gray-200 p-0.5 rounded-sm hover:bg-white/10 flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </template>
</div>

<script>
function toastComponent() {
    return {
        toasts: [],
        add(detail) {
            const id = Date.now() + Math.random().toString(36).substr(2, 9);
            const type = detail.type || 'info';
            const message = detail.message || '';
            const duration = type === 'success' ? 4000 : (type === 'error' ? 6000 : (type === 'warning' ? null : 4000));
            
            this.toasts.push({ id, type, message });
            
            if (duration) {
                setTimeout(() => {
                    this.remove(id);
                }, duration);
            }
        },
        remove(id) {
            this.toasts = this.toasts.filter(t => t.id !== id);
        },
        init() {
            @if(session('success'))
                this.add({ type: 'success', message: '{{ session('success') }}' });
            @endif
            @if(session('error'))
                this.add({ type: 'error', message: '{{ session('error') }}' });
            @endif
            @if(session('warning'))
                this.add({ type: 'warning', message: '{{ session('warning') }}' });
            @endif
            @if(session('info'))
                this.add({ type: 'info', message: '{{ session('info') }}' });
            @endif
        }
    }
}
</script>
</body>
</html>
