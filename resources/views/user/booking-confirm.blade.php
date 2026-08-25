@extends('layouts.user')

@section('title', 'Tempahan Diterima — NikaFleet')
@section('meta_description', 'Tempahan anda telah diterima! Kod tempahan: ' . $rental->booking_code)

@section('content')

<div class="min-h-[75vh] flex items-center justify-center py-14 px-6 lg:px-8">
    <div class="max-w-xl w-full space-y-6">

        <!-- Success Header -->
        <div class="text-center space-y-3">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-sm bg-[#DCFCE7] border border-[#BBF7D0] mb-3 shadow-sm">
                <span class="text-[#16A34A] text-4xl">✓</span>
            </div>
            <h1 class="font-display text-3xl sm:text-4xl text-[#0D1117] font-normal leading-tight">
                Tempahan Diterima! 🎉
            </h1>
            <p class="text-[#6B7280] text-sm leading-relaxed">
                Terima kasih! Kami telah menerima borang tempahan anda. Admin kami akan menghubungi anda melalui WhatsApp untuk pengesahan lanjut.
            </p>
        </div>

        <!-- Booking Code Card (Cobalt Accent Background) -->
        <div class="bg-[#2A5FD4] border border-[#1E4DB8] rounded-sm p-6 text-center text-[#FFFFFF] shadow-md space-y-2">
            <p class="text-[#EEF2FF] text-xs uppercase tracking-widest font-semibold">Kod Rujukan Tempahan</p>
            <div class="font-mono-data text-3xl sm:text-4xl font-bold tracking-widest uppercase" style="font-family: 'DM Mono', monospace; letter-spacing: 0.15em;">
                {{ $rental->booking_code }}
            </div>
            <p class="text-[#EEF2FF] text-[10px] uppercase font-medium">Sila Simpan Kod Ini Untuk Rujukan</p>
        </div>

        <!-- Booking Summary (Light Card) -->
        <div class="card-light p-6 sm:p-8 space-y-6">
            <div class="flex items-center justify-between pb-4 border-b border-[#E2E7EE]">
                <h2 class="font-sans font-bold text-sm text-[#0D1117] uppercase tracking-wider">Butiran Ringkasan</h2>
                
                <!-- Status Badge using --color-pending (#9333EA) -->
                <span class="inline-flex items-center gap-1.5 bg-[#F3E8FF] text-[#9333EA] border border-[#E9D5FF] text-[10px] font-semibold uppercase tracking-wider px-2.5 py-1 rounded-sm">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#9333EA] animate-pulse"></span>
                    Menunggu Pengesahan
                </span>
            </div>

            <!-- Car info row -->
            <div class="flex items-start gap-4 pb-4 border-b border-[#E2E7EE]">
                <div class="w-20 h-16 bg-[#F4F6F9] border border-[#E2E7EE] rounded-sm overflow-hidden flex-shrink-0">
                    @if($rental->car && $rental->car->primaryImageUrl && !str_contains($rental->car->primaryImageUrl, 'car-placeholder'))
                        <img src="{{ $rental->car->primaryImageUrl }}" alt="{{ $rental->car->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-[#A8B3C4]">
                            <span class="text-xl">🚗</span>
                        </div>
                    @endif
                </div>
                <div>
                    <h3 class="font-sans font-bold text-[#0D1117] text-base leading-tight">{{ $rental->car->name }}</h3>
                    <p class="text-[10px] text-[#6B7280] uppercase tracking-wider font-semibold mt-1">{{ $rental->car->type }} • {{ $rental->car->transmission }}</p>
                    <p class="text-xs text-[#374151] mt-1">📍 Pengambilan di Rawang</p>
                </div>
            </div>

            <!-- Cost and Info list -->
            <div class="space-y-3 text-xs text-[#374151]">
                <div class="flex justify-between">
                    <span class="text-[#6B7280]">Nama Pelanggan</span>
                    <span class="font-bold text-[#0D1117]">{{ $rental->customer_name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-[#6B7280]">No. Telefon WhatsApp</span>
                    <span class="font-mono-data font-semibold">{{ $rental->customer_phone }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-[#6B7280]">Tarikh Mula Sewa</span>
                    <span class="font-mono-data font-semibold text-[#0D1117]">{{ $rental->start_date->format('d M Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-[#6B7280]">Tarikh Tamat Sewa</span>
                    <span class="font-mono-data font-semibold text-[#0D1117]">{{ $rental->end_date->format('d M Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-[#6B7280]">Tempoh Pemanduan</span>
                    <span class="font-semibold text-[#0D1117]">{{ $rental->total_days }} Hari</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-[#6B7280]">Kadar Harian</span>
                    <span class="font-mono-data font-semibold text-[#0D1117]">RM{{ number_format($rental->price_per_day, 0) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-[#6B7280]">Caj Deposit Sekuriti</span>
                    <span class="font-mono-data font-semibold text-[#0D1117]">RM{{ number_format($rental->deposit_paid, 0) }}</span>
                </div>
                
                <div class="border-t border-[#E2E7EE] pt-4 flex justify-between items-baseline">
                    <span class="font-sans font-bold text-sm text-[#0D1117] uppercase tracking-wider">Jumlah Anggaran Keseluruhan</span>
                    <span class="font-mono-data text-2xl font-bold text-[#2A5FD4]">RM{{ number_format($rental->total_amount, 0) }}</span>
                </div>
            </div>
        </div>

        <!-- Step Instructions -->
        <div class="bg-[#EEF2FF] border border-[#E2E7EE] rounded-sm p-6 space-y-3 font-sans text-xs text-[#374151]">
            <h3 class="font-bold text-[#0D1117] uppercase tracking-wider">📌 Urusan Seterusnya:</h3>
            <ul class="space-y-2 leading-relaxed">
                <li class="flex items-start gap-2">
                    <span class="font-bold text-[#2A5FD4]">1.</span>
                    <span>Admin kami akan menghantar mesej WhatsApp pengesahan ketersediaan kenderaan secepat mungkin.</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="font-bold text-[#2A5FD4]">2.</span>
                    <span>Sediakan dokumen wajib: Salinan IC / Pasport dan Lesen Memandu yang sah.</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="font-bold text-[#2A5FD4]">3.</span>
                    <span>Bayaran deposit sekuriti perlu diselesaikan untuk mengesahkan kunci dan tempahan unit.</span>
                </li>
            </ul>
        </div>

        <!-- Call to Actions -->
        @php
            $startDateStr = $rental->start_date ? $rental->start_date->format('d/m/Y') : '-';
            $endDateStr = $rental->end_date ? $rental->end_date->format('d/m/Y') : '-';
            $carNameStr = $rental->car ? $rental->car->name : '-';
            $waMessage = "Salam NikaFleet! Saya telah menghantar tempahan di web (Kod: {$rental->booking_code}) bagi unit {$carNameStr} untuk tarikh {$startDateStr} hingga {$endDateStr}. Mohon tindakan pengesahan selanjutnya.";
            $waUrl = "https://wa.me/601168247599?text=" . rawurlencode($waMessage);
        @endphp
        <div class="flex flex-col sm:flex-row gap-3 pt-2">
            <a href="{{ $waUrl }}"
               target="_blank" rel="noopener noreferrer"
               class="btn-brass flex-1 justify-center py-4 text-xs">
                Hubungi via WhatsApp
            </a>
            <a href="{{ route('home') }}" class="btn-secondary flex-1 justify-center py-4 text-xs">
                Kembali Utama
            </a>
        </div>

    </div>
</div>

@endsection
