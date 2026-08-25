@extends('layouts.user')

@section('title', 'Sewa Kereta Rawang — Mudah & Selesa')
@section('meta_description', 'Sewa kereta mudah & selesa di Rawang, Selangor. NikaFleet — Nak sewa? Nika kan ada! 🚗 Pelbagai pilihan kereta untuk disewa dengan harga berpatutan.')

@section('content')

{{-- ═══════════════════════════════════════════════
     HERO SECTION (Deepest Background Abyss)
     ═══════════════════════════════════════════════ --}}
<section class="relative bg-[#0F1117] overflow-hidden py-14 lg:py-20 flex items-center min-h-[75vh]">
    <!-- Ambient brass glows -->
    <div class="absolute inset-0 pointer-events-none opacity-20">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 rounded-full bg-[#C5A94B] blur-[120px]"></div>
        <div class="absolute bottom-1/4 right-1/4 w-[400px] h-[400px] rounded-full bg-[#2A5FD4] blur-[150px]"></div>
    </div>

    <!-- Fine grid pattern -->
    <div class="absolute inset-0 opacity-5" style="background-image: linear-gradient(#2E3A4E 1px, transparent 1px), linear-gradient(90deg, #2E3A4E 1px, transparent 1px); background-size: 40px 40px;"></div>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10 w-full">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
            
            <!-- Left Info Area -->
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                <!-- Status pill -->
                <div class="inline-flex items-center gap-2 bg-[#252D3D] border border-[#2E3A4E] text-[#A8B3C4] text-xs font-semibold px-4 py-2 rounded-sm tracking-wide uppercase">
                    <span class="w-2 h-2 rounded-full bg-[#16A34A] animate-pulse"></span>
                    Tersedia Hari Ini — {{ $stats['available_today'] }} Kereta
                </div>

                <!-- Main Display Headline (DM Serif Display, weight normal) -->
                <h1 class="font-display text-[#FFFFFF] text-4xl sm:text-5xl lg:text-6xl leading-[1.1] font-normal">
                    Sewa Kereta Rawang.<br class="hidden sm:inline">
                    <span class="text-[#C5A94B]">Nak sewa? Nika kan ada!</span>
                </h1>

                <!-- Subtitle (DM Sans 300) -->
                <p class="text-[#A8B3C4] text-lg sm:text-xl font-light leading-relaxed max-w-xl mx-auto lg:mx-0">
                    NikaFleet menyediakan pilihan kereta sewa pandu sendiri terbaik di Rawang. Dari kereta kompak lincah hinggalah MPV keluarga luas, kami sedia membantu anda.
                </p>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-2">
                    <a href="{{ route('cars.index') }}" class="btn-brass w-full sm:w-auto text-center">
                        Lihat Fleet Kereta
                    </a>
                    <a href="https://wa.me/601168247599" target="_blank" class="btn-secondary w-full sm:w-auto text-center">
                        Hubungi WhatsApp
                    </a>
                </div>
            </div>

            <!-- Right Visual Area -->
            <div class="lg:col-span-5 flex justify-center">
                <!-- Card (Dark Section) -->
                <div class="card-dark p-6 sm:p-8 max-w-[420px] w-full text-center space-y-6 border border-[#2E3A4E]">
                    <div class="w-20 h-20 rounded-sm bg-[#252D3D] border border-[#2E3A4E] flex items-center justify-center mx-auto text-[#C5A94B]">
                        <!-- Elegant abstract car vector -->
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h7.5m3 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.5m-16.5-3h16.5M3 12h18M6.75 6h10.5L21 12H3L6.75 6Z" />
                        </svg>
                    </div>

                    <div class="space-y-2">
                        <h3 class="font-sans font-semibold text-lg text-[#FFFFFF]">Tempahan Pantas & Selamat</h3>
                        <p class="text-[#A8B3C4] text-sm leading-relaxed">
                            Pilih tarikh, sahkan kenderaan anda secara atas talian, dan ambil di Rawang. Tiada caj tersembunyi.
                        </p>
                    </div>

                    <!-- Brass accent badge style -->
                    <div class="inline-flex items-center justify-center gap-2 text-xs text-[#C5A94B] font-mono-data bg-[#252D3D]/50 border border-[#2E3A4E] rounded-sm px-4 py-2 w-full">
                        RM 110 KADAR MINIMA HARIAN
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════
     LIVE STATS BAR (Light section, card layout)
     ═══════════════════════════════════════════════ --}}
