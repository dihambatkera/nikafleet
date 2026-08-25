@extends('layouts.admin')

@section('title', 'Kewangan: Pendapatan')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    .badge-rental { background-color: #d1fae5; color: #065f46; }
    .badge-deposit { background-color: #dbeafe; color: #1e40af; }
    .badge-penalty { background-color: #fef3c7; color: #92400e; }
    .badge-refund { background-color: #fee2e2; color: #991b1b; }
    .badge-other { background-color: #f3e8ff; color: #6b21a8; }
</style>
@endpush

@section('content')
<div style="max-width: 1400px; margin: 0 auto;" x-data="{ openModal: false }">

    <!-- Flash message -->
    @if(session('success'))
        <div class="flash-success">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- Page Header -->
    <div class="mb-7 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                Modul Pendapatan
            </h1>
            <p class="text-gray-500 text-sm mt-0.5">
                Urus dan tapis rekod pendapatan perniagaan NikaFleet.
            </p>
        </div>
        <div class="flex items-center gap-2.5">
            <button @click="openModal = true"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                + Rekod Pendapatan Manual
            </button>
            <a href="{{ route('admin.kewangan.revenue.export', request()->query()) }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-green-700 bg-green-50 hover:bg-green-100 transition-colors border border-green-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Eksport ke Excel
            </a>
        </div>
    </div>

    <!-- Filters Panel -->
    <div class="admin-card p-5 mb-6">
        <form method="GET" action="{{ route('admin.kewangan.revenue.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <!-- Date range picker -->
            <div>
                <label for="date_range" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">Julat Tarikh</label>
                <input type="text" 
                       name="date_range" 
                       id="date_range" 
                       value="{{ request('date_range') }}" 
                       placeholder="Pilih julat tarikh" 
                       class="w-full text-sm border-gray-300 rounded-xl focus:border-blue-500 focus:ring-blue-500 bg-gray-50"
                       readonly>
            </div>

            <!-- Car filter -->
            <div>
                <label for="car_id" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">Kereta</label>
                <select name="car_id" id="car_id" class="w-full text-sm border-gray-300 rounded-xl focus:border-blue-500 focus:ring-blue-500 bg-gray-50">
                    <option value="">Semua Kereta</option>
                    @foreach($cars as $car)
                        <option value="{{ $car->id }}" {{ request('car_id') == $car->id ? 'selected' : '' }}>
                            {{ $car->name }} ({{ $car->plate_number }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Type filter -->
            <div>
                <label for="type" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">Jenis</label>
                <select name="type" id="type" class="w-full text-sm border-gray-300 rounded-xl focus:border-blue-500 focus:ring-blue-500 bg-gray-50">
                    <option value="">Semua Jenis</option>
                    <option value="rental" {{ request('type') === 'rental' ? 'selected' : '' }}>Sewa</option>
                    <option value="deposit" {{ request('type') === 'deposit' ? 'selected' : '' }}>Deposit</option>
                    <option value="penalty" {{ request('type') === 'penalty' ? 'selected' : '' }}>Penalti</option>
                    <option value="refund" {{ request('type') === 'refund' ? 'selected' : '' }}>Refund</option>
                    <option value="other" {{ request('type') === 'other' ? 'selected' : '' }}>Lain-lain</option>
                </select>
            </div>

            <!-- Actions buttons -->
            <div class="flex gap-2">
                <button type="submit" 
                        class="flex-1 px-4 py-2.5 bg-blue-50 text-blue-700 border border-blue-200 hover:bg-blue-100 rounded-xl font-semibold text-sm transition-colors flex items-center justify-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    Tapis
                </button>
                @if(request()->anyFilled(['date_range', 'car_id', 'type']))
                    <a href="{{ route('admin.kewangan.revenue.index') }}" 
                       class="px-4 py-2.5 bg-gray-50 text-gray-700 border border-gray-200 hover:bg-gray-100 rounded-xl font-semibold text-sm transition-colors flex items-center justify-center">
                        Set Semula
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Revenues List -->
    <div class="admin-card mb-6">
        <div class="overflow-x-auto">
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>Tarikh</th>
                        <th>Keterangan</th>
                        <th>Kereta</th>
                        <th>Kod Tempahan</th>
                        <th>Jenis</th>
                        <th class="text-right">Jumlah (RM)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($revenues as $revenue)
                        <tr>
                            <td class="font-medium">
                                {{ $revenue->revenue_date ? $revenue->revenue_date->format('d/m/Y') : '-' }}
                            </td>
                            <td class="max-w-md truncate" title="{{ $revenue->description }}">
                                {{ $revenue->description }}
                            </td>
                            <td>
                                @if($revenue->car)
                                    <span class="font-semibold text-gray-800">{{ $revenue->car->name }}</span>
                                    <span class="text-xs text-gray-500 block">[{{ $revenue->car->plate_number }}]</span>
                                @else
                                    <span class="text-gray-400">N/A</span>
                                @endif
                            </td>
                            <td>
                                @if($revenue->rental)
                                    <a href="{{ route('admin.bookings.show', $revenue->rental->id) }}" class="text-blue-600 hover:underline font-bold">
                                        {{ $revenue->rental->booking_code }}
                                    </a>
                                @else
                                    <span class="text-gray-400 font-mono">Manual</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $badgeClass = match($revenue->type) {
                                        'rental' => 'badge-rental',
                                        'deposit' => 'badge-deposit',
                                        'penalty' => 'badge-penalty',
                                        'refund' => 'badge-refund',
                                        'other' => 'badge-other',
                                        default => 'bg-gray-100 text-gray-700'
                                    };
                                    $labelText = match($revenue->type) {
                                        'rental' => 'Sewa',
                                        'deposit' => 'Deposit',
                                        'penalty' => 'Penalti',
                                        'refund' => 'Refund',
                                        'other' => 'Lain-lain',
                                        default => ucfirst($revenue->type)
                                    };
                                @endphp
                                <span class="sb {{ $badgeClass }}">
                                    {{ $labelText }}
                                </span>
                            </td>
                            <td class="text-right font-bold {{ $revenue->amount < 0 ? 'text-red-600' : 'text-gray-900' }}">
                                {{ $revenue->amount < 0 ? '-' : '' }}RM {{ number_format(abs($revenue->amount), 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-10 text-gray-400">
                                Tiada rekod pendapatan ditemui bagi tapisan ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($revenues->hasPages())
            <div class="px-5 py-4 border-t border-gray-100">
                {{ $revenues->links() }}
            </div>
        @endif
    </div>

    <!-- Running Total Summary -->
    <div class="admin-card p-5 bg-gradient-to-r from-blue-50 to-indigo-50 border-blue-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <p class="text-xs uppercase font-bold text-blue-800 tracking-wider">Rumusan Pendapatan Tapisan</p>
            <p class="text-gray-500 text-xs mt-1">Mengambil kira penapisan tarikh, kereta, dan jenis pendapatan.</p>
        </div>
        <div class="text-right">
            <span class="text-sm font-semibold text-gray-600 mr-2">Jumlah Pendapatan:</span>
            <span class="text-2xl font-black text-blue-900">RM {{ number_format($totalRevenue, 2) }}</span>
        </div>
    </div>

    <!-- AlpineJS Modal for manual revenue logging -->
    <div x-show="openModal"
         class="fixed inset-0 z-50 overflow-y-auto"
         x-cloak>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Overlay -->
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"
                 @click="openModal = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <!-- Modal Panel -->
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                 x-show="openModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-900" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        + Rekod Pendapatan Manual
                    </h3>
                    <button @click="openModal = false" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form method="POST" action="{{ route('admin.kewangan.revenue.store') }}" class="p-6 space-y-4">
                    @csrf
                    <!-- Date -->
                    <div>
                        <label for="modal_revenue_date" class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1">Tarikh Rekod *</label>
                        <input type="date" 
                               name="revenue_date" 
                               id="modal_revenue_date" 
                               value="{{ date('Y-m-d') }}" 
                               required 
                               class="w-full text-sm border-gray-300 rounded-xl focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <!-- Type -->
                    <div>
                        <label for="modal_type" class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1">Jenis Pendapatan *</label>
                        <select name="type" 
                                id="modal_type" 
                                required 
                                class="w-full text-sm border-gray-300 rounded-xl focus:border-blue-500 focus:ring-blue-500">
                            <option value="rental">Sewa</option>
                            <option value="deposit">Deposit</option>
                            <option value="penalty">Penalti</option>
                            <option value="refund">Refund (Negatif)</option>
                            <option value="other" selected>Lain-lain</option>
                        </select>
                    </div>

                    <!-- Amount -->
                    <div>
                        <label for="modal_amount" class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1">Jumlah (RM) *</label>
                        <input type="number" 
                               step="0.01" 
                               name="amount" 
                               id="modal_amount" 
                               placeholder="0.00" 
                               required 
                               class="w-full text-sm border-gray-300 rounded-xl focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <!-- Car -->
                    <div>
                        <label for="modal_car_id" class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1">Kereta (Opsional)</label>
                        <select name="car_id" 
                                id="modal_car_id" 
                                class="w-full text-sm border-gray-300 rounded-xl focus:border-blue-500 focus:ring-blue-500">
                            <option value="">-- Tiada Hubungan Kereta --</option>
                            @foreach($cars as $car)
                                <option value="{{ $car->id }}">
                                    {{ $car->name }} ({{ $car->plate_number }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="modal_description" class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1">Keterangan / Catatan *</label>
                        <textarea name="description" 
                                  id="modal_description" 
                                  rows="3" 
                                  required 
                                  placeholder="Sila nyatakan butiran pendapatan..." 
                                  class="w-full text-sm border-gray-300 rounded-xl focus:border-blue-500 focus:ring-blue-500"></textarea>
                    </div>

                    <!-- Actions -->
                    <div class="pt-4 flex justify-end gap-2.5">
                        <button type="button" 
                                @click="openModal = false" 
                                class="px-4 py-2 border border-gray-200 text-gray-700 bg-gray-50 hover:bg-gray-100 font-semibold text-sm rounded-xl transition-colors">
                            Batal
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-600 text-white hover:bg-blue-700 font-semibold text-sm rounded-xl transition-colors shadow-sm">
                            Simpan Rekod
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#date_range", {
            mode: "range",
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "d/m/Y",
            allowInput: true
        });
    });
</script>
@endpush
