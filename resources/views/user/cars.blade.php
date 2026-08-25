@extends('layouts.user')

@section('title', 'Koleksi Kereta Sewa Rawang — Pilih Kereta Anda')
@section('meta_description', 'Senarai kereta untuk disewa di NikaFleet Rawang. Pelbagai pilihan — Sedan, SUV, MPV, Van. Harga berpatutan.')

@section('content')

<div x-data="{
    search: '{{ request('search') }}',
    filterOpen: false,
    type: '{{ request('type') }}',
    transmission: '{{ request('transmission') }}',
    seats: '{{ request('seats') }}',
    maxPrice: {{ request('max_price', 500) }},

    applyFilters() {
        let params = new URLSearchParams();
        if (this.search) params.set('search', this.search);
        if (this.type) params.set('type', this.type);
        if (this.transmission) params.set('transmission', this.transmission);
        if (this.seats) params.set('seats', this.seats);
        if (this.maxPrice < 500) params.set('max_price', this.maxPrice);
        window.location.search = params.toString();
    },
    clearFilters() {
        window.location.href = '{{ route('cars.index') }}';
    }
}">

<!-- Page Header (Light Section) -->
<div class="bg-[#FFFFFF] border-b border-[#E2E7EE]">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-10">
        <h1 class="font-display text-4xl text-[#0D1117] font-normal mb-2">
            Pilihan Kereta Sewa 🚗
        </h1>
        <p class="text-[#6B7280] text-sm">
            Menunjukkan
            <span class="font-bold text-[#2A5FD4] font-mono-data">{{ $availableCount }}</span>
            kenderaan tersedia daripada
            <span class="font-semibold font-mono-data">{{ $cars->count() }}</span> unit keseluruhan.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-6 lg:px-8 py-14">
    <div class="flex flex-col lg:flex-row gap-8">

        <!-- ═══ FILTER SIDEBAR (Desktop) ═══ -->
        <aside class="hidden lg:block w-64 flex-shrink-0">
            <div class="card-light p-6 sticky top-24 space-y-6">
                <div class="flex items-center justify-between">
                    <h2 class="font-sans font-bold text-[#0D1117] text-sm uppercase tracking-wider">Penapis Carian</h2>
                    <button @click="clearFilters()" class="text-xs text-[#2A5FD4] hover:underline font-semibold uppercase tracking-wider">Sifar</button>
                </div>

                <!-- Type -->
                <div class="space-y-1.5">
                    <label class="form-label-public">Jenis Kereta</label>
                    <select x-model="type" class="form-input-public">
                        <option value="">Semua Jenis</option>
                        <option value="sedan">Sedan</option>
                        <option value="suv">SUV</option>
                        <option value="mpv">MPV</option>
                        <option value="hatchback">Hatchback</option>
                        <option value="van">Van</option>
                        <option value="pickup">Pickup</option>
                    </select>
                </div>

                <!-- Transmission -->
                <div class="space-y-1.5">
                    <label class="form-label-public">Transmisi</label>
                    <select x-model="transmission" class="form-input-public">
                        <option value="">Semua</option>
                        <option value="auto">Automatik</option>
                        <option value="manual">Manual</option>
                    </select>
                </div>

                <!-- Seats -->
                <div class="space-y-1.5">
                    <label class="form-label-public">Bilangan Tempat Duduk</label>
                    <select x-model="seats" class="form-input-public">
                        <option value="">Semua</option>
                        <option value="2">2 Orang</option>
                        <option value="5">5 Orang</option>
                        <option value="7">7 Orang</option>
                        <option value="8">8 Orang</option>
                        <option value="9">9 Orang</option>
                    </select>
                </div>

                <!-- Price Slider -->
                <div class="space-y-2">
                    <div class="flex justify-between items-baseline">
                        <label class="form-label-public mb-0">Harga Maks / Hari</label>
                        <span class="text-sm font-bold text-[#2A5FD4] font-mono-data">RM<span x-text="maxPrice"></span></span>
                    </div>
                    <input type="range" x-model="maxPrice" min="50" max="500" step="10"
                           class="w-full accent-[#2A5FD4] h-1.5 bg-[#E2E7EE] rounded-lg cursor-pointer">
                    <div class="flex justify-between text-[10px] text-[#6B7280] font-mono-data">
                        <span>RM50</span>
                        <span>RM500+</span>
                    </div>
                </div>

                <button @click="applyFilters()" class="btn-primary w-full text-xs">
                    Guna Penapis
                </button>
            </div>
        </aside>

        <!-- ═══ MAIN CONTENT ═══ -->
        <div class="flex-1 min-w-0 space-y-6">

            <!-- Search Bar -->
            <div class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-1">
                    <input x-model="search"
                           @keydown.enter="applyFilters()"
                           type="text"
                           placeholder="Cari nama, jenama, atau model kereta..."
                           class="form-input-public pl-10">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-sm text-[#6B7A8D]">🔍</span>
                </div>
                <div class="flex gap-2">
                    <button @click="applyFilters()" class="btn-primary text-xs flex-1 sm:flex-initial">
                        Cari
                    </button>
                    <!-- Mobile Filter Toggle -->
                    <button @click="filterOpen = !filterOpen" class="btn-secondary text-xs lg:hidden flex-1 sm:flex-initial">
                        Penapis
                    </button>
                </div>
            </div>

            <!-- Mobile Filter Drawer -->
            <div x-show="filterOpen"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-cloak
                 class="lg:hidden card-light p-6 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="form-label-public">Jenis</label>
                        <select x-model="type" class="form-input-public">
                            <option value="">Semua</option>
                            <option value="sedan">Sedan</option>
                            <option value="suv">SUV</option>
                            <option value="mpv">MPV</option>
                            <option value="hatchback">Hatchback</option>
                            <option value="van">Van</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="form-label-public">Transmisi</label>
                        <select x-model="transmission" class="form-input-public">
                            <option value="">Semua</option>
                            <option value="auto">Auto</option>
                            <option value="manual">Manual</option>
                        </select>
                    </div>
                </div>
                
                <div class="space-y-2">
                    <div class="flex justify-between items-baseline">
                        <label class="form-label-public mb-0">Harga Maks</label>
                        <span class="text-sm font-bold text-[#2A5FD4] font-mono-data">RM<span x-text="maxPrice"></span></span>
                    </div>
                    <input type="range" x-model="maxPrice" min="50" max="500" step="10" 
                           class="w-full accent-[#2A5FD4] h-1.5 bg-[#E2E7EE] rounded-lg cursor-pointer">
                </div>

                <div class="flex gap-3">
                    <button @click="applyFilters()" class="btn-primary flex-1 text-xs">Guna</button>
                    <button @click="clearFilters()" class="btn-secondary flex-1 text-xs">Sifar</button>
                </div>
            </div>

            <!-- Active Filters Tags -->
            @if(request()->hasAny(['search', 'type', 'transmission', 'seats', 'max_price']))
                <div class="flex flex-wrap items-center gap-2 pt-1">
                    <span class="text-xs text-[#6B7280] font-sans">Hasil carian untuk:</span>
                    @if(request('search'))
                        <span class="inline-flex items-center gap-1.5 bg-[#EEF2FF] text-[#2A5FD4] text-xs px-2.5 py-1 rounded-sm border border-[#E2E7EE] font-sans font-medium">
                            "{{ request('search') }}"
                        </span>
                    @endif
                    @if(request('type'))
                        <span class="inline-flex items-center gap-1.5 bg-[#EEF2FF] text-[#2A5FD4] text-xs px-2.5 py-1 rounded-sm border border-[#E2E7EE] font-sans font-medium uppercase">
                            {{ request('type') }}
                        </span>
                    @endif
                    @if(request('transmission'))
                        <span class="inline-flex items-center gap-1.5 bg-[#EEF2FF] text-[#2A5FD4] text-xs px-2.5 py-1 rounded-sm border border-[#E2E7EE] font-sans font-medium uppercase">
                            {{ request('transmission') }}
                        </span>
                    @endif
                    <button @click="clearFilters()" class="text-xs text-[#DC2626] font-semibold hover:underline font-sans uppercase tracking-wider ml-1">Sifarkan Carian</button>
                </div>
            @endif

            <!-- Cars Grid (gap-8 for feature grids) -->
            @if($cars->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-8" x-data="{ activeFilter: 'all' }">
                    @foreach($cars as $car)
                        @include('user.partials.car-card', ['car' => $car])
                    @endforeach
                </div>
            @else
                <!-- Empty State Card -->
                <div class="card-light p-12 text-center max-w-xl mx-auto space-y-6">
                    <div class="text-5xl">🔍</div>
                    <div class="space-y-2">
                        <h3 class="font-sans font-bold text-lg text-[#0D1117]">Tiada Kereta Ditemui</h3>
                        <p class="text-[#6B7280] text-sm max-w-sm mx-auto">Sila tukar kriteria penapis atau sifar carian anda untuk melihat semua kereta.</p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3 justify-center">
                        <a href="{{ route('cars.index') }}" class="btn-primary text-xs">Semua Kereta</a>
                        <a href="{{ route('contact') }}" class="btn-secondary text-xs">Hubungi Kami</a>
                    </div>
                </div>
            @endif

        </div><!-- end main content -->
    </div><!-- end flex -->
</div><!-- end container -->

</div><!-- end x-data -->

@endsection