<section class="bg-[#F4F6F9] py-8 border-b border-[#E2E7EE]">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- Stat 1 -->
            <div class="card-light p-6 text-center space-y-2">
                <div class="font-mono-data text-3xl font-bold text-[#2A5FD4]">
                    {{ $stats['available_today'] }}
                </div>
                <p class="text-xs uppercase tracking-wide font-semibold text-[#6B7280]">Tersedia Hari Ini</p>
                <div class="inline-flex items-center justify-center gap-1.5 bg-[#EEF2FF] text-[#2A5FD4] text-[10px] px-2 py-0.5 rounded-sm">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#16A34A] animate-pulse"></span>
                    LIVE STATUS
                </div>
            </div>

            <!-- Stat 2 -->
            <div class="card-light p-6 text-center space-y-2">
                <div class="font-mono-data text-3xl font-bold text-[#0D1117]">
                    {{ $stats['total_fleet'] }}
                </div>
                <p class="text-xs uppercase tracking-wide font-semibold text-[#6B7280]">Jumlah Fleet Kereta</p>
                <span class="text-xs text-[#6B7280]">Rawang, Selangor</span>
            </div>

            <!-- Stat 3 -->
            <div class="card-light p-6 text-center space-y-2">
                <div class="font-mono-data text-3xl font-bold text-[#16A34A]">
                    {{ $stats['bookings_done'] }}+
                </div>
                <p class="text-xs uppercase tracking-wide font-semibold text-[#6B7280]">Trip Selesai</p>
                <span class="text-xs text-[#16A34A] font-semibold">Pelanggan Setia</span>
            </div>

        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════
     FLEET CARS SECTION (Light section)
     ═══════════════════════════════════════════════ --}}
