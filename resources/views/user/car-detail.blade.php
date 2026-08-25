@extends('layouts.user')

@section('title', $car->name . ' — Sewa Kereta')
@section('meta_description', 'Sewa ' . $car->name . ' di NikaFleet Rawang. ' . $car->seats . ' tempat duduk, ' . ucfirst($car->transmission) . '. RM ' . number_format($car->price_per_day, 0) . '/hari.')

@section('content')

<div class="max-w-7xl mx-auto px-6 lg:px-8 py-10"
     x-data="{
        lightboxOpen: false,
        currentImage: null,
        activeThumb: 0,
        images: {{ $car->images->map(fn($i) => asset('storage/' . $i->image_path))->toJson() }},

        startDate: '',
        endDate: '',
        totalDays: 0,
        pricePerDay: {{ $car->price_per_day }},
        depositAmount: {{ $car->deposit_amount }},
        totalPrice: 0,

        calcDays() {
            if (!this.startDate || !this.endDate) { this.totalDays = 0; this.totalPrice = 0; return; }
            const s = new Date(this.startDate);
            const e = new Date(this.endDate);
            const diff = Math.round((e - s) / (1000*60*60*24));
            this.totalDays = diff > 0 ? diff : 0;
            this.totalPrice = (this.totalDays * this.pricePerDay) + this.depositAmount;
        },

        openLightbox(idx) {
            this.activeThumb = idx;
            this.currentImage = this.images.length > 0 ? this.images[idx] : null;
            this.lightboxOpen = true;
        }
     }">

    <!-- Breadcrumb (DM Sans) -->
    <nav class="flex items-center gap-2 text-xs uppercase tracking-wider text-[#6B7280] mb-8 font-sans font-semibold">
        <a href="{{ route('home') }}" class="hover:text-[#2A5FD4] transition-colors">Laman Utama</a>
        <span class="text-[#E2E7EE]">/</span>
        <a href="{{ route('cars.index') }}" class="hover:text-[#2A5FD4] transition-colors">Kereta</a>
        <span class="text-[#E2E7EE]">/</span>
        <span class="text-[#0D1117]">{{ $car->name }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

        <!-- ═══ LEFT: Images + Details (7/12 cols) ═══ -->
        <div class="lg:col-span-7 space-y-8">

            <!-- Image Gallery Component -->
            <div class="card-light">

                <!-- Primary Image Display -->
                <div class="relative h-72 sm:h-96 bg-[#F4F6F9] cursor-zoom-in overflow-hidden"
                     @click="openLightbox(activeThumb)">
                    @if($car->images->count() > 0)
                        <img :src="images[activeThumb]"
                             alt="{{ $car->name }}"
                             class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center text-[#A8B3C4]">
                            <svg class="w-32 h-32" viewBox="0 0 100 60" fill="currentColor">
                                <path d="M88,32 L82,18 C80,14 76,12 72,12 L28,12 C24,12 20,14 18,18 L12,32 C8,32 6,34 6,38 L6,46 C6,48 8,50 10,50 L14,50 C14,54 18,58 22,58 C26,58 30,54 30,50 L70,50 C70,54 74,58 78,58 C82,58 86,54 86,50 L90,50 C92,50 94,48 94,46 L94,38 C94,34 92,32 88,32 Z"/>
                            </svg>
                            <p class="mt-2 text-xs font-semibold uppercase tracking-wider">Tiada Media</p>
                        </div>
                    @endif

                    <!-- Absolute Badges -->
                    <div class="absolute top-4 right-4">
                        @if($car->status === 'available')
                            <span class="badge-status-available-light shadow-sm text-xs">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#16A34A] animate-pulse"></span>
                                Tersedia
                            </span>
                        @elseif($car->status === 'rented')
                            <span class="badge-status-unavailable shadow-sm text-xs">Disewa</span>
                        @else
                            <span class="badge-status-maintenance shadow-sm text-xs">Servis</span>
                        @endif
                    </div>

                    @if($car->images->count() > 0)
                        <div class="absolute bottom-4 right-4 bg-[#0D1117]/60 backdrop-blur-sm text-[#FFFFFF] text-[10px] font-semibold px-3 py-1 rounded-sm uppercase tracking-wide">
                            🔍 Klik Untuk Gambar Penuh
                        </div>
                    @endif
                </div>

                <!-- Gallery Thumbnails -->
                @if($car->images->count() > 1)
                    <div class="flex gap-2 p-4 overflow-x-auto border-t border-[#E2E7EE] bg-[#F4F6F9]">
                        @foreach($car->images as $idx => $img)
                            <button @click="activeThumb = {{ $idx }}"
                                    :class="activeThumb === {{ $idx }} ? 'ring-2 ring-[#2A5FD4] border-transparent' : 'border-[#E2E7EE]'"
                                    class="flex-shrink-0 w-16 h-16 bg-[#FFFFFF] rounded-sm overflow-hidden border transition-all hover:opacity-85">
                                <img src="{{ asset('storage/' . $img->image_path) }}" alt="" class="w-full h-full object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Car Details Panel -->
            <div class="card-light p-6 sm:p-8 space-y-6">

                <!-- Header Details -->
                <div class="flex flex-col sm:flex-row justify-between items-start gap-4 pb-6 border-b border-[#E2E7EE]">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="bg-[#EEF2FF] text-[#2A5FD4] text-[10px] font-bold px-2 py-0.5 rounded-sm uppercase tracking-wider">{{ $car->type }}</span>
                            @if($car->year)
                                <span class="bg-[#F4F6F9] text-[#6B7280] text-[10px] font-bold px-2 py-0.5 rounded-sm font-mono-data">{{ $car->year }}</span>
                            @endif
                        </div>
                        <h1 class="font-sans font-bold text-2xl sm:text-3xl text-[#0D1117] leading-tight">
                            {{ $car->name }}
                        </h1>
                        <p class="text-xs text-[#6B7280] uppercase tracking-wider font-semibold mt-1">{{ $car->brand }} • {{ $car->model }}</p>
                        
                        <div class="flex items-center gap-1.5 mt-2">
                            <span class="text-[10px] font-semibold text-[#6B7280] uppercase">No. Plate:</span>
                            <span class="font-mono-data text-xs text-[#374151] font-semibold uppercase bg-[#F4F6F9] px-2 py-0.5 rounded-sm border border-[#E2E7EE]">
                                {{ $car->plate_number }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="text-left sm:text-right flex-shrink-0">
                        <div class="font-mono-data text-3xl font-bold text-[#2A5FD4]">RM{{ number_format($car->price_per_day, 0) }}</div>
                        <div class="text-xs uppercase tracking-wide font-semibold text-[#6B7280] mt-0.5">kadar harian</div>
                        @if($car->price_per_week)
                            <div class="font-mono-data text-xs text-[#374151] font-semibold bg-[#F4F6F9] px-2 py-1 rounded-sm border border-[#E2E7EE] mt-2 inline-block">
                                RM{{ number_format($car->price_per_week, 0) }} / MINGGU
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Notes / Warnings -->
                @if($car->availability_note)
                    <div class="bg-[#FEF3C7] border border-[#FDE68A] text-[#92400E] p-4 rounded-sm text-xs font-medium flex items-start gap-2.5">
                        <span class="text-sm">⚠️</span>
                        <div>
                            <p class="font-semibold uppercase tracking-wider">Nota Ketersediaan:</p>
                            <p class="mt-0.5 leading-relaxed">{{ $car->availability_note }}</p>
                        </div>
                    </div>
                @endif

                <!-- Specification Indicators (DM Sans) -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <div class="bg-[#F4F6F9] border border-[#E2E7EE] rounded-sm p-4 text-center">
                        <div class="text-2xl mb-1.5">👥</div>
                        <div class="font-bold text-[#0D1117] text-sm">{{ $car->seats }} Tempat</div>
                        <div class="text-[10px] text-[#6B7280] uppercase tracking-wider font-semibold mt-0.5">Duduk</div>
                    </div>
                    <div class="bg-[#F4F6F9] border border-[#E2E7EE] rounded-sm p-4 text-center">
                        <div class="text-2xl mb-1.5">⛽</div>
                        <div class="font-bold text-[#0D1117] text-sm capitalize">{{ $car->fuel_type }}</div>
                        <div class="text-[10px] text-[#6B7280] uppercase tracking-wider font-semibold mt-0.5">Bahan Api</div>
                    </div>
                    <div class="bg-[#F4F6F9] border border-[#E2E7EE] rounded-sm p-4 text-center">
                        <div class="text-2xl mb-1.5">⚙️</div>
                        <div class="font-bold text-[#0D1117] text-sm capitalize">{{ $car->transmission }}</div>
                        <div class="text-[10px] text-[#6B7280] uppercase tracking-wider font-semibold mt-0.5">Transmisi</div>
                    </div>
                    <div class="bg-[#F4F6F9] border border-[#E2E7EE] rounded-sm p-4 text-center">
                        <div class="text-2xl mb-1.5">🎨</div>
                        <div class="font-bold text-[#0D1117] text-sm capitalize">{{ $car->color }}</div>
                        <div class="text-[10px] text-[#6B7280] uppercase tracking-wider font-semibold mt-0.5">Warna</div>
                    </div>
                </div>

                <!-- Stats and Deposits -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 bg-[#F4F6F9] p-4 rounded-sm border border-[#E2E7EE]">
                    @if($car->mileage)
                        <div class="flex items-center gap-3">
                            <span class="text-xl">📊</span>
                            <div>
                                <p class="text-[10px] text-[#6B7280] uppercase tracking-wider font-semibold">Jarak Tempuh</p>
                                <p class="font-mono-data text-sm font-bold text-[#0D1117]">{{ number_format($car->mileage) }} KM</p>
                            </div>
                        </div>
                    @endif
                    <div class="flex items-center gap-3">
                        <span class="text-xl">💰</span>
                        <div>
                            <p class="text-[10px] text-[#6B7280] uppercase tracking-wider font-semibold">Deposit Wajib</p>
                            <p class="font-mono-data text-sm font-bold text-[#0D1117]">RM{{ number_format($car->deposit_amount, 0) }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 col-span-1 sm:col-span-2 border-t border-[#E2E7EE] pt-3">
                        <span class="text-xl">📍</span>
                        <div>
                            <p class="text-[10px] text-[#6B7280] uppercase tracking-wider font-semibold">Lokasi Pengambilan</p>
                            <a href="https://maps.google.com/?q={{ urlencode($car->location) }}"
                               target="_blank" rel="noopener noreferrer"
                               class="font-sans text-xs font-bold text-[#2A5FD4] hover:underline uppercase tracking-wider">
                                {{ $car->location }} (Rawang, Selangor) ↗
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Long description content -->
                @if($car->description)
                    <div class="space-y-3 pt-4 border-t border-[#E2E7EE]">
                        <h3 class="font-sans font-bold text-sm text-[#0D1117] uppercase tracking-wider">Keterangan Kenderaan</h3>
                        <div class="text-[#374151] text-sm leading-relaxed font-sans font-light">
                            {!! nl2br(e($car->description)) !!}
                        </div>
                    </div>
                @endif

            </div>

        </div><!-- end left -->

        <!-- ═══ RIGHT: Booking Form (5/12 cols) ═══ -->
        <div class="lg:col-span-5 space-y-6">
            <div class="sticky top-24 space-y-6">

                <!-- Primary Booking Form Card -->
                <div class="card-light p-6 sm:p-8 space-y-6 shadow-md border border-[#E2E7EE]">
                    <div class="flex items-center gap-2">
                        <span class="text-xl">📅</span>
                        <h2 class="font-sans font-bold text-lg text-[#0D1117] uppercase tracking-wide">Tempahan Sewa</h2>
                    </div>

                    @if($car->status !== 'available')
                        <div class="bg-[#FEE2E2] border border-[#FECACA] text-[#B91C1C] p-6 rounded-sm text-center space-y-2">
                            <p class="font-sans font-bold text-sm uppercase tracking-wide">Unit Tidak Ketersediaan</p>
                            <p class="text-xs">Kereta ini sedang disewa atau diservis buat masa ini. Sila cari unit lain.</p>
                            <a href="{{ route('cars.index') }}" class="btn-primary w-full text-xs mt-4">Koleksi Kereta</a>
                        </div>
                    @else
                        <form action="{{ route('bookings.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="hidden" name="car_id" value="{{ $car->id }}">

                            @if($errors->any())
                                <div class="bg-[#FEE2E2] border border-[#FECACA] rounded-sm p-4">
                                    <ul class="text-red-700 text-xs space-y-1">
                                        @foreach($errors->all() as $error)
                                            <li>• {{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Name input -->
                            <div class="space-y-1.5">
                                <label class="form-label-public" for="customer_name">Nama Penuh *</label>
                                <input id="customer_name" name="customer_name" type="text" required
                                       value="{{ old('customer_name') }}"
                                       placeholder="Masukkan nama anda..."
                                       class="form-input-public">
                            </div>

                            <!-- Phone input -->
                            <div class="space-y-1.5">
                                <label class="form-label-public" for="customer_phone">No. Telefon WhatsApp *</label>
                                <input id="customer_phone" name="customer_phone" type="tel" required
                                       value="{{ old('customer_phone') }}"
                                       placeholder="Contoh: 011-6824 7599"
                                       class="form-input-public">
                            </div>

                            <!-- Date fields -->
                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-1.5">
                                    <label class="form-label-public" for="start_date">Tarikh Mula *</label>
                                    <input id="start_date" name="start_date" type="date" required
                                           x-model="startDate"
                                           @change="calcDays()"
                                           min="{{ date('Y-m-d') }}"
                                           value="{{ old('start_date') }}"
                                           class="form-input-public">
                                </div>
                                <div class="space-y-1.5">
                                    <label class="form-label-public" for="end_date">Tarikh Tamat *</label>
                                    <input id="end_date" name="end_date" type="date" required
                                           x-model="endDate"
                                           @change="calcDays()"
                                           :min="startDate || '{{ date('Y-m-d', strtotime('+1 day')) }}'"
                                           value="{{ old('end_date') }}"
                                           class="form-input-public">
                                </div>
                            </div>

                            <!-- Real-time Cost Calculator -->
                            <div x-show="totalDays > 0"
                                 x-transition
                                 class="bg-[#EEF2FF] border border-[#E2E7EE] rounded-sm p-4 space-y-2 font-sans text-xs text-[#374151]">
                                <div class="flex justify-between">
                                    <span>Tempoh Sewa</span>
                                    <span class="font-bold" x-text="totalDays + ' Hari'"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Kadar Harian</span>
                                    <span class="font-mono-data">RM{{ number_format($car->price_per_day, 0) }} x <span x-text="totalDays"></span></span>
                                </div>
                                <div class="flex justify-between text-[#6B7280] border-b border-dashed border-[#E2E7EE] pb-2">
                                    <span>Deposit Sekuriti</span>
                                    <span class="font-mono-data">+ RM{{ number_format($car->deposit_amount, 0) }}</span>
                                </div>
                                <div class="flex justify-between text-[#0D1117] font-bold text-sm pt-1">
                                    <span>Jumlah Anggaran</span>
                                    <span class="font-mono-data text-[#2A5FD4] text-base">RM<span x-text="totalPrice"></span></span>
                                </div>
                                <p class="text-[10px] text-[#6B7280] italic leading-tight pt-1">
                                    * Deposit sekuriti dikembalikan dalam tempoh 24 jam selepas pemulangan kenderaan dalam keadaan baik.
                                </p>
                            </div>

                            <!-- Notes area -->
                            <div class="space-y-1.5">
                                <label class="form-label-public" for="customer_notes">Nota Tambahan (Pilihan)</label>
                                <textarea id="customer_notes" name="customer_notes" rows="3"
                                          placeholder="Tulis sebarang mesej atau permintaan anda di sini..."
                                          class="form-input-public resize-none">{{ old('customer_notes') }}</textarea>
                            </div>

                            <!-- Booking CTA -->
                            <div class="pt-2">
                                <button type="submit" class="btn-primary w-full text-sm py-4">
                                    Hantar Tempahan
                                </button>
                            </div>
                        </form>
                    @endif
                </div>

                <!-- Side WhatsApp help banner -->
                <div class="bg-[#FFFFFF] border border-[#E2E7EE] rounded-sm p-6 text-center space-y-4">
                    <p class="text-xs uppercase tracking-wider font-bold text-[#6B7280]">Perlukan Bantuan Segera?</p>
                    <p class="text-xs text-[#374151] leading-relaxed">
                        Ada sebarang kekeliruan atau ingin menyewa bagi pihak syarikat/korporat? Hubungi admin.
                    </p>
                    <a href="https://wa.me/601168247599?text=Salam%20NikaFleet%21%20Saya%20berminat%20sewa%20{{ urlencode($car->name) }}.%20Boleh%20saya%20tanya%20detail%3F"
                       target="_blank" rel="noopener noreferrer"
                       class="btn-secondary w-full text-xs py-3">
                        WhatsApp Hubungi Admin
                    </a>
                </div>

            </div>
        </div><!-- end right -->

    </div><!-- end grid -->

</div><!-- end container -->

<!-- ═══ LIGHTBOX MODAL ═══ -->
<div x-show="lightboxOpen"
     x-cloak
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-[100] bg-black/95 flex items-center justify-center p-4"
     @click.self="lightboxOpen = false"
     @keydown.escape.window="lightboxOpen = false">

    <div class="relative max-w-4xl w-full">
        <!-- Close Button -->
        <button @click="lightboxOpen = false"
                class="absolute -top-12 right-0 text-[#FFFFFF]/70 hover:text-[#FFFFFF] transition-colors">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <!-- Main Display image -->
        <img :src="currentImage || images[activeThumb]"
             alt="{{ $car->name }}"
             class="w-full max-h-[75vh] object-contain rounded-sm shadow-2xl border border-[#2E3A4E]">

        <!-- Thumbs slider -->
        @if($car->images->count() > 1)
            <div class="flex justify-center gap-2 mt-4">
                @foreach($car->images as $idx => $img)
                    <button @click="activeThumb = {{ $idx }}; currentImage = images[{{ $idx }}]"
                            :class="activeThumb === {{ $idx }} ? 'ring-2 ring-[#C5A94B]' : 'opacity-60'"
                            class="w-12 h-12 rounded-sm overflow-hidden transition-all">
                        <img src="{{ asset('storage/' . $img->image_path) }}" alt="" class="w-full h-full object-cover">
                    </button>
                @endforeach
            </div>
        @endif
    </div>
</div>

@endsection
