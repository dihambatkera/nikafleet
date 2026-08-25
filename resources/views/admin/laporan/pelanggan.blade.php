@extends('layouts.admin')

@section('title', 'Laporan Pelanggan')

@push('styles')
<style>
    .badge-repeat {
        background-color: #fef3c7;
        color: #d97706;
        border: 1px solid #fde68a;
    }
</style>
@endpush

@section('content')
<div style="max-width: 1200px; margin: 0 auto;">

    <!-- Page Header -->
    <div class="mb-7 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                Laporan & Analitik Pelanggan
            </h1>
            <p class="text-gray-500 text-sm mt-0.5">
                Senarai terperinci pelanggan, kekerapan tempahan, serta nilai sumbangan hasil perniagaan seumur hidup.
            </p>
        </div>
        <div class="flex items-center gap-2.5">
            <a href="{{ route('admin.laporan.pelanggan.export', request()->query()) }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-green-700 bg-green-50 hover:bg-green-100 transition-colors border border-green-200 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Eksport Excel
            </a>
        </div>
    </div>

    <!-- Filters Panel -->
    <div class="admin-card p-5 mb-6 bg-white border border-slate-100">
        <form method="GET" action="{{ route('admin.laporan.pelanggan') }}" class="flex flex-col sm:flex-row gap-4 items-end">
            <!-- Search field -->
            <div class="flex-1 w-full">
                <label for="search" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Carian Nama / No. Telefon</label>
                <div class="relative">
                    <input type="text" 
                           name="search" 
                           id="search" 
                           value="{{ request('search') }}" 
                           placeholder="Masukkan nama pelanggan atau no. telefon..." 
                           class="w-full text-sm border-gray-300 rounded-xl focus:border-blue-500 focus:ring-blue-500 bg-gray-50 pl-10 pr-4 py-2.5">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Submit & Reset Buttons -->
            <div class="flex gap-2 w-full sm:w-auto">
                <button type="submit" 
                        class="flex-1 sm:flex-initial px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold text-sm transition-colors shadow-sm cursor-pointer">
                    Cari
                </button>
                @if(request()->filled('search'))
                    <a href="{{ route('admin.laporan.pelanggan') }}" 
                       class="px-4 py-2.5 bg-gray-50 hover:bg-gray-100 text-gray-700 border border-gray-200 rounded-xl font-semibold text-sm transition-colors flex items-center justify-center">
                        Batal
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table Card -->
    <div class="admin-card bg-white border border-slate-100">
        <div class="overflow-x-auto">
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>Nama Pelanggan</th>
                        <th>No. Telefon</th>
                        <th class="text-center">Jumlah Tempahan</th>
                        <th class="text-right">Jumlah Perbelanjaan</th>
                        <th>Tempahan Pertama</th>
                        <th>Tempahan Terakhir</th>
                        <th class="text-center">Lencana</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                        <tr>
                            <td class="font-bold text-gray-900">{{ $customer->customer_name }}</td>
                            <td class="font-mono text-xs text-gray-500">{{ $customer->customer_phone }}</td>
                            <td class="text-center font-semibold text-gray-700">{{ $customer->total_bookings }} kali</td>
                            <td class="text-right font-bold text-gray-900">RM {{ number_format($customer->total_spent, 2) }}</td>
                            <td class="text-xs text-gray-600">
                                {{ $customer->first_booking ? \Carbon\Carbon::parse($customer->first_booking)->format('d/m/Y') : 'N/A' }}
                            </td>
                            <td class="text-xs text-gray-600">
                                {{ $customer->last_booking ? \Carbon\Carbon::parse($customer->last_booking)->format('d/m/Y') : 'N/A' }}
                            </td>
                            <td class="text-center">
                                @if($customer->total_bookings > 1)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold badge-repeat">
                                        ⭐ Pelanggan Setia
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400 italic">Baru</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-8 text-gray-400">
                                Tiada rekod pelanggan ditemui.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($customers->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $customers->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
