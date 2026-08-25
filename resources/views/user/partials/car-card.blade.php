{{-- Car Card Partial — used in home + cars listing --}}
<div class="card-light flex flex-col h-full" 
     x-show="activeFilter === 'all' || activeFilter === '{{ $car->type }}' || activeFilter === '{{ $car->transmission }}'"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 scale-95"
     x-transition:enter-end="opacity-100 scale-100">

    <!-- Image Gallery wrapper -->
    <div class="relative h-48 bg-[#F4F6F9] overflow-hidden flex-shrink-0">
        @if($car->primaryImageUrl && !str_contains($car->primaryImageUrl, 'car-placeholder'))
            <img src="{{ $car->primaryImageUrl }}"
                 alt="{{ $car->name }}"
                 class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
        @else
            <!-- SVG Car Placeholder -->
            <div class="w-full h-full flex items-center justify-center text-[#A8B3C4]">
                <svg class="w-24 h-24" viewBox="0 0 100 60" fill="currentColor">
                    <path d="M88,32 L82,18 C80,14 76,12 72,12 L28,12 C24,12 20,14 18,18 L12,32 C8,32 6,34 6,38 L6,46 C6,48 8,50 10,50 L14,50 C14,54 18,58 22,58 C26,58 30,54 30,50 L70,50 C70,54 74,58 78,58 C82,58 86,54 86,50 L90,50 C92,50 94,48 94,46 L94,38 C94,34 92,32 88,32 Z M26,22 L50,22 L50,32 L16,32 L20,22 Z M22,54 C20,54 18,52 18,50 C18,48 20,46 22,46 C24,46 26,48 26,50 C26,52 24,54 22,54 Z M78,54 C76,54 74,52 74,50 C74,48 76,46 78,46 C80,46 82,48 82,50 C82,52 80,54 78,54 Z M54,32 L54,22 L74,22 L80,32 Z"/>
                </svg>
            </div>
        @endif

        <!-- Status Badge -->
        <div class="absolute top-3 right-3">
            @if($car->status === 'available')
                <span class="badge-status-available-light">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#16A34A] animate-pulse"></span>
                    Tersedia
                </span>
            @elseif($car->status === 'rented')
                <span class="badge-status-unavailable">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#DC2626]"></span>
                    Disewa
                </span>
            @else
                <span class="badge-status-maintenance">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#D97706]"></span>
                    Servis
                </span>
            @endif
        </div>

        <!-- Type Badge -->
        <div class="absolute top-3 left-3">
            <span class="bg-[#FFFFFF]/90 backdrop-blur-sm text-[#0D1117] text-[10px] font-semibold px-2 py-0.5 rounded-sm uppercase tracking-wider">
                {{ $car->type }}
            </span>
        </div>
    </div>

    <!-- Card Body -->
    <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
        <!-- Title and Plate Number (Plate uses Mono) -->
        <div class="space-y-1">
            <h3 class="font-sans font-bold text-[#0D1117] text-lg leading-tight">
                {{ $car->name }}
            </h3>
            <div class="flex items-center gap-1">
                <span class="text-[10px] font-semibold text-[#6B7280] uppercase">No. Plate:</span>
                <span class="font-mono-data text-xs text-[#374151] font-medium uppercase bg-[#F4F6F9] px-1.5 py-0.5 rounded-sm">
                    {{ $car->plate_number }}
                </span>
            </div>
        </div>

        <!-- Specifications (DM Sans) -->
        <div class="grid grid-cols-3 gap-2 border-t border-b border-[#E2E7EE] py-3 text-center text-xs text-[#374151] font-sans">
            <div>
                <span class="text-[10px] text-[#6B7280] block uppercase font-semibold">Tempat</span>
                <span class="font-semibold block mt-0.5">{{ $car->seats }} Duduk</span>
            </div>
            <div class="border-l border-r border-[#E2E7EE]">
                <span class="text-[10px] text-[#6B7280] block uppercase font-semibold">Transmisi</span>
                <span class="font-semibold block mt-0.5 capitalize">{{ $car->transmission }}</span>
            </div>
            <div>
                <span class="text-[10px] text-[#6B7280] block uppercase font-semibold">Bahan Api</span>
                <span class="font-semibold block mt-0.5 capitalize">{{ $car->fuel_type }}</span>
            </div>
        </div>

        <!-- Pricing details (Uses Mono for currency amounts) -->
        <div class="space-y-1">
            <div class="flex items-baseline justify-between">
                <span class="text-xs text-[#6B7280] font-sans">Harian</span>
                <div>
                    <span class="font-mono-data text-2xl font-bold text-[#2A5FD4]">RM{{ number_format($car->price_per_day, 0) }}</span>
                    <span class="text-[#6B7280] text-xs font-sans">/hari</span>
                </div>
            </div>
            @if($car->price_per_week)
                <div class="flex items-center justify-between text-xs border-t border-dashed border-[#E2E7EE] pt-1">
                    <span class="text-[#6B7280] font-sans">Mingguan</span>
                    <span class="font-mono-data text-[#374151] font-semibold">RM{{ number_format($car->price_per_week, 0) }}/minggu</span>
                </div>
            @endif
        </div>

        <!-- Location info -->
        <div class="flex items-center gap-1.5 text-xs text-[#6B7280] font-sans">
            <span>📍</span>
            <span>Rawang, Selangor</span>
        </div>

        <!-- Action Button -->
        <div class="pt-2">
            @if($car->status === 'available')
                <a href="{{ route('cars.show', $car) }}" class="btn-primary w-full text-xs">
                    Sewa Sekarang
                </a>
            @else
                <a href="{{ route('cars.show', $car) }}" class="w-full text-xs inline-flex items-center justify-center gap-2 bg-[#F4F6F9] border border-[#E2E7EE] text-[#6B7280] font-semibold py-3 px-4 rounded-sm hover:bg-[#E2E7EE] transition-colors cursor-pointer uppercase tracking-wider">
                    Lihat Butiran
                </a>
            @endif
        </div>
    </div>
</div>