<section id="fleet" class="bg-[#F4F6F9] py-14 lg:py-20" x-data="{ activeFilter: 'all' }">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        
        <!-- Section Header with signature divider -->
        <div class="flex flex-col items-center text-center mb-12">
            <h2 class="font-display text-3xl sm:text-4xl text-[#0D1117] font-normal">Koleksi Kereta Sewa Kami</h2>
            <div class="divider-accent mt-4"></div>
            <p class="text-[#6B7280] text-sm sm:text-base mt-4 max-w-xl">
                Semua kenderaan diselenggara secara profesional, dibersihkan sepenuhnya, dan bersedia untuk perjalanan anda.
            </p>
        </div>

        <!-- Filter Pills (DM Sans 500) -->
        <div class="flex flex-wrap items-center justify-center gap-2 mb-10">
            @php
                $filters = [
                    'all'       => 'Semua',
                    'sedan'     => 'Sedan',
                    'suv'       => 'SUV',
                    'mpv'       => 'MPV',
                    'van'       => 'Van',
                    'hatchback' => 'Hatchback',
                    'pickup'    => 'Pickup',
                    'auto'      => 'Auto',
                    'manual'    => 'Manual',
                ];
            @endphp
            @foreach($filters as $val => $lbl)
                <button @click="activeFilter = '{{ $val }}'"
                        :class="activeFilter === '{{ $val }}' ? 'bg-[#2A5FD4] text-[#FFFFFF] border-[#2A5FD4]' : 'bg-[#FFFFFF] text-[#374151] border-[#E2E7EE] hover:border-[#2A5FD4]'"
                        class="px-4 py-2 border rounded-sm text-xs font-semibold uppercase tracking-wider transition-all duration-200 cursor-pointer">
                    {{ $lbl }}
                </button>
            @endforeach
        </div>

        <!-- Cars Grid (spacing gap-8 for feature grids) -->
        @if($availableCars->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($availableCars as $car)
                    @include('user.partials.car-card', ['car' => $car])
                @endforeach
            </div>
            
            <div class="text-center mt-12">
                <a href="{{ route('cars.index') }}" class="btn-primary">
                    Lihat Semua Kenderaan
                </a>
            </div>
        @else
            <!-- Empty state card -->
            <div class="card-light p-12 text-center max-w-md mx-auto">
                <div class="text-4xl mb-4">🚗</div>
                <h3 class="font-sans font-semibold text-lg text-[#0D1117] mb-2">Tiada Kereta Tersedia</h3>
                <p class="text-[#6B7280] text-sm mb-6">Buat masa ini tiada unit yang tersedia. Hubungi admin untuk tempahan awal.</p>
                <a href="{{ route('contact') }}" class="btn-primary">Hubungi Kami</a>
            </div>
        @endif

    </div>
</section>

{{-- ═══════════════════════════════════════════════
     HOW IT WORKS SECTION (White background)
     ═══════════════════════════════════════════════ --}}
<section class="bg-[#FFFFFF] py-14 lg:py-20">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        
        <!-- Header with Accent Divider -->
        <div class="flex flex-col items-center text-center mb-16">
            <h2 class="font-display text-3xl sm:text-4xl text-[#0D1117] font-normal">Cara Tempahan Mudah</h2>
            <div class="divider-accent mt-4"></div>
            <p class="text-[#6B7280] text-sm sm:text-base mt-4">Tiga langkah ringkas untuk memulakan pemanduan anda</p>
        </div>

        <!-- Grid gaps: gap-8 for feature grids -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <!-- Step 1 -->
            <div class="card-light p-6 text-center space-y-4 hover:border-[#2A5FD4] transition-all">
                <div class="w-12 h-12 bg-[#EEF2FF] text-[#2A5FD4] rounded-sm font-mono-data text-lg font-bold flex items-center justify-center mx-auto">
                    01
                </div>
                <h3 class="font-sans font-semibold text-[#0D1117] text-base">Pilih Kenderaan</h3>
                <p class="text-[#6B7280] text-sm leading-relaxed">
                    Lihat fleet kami di web. Pilih kereta kompak, MPV, sedan, mahupun van yang menepati bajet dan saiz penumpang anda.
                </p>
            </div>

            <!-- Step 2 -->
            <div class="card-light p-6 text-center space-y-4 hover:border-[#2A5FD4] transition-all">
                <div class="w-12 h-12 bg-[#EEF2FF] text-[#2A5FD4] rounded-sm font-mono-data text-lg font-bold flex items-center justify-center mx-auto">
                    02
                </div>
                <h3 class="font-sans font-semibold text-[#0D1117] text-base">Isi Butiran Tempahan</h3>
                <p class="text-[#6B7280] text-sm leading-relaxed">
                    Tentukan tarikh mula dan tamat. Masukkan nama serta nombor telefon untuk pengesahan pantas daripada pihak admin.
                </p>
            </div>

            <!-- Step 3 -->
            <div class="card-light p-6 text-center space-y-4 hover:border-[#16A34A] transition-all">
                <div class="w-12 h-12 bg-[#DCFCE7] text-[#15803D] rounded-sm font-mono-data text-lg font-bold flex items-center justify-center mx-auto">
                    03
                </div>
                <h3 class="font-sans font-semibold text-[#0D1117] text-base">Ambil & Pandu</h3>
                <p class="text-[#6B7280] text-sm leading-relaxed">
                    Selesaikan bayaran deposit, serahkan salinan dokumen pengenalan & lesen memandu semasa mengambil kereta di Rawang.
                </p>
            </div>

        </div>

    </div>
</section>

{{-- ═══════════════════════════════════════════════
     TESTIMONIALS SECTION (Light background)
     ═══════════════════════════════════════════════ --}}
<section class="bg-[#F4F6F9] py-14 lg:py-20">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        
        <!-- Header with Accent Divider -->
        <div class="flex flex-col items-center text-center mb-16">
            <h2 class="font-display text-3xl sm:text-4xl text-[#0D1117] font-normal">Apa Kata Pelanggan Kami</h2>
            <div class="divider-accent mt-4"></div>
            <p class="text-[#6B7280] text-sm sm:text-base mt-4">Kepercayaan dan maklum balas pelanggan adalah kepuasan kami</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <!-- Testimonial 1 -->
            <div class="card-light p-6 flex flex-col justify-between space-y-6">
                <div class="space-y-4">
                    <div class="flex items-center gap-1">
                        @for($i = 0; $i < 5; $i++)
                            <span class="text-[#C5A94B] text-sm">★</span>
                        @endfor
                    </div>
                    <p class="text-[#374151] text-sm leading-relaxed italic">
                        "Sangat berpuas hati menyewa dengan NikaFleet. Kereta bersih, wangi dan diservis dengan cemerlang. Urusan serah kunci sangat lancar di Rawang."
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-sm bg-[#2A5FD4] text-[#FFFFFF] flex items-center justify-center font-bold text-sm">
                        AF
                    </div>
                    <div>
                        <h4 class="font-sans font-semibold text-xs text-[#0D1117]">Ahmad Firdaus</h4>
                        <p class="text-[10px] text-[#6B7280] uppercase tracking-wider font-semibold">Rawang, Selangor</p>
                    </div>
                </div>
            </div>

            <!-- Testimonial 2 -->
            <div class="card-light p-6 flex flex-col justify-between space-y-6">
                <div class="space-y-4">
                    <div class="flex items-center gap-1">
                        @for($i = 0; $i < 5; $i++)
                            <span class="text-[#C5A94B] text-sm">★</span>
                        @endfor
                    </div>
                    <p class="text-[#374151] text-sm leading-relaxed italic">
                        "Kadar harga yang fleksibel dan tiada caj tersembunyi. Khidmat WhatsApp admin sangat responsif menjawab pertanyaan. Highly recommended!"
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-sm bg-[#C5A94B] text-[#0F1117] flex items-center justify-center font-bold text-sm">
                        NA
                    </div>
                    <div>
                        <h4 class="font-sans font-semibold text-xs text-[#0D1117]">Nurul Aisyah</h4>
                        <p class="text-[10px] text-[#6B7280] uppercase tracking-wider font-semibold">Shah Alam, Selangor</p>
                    </div>
                </div>
            </div>

            <!-- Testimonial 3 -->
            <div class="card-light p-6 flex flex-col justify-between space-y-6">
                <div class="space-y-4">
                    <div class="flex items-center gap-1">
                        @for($i = 0; $i < 5; $i++)
                            <span class="text-[#C5A94B] text-sm">★</span>
                        @endfor
                    </div>
                    <p class="text-[#374151] text-sm leading-relaxed italic">
                        "First time menyewa Alza baharu di sini untuk perjalanan keluarga ke utara. Kereta berkeadaan mantap. Deposit dikembalikan dengan pantas selepas pemulangan."
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-sm bg-[#0D1117] text-[#FFFFFF] flex items-center justify-center font-bold text-sm">
                        RH
                    </div>
                    <div>
                        <h4 class="font-sans font-semibold text-xs text-[#0D1117]">Razif Hakim</h4>
                        <p class="text-[10px] text-[#6B7280] uppercase tracking-wider font-semibold">Rawang Perdana</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════
     CONTACT STRIP / CTA BANNER (Slate Dark Background)
     ═══════════════════════════════════════════════ --}}
<section class="bg-[#1C2333] border-t border-b border-[#2E3A4E] py-14 lg:py-20 text-center relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 pointer-events-none">
        <div class="absolute -top-20 -right-20 w-80 h-80 rounded-full bg-[#C5A94B] blur-3xl"></div>
    </div>
    
    <div class="max-w-4xl mx-auto px-6 lg:px-8 space-y-6 relative z-10">
        <span class="text-xs font-bold tracking-widest text-[#C5A94B] uppercase">Nak sewa? Nika kan ada!</span>
        <h2 class="font-display text-3xl sm:text-5xl font-normal text-[#FFFFFF]">Hubungi Kami Untuk Sebarang Pertanyaan</h2>
        <p class="text-[#A8B3C4] text-sm sm:text-base leading-relaxed max-w-xl mx-auto">
            Sama ada maklumat mengenai model kereta, penyewaan mingguan/bulanan, atau harga korporat, kami sedia membantu menjawab persoalan anda.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
            <a href="https://wa.me/601168247599" target="_blank" class="btn-brass w-full sm:w-auto text-center">
                Sewa Melalui WhatsApp
            </a>
            <a href="tel:+601168247599" class="btn-secondary w-full sm:w-auto text-center">
                Hubungi Talian Telefon
            </a>
        </div>
    </div>
</section>

@endsection
