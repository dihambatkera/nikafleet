<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>NikaFleet — Sewa Kereta Rawang, Selangor</title>
        <meta name="description" content="NikaFleet - Penyedia sewa kereta premium di Rawang, Selangor. Nak sewa? Nika kan ada!">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Styles / Scripts via Vite -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <style>
            body {
                font-family: 'Inter', sans-serif;
            }
            .font-display {
                font-family: 'Plus Jakarta Sans', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased bg-slate-900 text-slate-100 overflow-x-hidden selection:bg-teal-500 selection:text-white">

        <!-- Header / Navigation -->
        <header class="sticky top-0 z-50 w-full border-b border-white/5 bg-slate-950/80 backdrop-blur-md transition-all duration-300" x-data="{ mobileMenuOpen: false }">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
                
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-teal-400 to-teal-600 flex items-center justify-center shadow-lg shadow-teal-500/20 group-hover:scale-105 transition-all duration-200">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2.34.34M5 16H4M19 16h1M15 16H9m10 0l-2-6H9l-2 6"/>
                        </svg>
                    </div>
                    <div>
                        <span class="font-display font-extrabold text-xl tracking-tight text-white block">NikaFleet</span>
                        <span class="text-[10px] text-teal-400 font-semibold tracking-wider uppercase block -mt-1">Rawang</span>
                    </div>
                </a>

                <!-- Desktop Nav -->
                <nav class="hidden md:flex items-center gap-8">
                    <a href="#fleet" class="text-sm font-medium text-slate-300 hover:text-white transition-colors">Our Fleet</a>
                    <a href="#why-us" class="text-sm font-medium text-slate-300 hover:text-white transition-colors">Why Choose Us</a>
                    <a href="#about" class="text-sm font-medium text-slate-300 hover:text-white transition-colors">About Us</a>
                </nav>

                <!-- Action Buttons -->
                <div class="hidden md:flex items-center gap-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-5 py-2 rounded-xl bg-teal-600 hover:bg-teal-500 text-white text-sm font-semibold transition-all shadow-md shadow-teal-600/10 active:scale-95">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-300 hover:text-white transition-colors">Log in</a>
                        <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-xl bg-teal-600 hover:bg-teal-500 text-white text-sm font-semibold transition-all shadow-lg shadow-teal-500/20 active:scale-95">Book Now</a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="!mobileMenuOpen">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="mobileMenuOpen" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div x-show="mobileMenuOpen" x-transition class="md:hidden border-t border-white/5 bg-slate-950 px-4 py-6 space-y-4" style="display: none;">
                <a href="#fleet" @click="mobileMenuOpen = false" class="block text-base font-medium text-slate-300 hover:text-white">Our Fleet</a>
                <a href="#why-us" @click="mobileMenuOpen = false" class="block text-base font-medium text-slate-300 hover:text-white">Why Choose Us</a>
                <a href="#about" @click="mobileMenuOpen = false" class="block text-base font-medium text-slate-300 hover:text-white">About Us</a>
                <hr class="border-white/5">
                @auth
                    <a href="{{ route('dashboard') }}" class="block w-full text-center px-4 py-2.5 rounded-xl bg-teal-600 text-white font-semibold">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="block text-center text-slate-300 hover:text-white font-medium">Log in</a>
                    <a href="{{ route('register') }}" class="block w-full text-center px-4 py-2.5 rounded-xl bg-teal-600 text-white font-semibold">Book Now</a>
                @endauth
            </div>
        </header>

        <!-- Hero Section -->
        <section class="relative min-h-[85vh] flex items-center justify-center pt-10 pb-20 overflow-hidden">
            <!-- Background Radial Glows -->
            <div class="absolute inset-0 z-0 pointer-events-none">
                <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] rounded-full bg-teal-500/10 blur-[120px]"></div>
                <div class="absolute bottom-10 right-10 w-[400px] h-[400px] rounded-full bg-blue-600/10 blur-[100px]"></div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <!-- Text Area -->
                <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-teal-500/10 border border-teal-500/20 text-teal-400 text-xs font-semibold uppercase tracking-wider">
                        📍 Rawang, Selangor — Est. Nov 2025
                    </div>
                    <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-white leading-tight">
                        Nak sewa? <br class="hidden sm:inline">
                        <span class="text-gradient-brand bg-gradient-to-r from-teal-400 to-emerald-400 bg-clip-text text-transparent">Nika kan ada!</span>
                    </h1>
                    <p class="text-slate-400 text-lg max-w-xl mx-auto lg:mx-0">
                        NikaFleet menyediakan pilihan kereta sewa pandu sendiri terbaik di Rawang. Dari kereta kompak yang lincah hinggalah MPV keluarga mewah, kami bersedia membantu anda.
                    </p>
                    
                    <!-- Call to Actions -->
                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-2">
                        <a href="#fleet" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-teal-600 hover:bg-teal-500 text-white font-bold transition-all shadow-lg shadow-teal-600/20 text-center hover:-translate-y-0.5 active:scale-95">
                            Lihat Kereta
                        </a>
                        <a href="https://wa.me/601168247599" target="_blank" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-slate-800 hover:bg-slate-700 text-slate-100 font-bold border border-slate-700 transition-all text-center flex items-center justify-center gap-2 hover:-translate-y-0.5 active:scale-95">
                            <svg class="w-5 h-5 text-emerald-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.739-1.456L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.825 1.451 5.436 0 9.86-4.37 9.863-9.73.001-2.595-1.006-5.038-2.834-6.87C16.673 2.17 14.24 1.165 11.648 1.165c-5.442 0-9.873 4.38-9.877 9.737-.001 1.774.475 3.509 1.382 5.02L2.164 21.89l6.19-1.616l-.707-.12z"/>
                            </svg>
                            Hubungi WhatsApp
                        </a>
                    </div>
                </div>

                <!-- Graphic/Visual Area -->
                <div class="lg:col-span-5 relative flex justify-center">
                    <div class="relative w-full max-w-[400px] h-[350px] rounded-3xl overflow-hidden bg-slate-950/40 border border-white/5 flex items-center justify-center p-6 backdrop-blur-md">
                        <!-- Custom vector car look -->
                        <div class="absolute inset-0 bg-gradient-to-t from-teal-950/60 to-transparent"></div>
                        <div class="relative z-10 text-center space-y-6">
                            <div class="w-24 h-24 rounded-full bg-teal-500/20 border border-teal-500/30 flex items-center justify-center mx-auto text-teal-400">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-display text-lg font-bold text-white">Tempahan Mudah & Cepat</h3>
                                <p class="text-slate-400 text-sm mt-2 leading-relaxed">
                                    Pilih tarikh, pilih kereta sewa impian anda, dan ambil terus di Rawang, Selangor.
                                </p>
                            </div>
                            <div class="flex items-center justify-center gap-2 text-xs text-teal-400 font-semibold bg-teal-500/10 border border-teal-500/20 rounded-xl px-4 py-2">
                                🌟 Kadar Serendah RM 110 / Hari
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Fleet Grid Section -->
        <section id="fleet" class="py-24 bg-slate-950 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <!-- Section Header -->
                <div class="text-center space-y-4 mb-16">
                    <h2 class="font-display text-3xl sm:text-4xl font-extrabold text-white">Barisan Kereta Sewa Kami</h2>
                    <p class="text-slate-400 max-w-xl mx-auto text-sm sm:text-base">
                        Semua kenderaan dijaga rapi, diservis berkala, dan bersih untuk menjamin pemanduan yang menyeronokkan.
                    </p>
                </div>

                <!-- Cars List Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($cars as $car)
                        <div class="bg-slate-900 border border-white/5 rounded-3xl overflow-hidden hover:border-teal-500/30 hover:shadow-2xl hover:shadow-teal-500/5 transition-all duration-300 flex flex-col">
                            <!-- Visual Graphic for Car Category -->
                            <div class="h-48 bg-slate-950 relative flex items-center justify-center p-6 overflow-hidden">
                                <div class="absolute inset-0 bg-gradient-to-br from-teal-950/20 to-slate-900/40"></div>
                                
                                <!-- Icon representation of transmission/brand -->
                                <div class="relative z-10 w-20 h-20 rounded-2xl bg-slate-900 border border-white/10 flex items-center justify-center text-teal-400">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                    </svg>
                                </div>
                                <span class="absolute top-4 right-4 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-teal-500/10 text-teal-400 border border-teal-500/20">
                                    {{ $car->type }}
                                </span>
                            </div>

                            <!-- Car Details -->
                            <div class="p-6 flex-1 flex flex-col justify-between space-y-6">
                                <div>
                                    <h3 class="font-display text-xl font-bold text-white">{{ $car->name }}</h3>
                                    <p class="text-xs text-slate-500 mt-1">Plate Number: {{ $car->plate_number }}</p>
                                    <p class="text-slate-400 text-sm mt-3 line-clamp-2 leading-relaxed">
                                        {{ $car->description ?? 'Sedia untuk disewa pandu sendiri di sekitar Rawang dan kawasan berdekatan.' }}
                                    </p>
                                </div>

                                <!-- Key Specs -->
                                <div class="grid grid-cols-3 gap-2 border-y border-white/5 py-3 text-center">
                                    <div class="space-y-1">
                                        <span class="text-[10px] text-slate-500 block uppercase font-semibold">Seat</span>
                                        <span class="text-xs font-bold text-white block">{{ $car->seats }} Seats</span>
                                    </div>
                                    <div class="space-y-1 border-x border-white/5">
                                        <span class="text-[10px] text-slate-500 block uppercase font-semibold">Gear</span>
                                        <span class="text-xs font-bold text-white block capitalize">{{ $car->transmission }}</span>
                                    </div>
                                    <div class="space-y-1">
                                        <span class="text-[10px] text-slate-500 block uppercase font-semibold">Fuel</span>
                                        <span class="text-xs font-bold text-white block capitalize">{{ $car->fuel_type }}</span>
                                    </div>
                                </div>

                                <!-- Prices & Booking -->
                                <div class="flex items-center justify-between pt-2">
                                    <div>
                                        <span class="text-[10px] text-slate-500 block uppercase font-semibold">Kadar Harian</span>
                                        <span class="text-2xl font-black text-teal-400">RM {{ number_format($car->price_per_day) }}</span>
                                        <span class="text-xs text-slate-400 font-medium">/ day</span>
                                    </div>

                                    <a href="{{ route('register') }}" class="px-5 py-3 rounded-xl bg-teal-600 hover:bg-teal-500 text-white text-xs font-bold transition-all shadow-md shadow-teal-600/10 flex items-center gap-1.5 active:scale-95">
                                        Sewa Sekarang
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-20 text-slate-500">
                            Tiada kereta yang sedia disewa buat masa ini. Sila hubungi admin.
                        </div>
                    @endforelse
                </div>

            </div>
        </section>

        <!-- Why Choose Us -->
        <section id="why-us" class="py-24 bg-slate-900 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="text-center space-y-4 mb-20">
                    <h2 class="font-display text-3xl sm:text-4xl font-extrabold text-white">Kenapa Sewa Dengan NikaFleet?</h2>
                    <p class="text-slate-400 max-w-xl mx-auto text-sm sm:text-base">
                        Komitmen kami untuk memberikan pengalaman sewa kereta terbaik di Rawang.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Point 1 -->
                    <div class="p-8 rounded-3xl bg-slate-950/50 border border-white/5 space-y-4 hover:border-teal-500/20 transition-all duration-300">
                        <div class="w-12 h-12 rounded-2xl bg-teal-500/10 flex items-center justify-center text-teal-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <h3 class="font-display text-lg font-bold text-white">Pembersihan Berkala & Sanitasi</h3>
                        <p class="text-slate-400 text-sm leading-relaxed">
                            Kami memastikan setiap kereta dibersihkan dan disanitasikan sepenuhnya sebelum diserahkan kepada pelanggan baru.
                        </p>
                    </div>

                    <!-- Point 2 -->
                    <div class="p-8 rounded-3xl bg-slate-950/50 border border-white/5 space-y-4 hover:border-teal-500/20 transition-all duration-300">
                        <div class="w-12 h-12 rounded-2xl bg-teal-500/10 flex items-center justify-center text-teal-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="font-display text-lg font-bold text-white">Harga Fleksibel Tanpa Caj Tersembunyi</h3>
                        <p class="text-slate-400 text-sm leading-relaxed">
                            Kadar harian yang mesra poket dan tawaran mingguan yang menguntungkan. Semua terma deposit dipaparkan jelas.
                        </p>
                    </div>

                    <!-- Point 3 -->
                    <div class="p-8 rounded-3xl bg-slate-950/50 border border-white/5 space-y-4 hover:border-teal-500/20 transition-all duration-300">
                        <div class="w-12 h-12 rounded-2xl bg-teal-500/10 flex items-center justify-center text-teal-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <h3 class="font-display text-lg font-bold text-white">Pengambilan & Hantaran Pantas</h3>
                        <p class="text-slate-400 text-sm leading-relaxed">
                            Proses dokumentasi yang ringkas dan efisien di pusat Rawang membolehkan anda terus memandu tanpa menunggu lama.
                        </p>
                    </div>
                </div>

            </div>
        </section>

        <!-- Brand Banner / Social Media -->
        <section id="about" class="py-20 bg-gradient-to-r from-teal-950 to-slate-950 relative overflow-hidden border-y border-white/5">
            <div class="absolute inset-0 pointer-events-none opacity-20">
                <div class="absolute -top-40 -right-40 w-96 h-96 rounded-full bg-teal-400 blur-3xl"></div>
            </div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-6 relative z-10">
                <span class="text-xs font-bold tracking-widest text-teal-400 uppercase">Nak sewa? Nika kan ada!</span>
                <h2 class="font-display text-3xl sm:text-5xl font-black text-white">Sedia Untuk Menempah Perjalanan Anda?</h2>
                <p class="text-slate-300 max-w-xl mx-auto text-sm sm:text-base leading-relaxed">
                    Tempah di atas platform kami atau hubungi kami terus. Ikuti akaun media sosial kami untuk promosi terkini dan kemas kini fleet!
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
                    <a href="https://www.tiktok.com/@nika.fleet" target="_blank" class="w-full sm:w-auto px-6 py-3 rounded-xl bg-slate-900 border border-white/10 hover:bg-slate-800 text-white font-bold transition-all flex items-center justify-center gap-2">
                        TikTok @nika.fleet
                    </a>
                    <a href="https://wa.me/601168247599" target="_blank" class="w-full sm:w-auto px-6 py-3 rounded-xl bg-teal-600 hover:bg-teal-500 text-white font-bold transition-all flex items-center justify-center gap-2">
                        WhatsApp Hubungi Kami
                    </a>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-slate-950 border-t border-white/5 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Branding -->
                <div class="md:col-span-2 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-teal-500 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <span class="font-display font-bold text-lg text-white">NikaFleet</span>
                    </div>
                    <p class="text-slate-400 text-xs sm:text-sm leading-relaxed max-w-sm">
                        Perkhidmatan sewa kereta pandu sendiri di Rawang, Selangor. Ditubuhkan pada November 2025 untuk memenuhi keperluan perjalanan anda.
                    </p>
                </div>

                <!-- Links -->
                <div class="space-y-4">
                    <h4 class="font-display text-sm font-bold text-white uppercase tracking-wider">Navigasi</h4>
                    <ul class="space-y-2 text-xs sm:text-sm">
                        <li><a href="#fleet" class="text-slate-400 hover:text-white transition-colors">Our Fleet</a></li>
                        <li><a href="#why-us" class="text-slate-400 hover:text-white transition-colors">Why Choose Us</a></li>
                        <li><a href="{{ route('admin.login') }}" class="text-slate-400 hover:text-white transition-colors">Admin Portal</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div class="space-y-4">
                    <h4 class="font-display text-sm font-bold text-white uppercase tracking-wider">Hubungi Kami</h4>
                    <p class="text-slate-400 text-xs sm:text-sm">
                        📍 Rawang, Selangor, Malaysia<br>
                        📞 +60 11-6824 7599
                    </p>
                </div>
            </div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 border-t border-white/5 mt-12 pt-6 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-4">
                <p>&copy; {{ date('Y') }} NikaFleet. All rights reserved.</p>
                <p>Est. November 2025 &bull; Nak sewa? Nika kan ada!</p>
            </div>
        </footer>

    </body>
</html>
