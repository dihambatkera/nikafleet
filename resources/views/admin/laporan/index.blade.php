@extends('layouts.admin')

@section('title', 'Pusat Laporan')

@section('content')
<div style="max-width: 1200px; margin: 0 auto;">

    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight" style="font-family: 'Plus Jakarta Sans', sans-serif;">
            Pusat Laporan & Analitik
        </h1>
        <p class="text-gray-500 text-sm mt-1">
            Pantau prestasi perniagaan, tempahan, perbelanjaan, dan maklumat pelanggan NikaFleet secara berpusat.
        </p>
    </div>

    <!-- Stats Summary Row -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8">
        <!-- Monthly Revenue Card -->
        <div class="admin-card p-5 bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200">
            <span class="text-[10px] uppercase font-bold tracking-wider text-blue-600 block">Hasil Bulan Ini</span>
            <p class="text-2xl font-black text-blue-900 mt-2">RM {{ number_format($revenueThisMonth, 2) }}</p>
        </div>

        <!-- Monthly Expenses Card -->
        <div class="admin-card p-5 bg-gradient-to-br from-red-50 to-red-100 border border-red-200">
            <span class="text-[10px] uppercase font-bold tracking-wider text-red-600 block">Belanja Bulan Ini</span>
            <p class="text-2xl font-black text-red-900 mt-2">RM {{ number_format($expensesThisMonth, 2) }}</p>
        </div>

        <!-- Monthly Bookings Card -->
        <div class="admin-card p-5 bg-gradient-to-br from-emerald-50 to-emerald-100 border border-emerald-200">
            <span class="text-[10px] uppercase font-bold tracking-wider text-emerald-600 block">Tempahan Baru</span>
            <p class="text-2xl font-black text-emerald-900 mt-2">{{ $totalBookingsThisMonth }} Rekod</p>
        </div>

        <!-- Total Customers Card -->
        <div class="admin-card p-5 bg-gradient-to-br from-amber-50 to-amber-100 border border-amber-200">
            <span class="text-[10px] uppercase font-bold tracking-wider text-amber-600 block">Jumlah Pelanggan</span>
            <p class="text-2xl font-black text-amber-900 mt-2">{{ $totalCustomers }} Orang</p>
        </div>
    </div>

    <!-- Reports Grid Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Booking Report Card -->
        <div class="admin-card p-6 flex flex-col justify-between hover:shadow-md transition-all border border-slate-100 bg-white">
            <div>
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-1" style="font-family: 'Plus Jakarta Sans', sans-serif;">Laporan Tempahan</h3>
                <p class="text-gray-500 text-xs leading-relaxed mb-6">
                    Lihat perincian semua tempahan kereta, tapis mengikut kenderaan atau status sewaan, serta pantau carta aliran tempahan harian.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.laporan.tempahan') }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-xl text-xs font-bold hover:bg-blue-700 transition-colors shadow-sm">
                    Buka Laporan
                </a>
            </div>
        </div>

        <!-- Car Performance Report Card -->
        <div class="admin-card p-6 flex flex-col justify-between hover:shadow-md transition-all border border-slate-100 bg-white">
            <div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-1" style="font-family: 'Plus Jakarta Sans', sans-serif;">Laporan Prestasi Kereta</h3>
                <p class="text-gray-500 text-xs leading-relaxed mb-6">
                    Pantau kadar occupancy (penginapan) bagi setiap kenderaan. Bandingkan hasil sewaan kasar menentang perbelanjaan penyelenggaraan.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.laporan.prestasi-kereta') }}" class="inline-flex items-center justify-center px-4 py-2 bg-emerald-600 text-white rounded-xl text-xs font-bold hover:bg-emerald-700 transition-colors shadow-sm">
                    Buka Laporan
                </a>
            </div>
        </div>

        <!-- Customer Report Card -->
        <div class="admin-card p-6 flex flex-col justify-between hover:shadow-md transition-all border border-slate-100 bg-white">
            <div>
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-1" style="font-family: 'Plus Jakarta Sans', sans-serif;">Laporan Maklumat Pelanggan</h3>
                <p class="text-gray-500 text-xs leading-relaxed mb-6">
                    Senarai semua penyewa berdaftar mahupun tetamu. Jejak kekerapan sewaan, nilai perbelanjaan seumur hidup (LTV), serta kenal pasti pelanggan setia.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.laporan.pelanggan') }}" class="inline-flex items-center justify-center px-4 py-2 bg-amber-600 text-white rounded-xl text-xs font-bold hover:bg-amber-700 transition-colors shadow-sm">
                    Buka Laporan
                </a>
            </div>
        </div>

        <!-- Expense Report Card -->
        <div class="admin-card p-6 flex flex-col justify-between hover:shadow-md transition-all border border-slate-100 bg-white">
            <div>
                <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-1" style="font-family: 'Plus Jakarta Sans', sans-serif;">Laporan Perbelanjaan</h3>
                <p class="text-gray-500 text-xs leading-relaxed mb-6">
                    Analisis ke mana mengalirnya wang keluar (outflow). Tapis mengikut kategori seperti penyelenggaraan dan insurans, serta pantau trend bulanan.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.laporan.perbelanjaan') }}" class="inline-flex items-center justify-center px-4 py-2 bg-rose-600 text-white rounded-xl text-xs font-bold hover:bg-rose-700 transition-colors shadow-sm">
                    Buka Laporan
                </a>
            </div>
        </div>
    </div>

</div>
@endsection
