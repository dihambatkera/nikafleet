@extends('layouts.admin')

@section('title', 'Kewangan: Perbelanjaan')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    .badge-expense { background-color: #f3f4f6; color: #374151; border: 1px solid #e5e7eb; }
</style>
@endpush

@section('content')
<div style="max-width: 1400px; margin: 0 auto;" x-data="{ openModal: false, activeReceipt: null }">

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
                Modul Perbelanjaan
            </h1>
            <p class="text-gray-500 text-sm mt-0.5">
                Urus, tapis, dan simpan resit perbelanjaan fleet NikaFleet.
            </p>
        </div>
        <div class="flex items-center gap-2.5">
            <button @click="openModal = true"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                + Rekod Perbelanjaan Baru
            </button>
            <a href="{{ route('admin.kewangan.expense.export', request()->query()) }}"
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
        <form method="GET" action="{{ route('admin.kewangan.expense.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
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

            <!-- Category Filter -->
            <div>
                <label for="category" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">Kategori</label>
                <select name="category" id="category" class="w-full text-sm border-gray-300 rounded-xl focus:border-blue-500 focus:ring-blue-500 bg-gray-50">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $key => $label)
                        @php
                            $emoji = match($key) {
                                'maintenance' => '🔧',
                                'fuel' => '⛽',
                                'insurance' => '🛡️',
                                'cleaning' => '🧹',
                                'repair' => '🔨',
                                'tax' => '📋',
                                'marketing' => '📣',
                                'salary' => '👷',
                                'utilities' => '💡',
                                'other' => '📦',
                                default => '💵'
                            };
                        @endphp
                        <option value="{{ $key }}" {{ request('category') === $key ? 'selected' : '' }}>
                            {{ $emoji }} {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Car filter -->
            <div>
                <label for="car_id" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">Kereta</label>
                <select name="car_id" id="car_id" class="w-full text-sm border-gray-300 rounded-xl focus:border-blue-500 focus:ring-blue-500 bg-gray-50">
                    <option value="">Semua Kereta/Umum</option>
                    <option value="umum" {{ request('car_id') === 'umum' ? 'selected' : '' }}>🏢 Urusan Umum (Syarikat)</option>
                    @foreach($cars as $car)
                        <option value="{{ $car->id }}" {{ request('car_id') == $car->id ? 'selected' : '' }}>
                            🚗 {{ $car->name }} ({{ $car->plate_number }})
                        </option>
                    @endforeach
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
                @if(request()->anyFilled(['date_range', 'car_id', 'category']))
                    <a href="{{ route('admin.kewangan.expense.index') }}" 
                       class="px-4 py-2.5 bg-gray-50 text-gray-700 border border-gray-200 hover:bg-gray-100 rounded-xl font-semibold text-sm transition-colors flex items-center justify-center">
                        Set Semula
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Expense List -->
    <div class="admin-card mb-6">
        <div class="overflow-x-auto">
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>Tarikh</th>
                        <th>Kategori</th>
                        <th>Kereta</th>
                        <th>Vendor / Pembekal</th>
                        <th>Dibayar Oleh</th>
                        <th>Keterangan</th>
                        <th class="text-right">Jumlah (RM)</th>
                        <th class="text-center">Resit</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($expenses as $expense)
                        <tr>
                            <td class="font-medium">
                                {{ $expense->expense_date ? $expense->expense_date->format('d/m/Y') : '-' }}
                            </td>
                            <td>
                                @php
                                    $emoji = match($expense->category) {
                                        'maintenance' => '🔧',
                                        'fuel' => '⛽',
                                        'insurance' => '🛡️',
                                        'cleaning' => '🧹',
                                        'repair' => '🔨',
                                        'tax' => '📋',
                                        'marketing' => '📣',
                                        'salary' => '👷',
                                        'utilities' => '💡',
                                        'other' => '📦',
                                        default => '💵'
                                    };
                                    $label = $categories[$expense->category] ?? ucfirst($expense->category);
                                @endphp
                                <span class="sb badge-expense">
                                    {{ $emoji }} {{ $label }}
                                </span>
                            </td>
                            <td>
                                @if($expense->car)
                                    <span class="font-semibold text-gray-800">{{ $expense->car->name }}</span>
                                    <span class="text-xs text-gray-500 block">[{{ $expense->car->plate_number }}]</span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-xs px-2 py-0.5 rounded bg-slate-100 text-slate-700 font-semibold uppercase">🏢 Umum</span>
                                @endif
                            </td>
                            <td>
                                {{ $expense->vendor ?? '-' }}
                            </td>
                            <td>
                                {{ $expense->paid_by ?? '-' }}
                            </td>
                            <td class="max-w-xs truncate" title="{{ $expense->description }}">
                                {{ $expense->description }}
                            </td>
                            <td class="text-right font-bold text-red-600">
                                RM {{ number_format($expense->amount, 2) }}
                            </td>
                            <td class="text-center">
                                @if($expense->receipt_path)
                                    <button @click="activeReceipt = '{{ asset('storage/' . $expense->receipt_path) }}'"
                                            class="p-1 text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors inline-flex items-center justify-center"
                                            title="Lihat Resit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </button>
                                @else
                                    <span class="text-gray-300 text-xs">Tiada</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-10 text-gray-400">
                                Tiada rekod perbelanjaan ditemui bagi tapisan ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($expenses->hasPages())
            <div class="px-5 py-4 border-t border-gray-100">
                {{ $expenses->links() }}
            </div>
        @endif
    </div>

    <!-- Running Total Summary -->
    <div class="admin-card p-5 bg-gradient-to-r from-red-50 to-pink-50 border-red-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <p class="text-xs uppercase font-bold text-red-800 tracking-wider">Rumusan Perbelanjaan Tapisan</p>
            <p class="text-gray-500 text-xs mt-1">Mengambil kira penapisan tarikh, kategori, dan jenis kereta.</p>
        </div>
        <div class="text-right">
            <span class="text-sm font-semibold text-gray-600 mr-2">Jumlah Perbelanjaan:</span>
            <span class="text-2xl font-black text-red-900">RM {{ number_format($totalExpense, 2) }}</span>
        </div>
    </div>

    <!-- AlpineJS Modal for manual expense logging -->
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
                        + Rekod Perbelanjaan Baru
                    </h3>
                    <button @click="openModal = false" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form method="POST" action="{{ route('admin.kewangan.expense.store') }}" enctype="multipart/form-data" class="p-6 space-y-4">
                    @csrf
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Date -->
                        <div>
                            <label for="modal_expense_date" class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1">Tarikh Belanja *</label>
                            <input type="date" 
                                   name="expense_date" 
                                   id="modal_expense_date" 
                                   value="{{ date('Y-m-d') }}" 
                                   required 
                                   class="w-full text-sm border-gray-300 rounded-xl focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="modal_category" class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1">Kategori *</label>
                            <select name="category" 
                                    id="modal_category" 
                                    required 
                                    class="w-full text-sm border-gray-300 rounded-xl focus:border-blue-500 focus:ring-blue-500">
                                @foreach($categories as $key => $label)
                                    @php
                                        $emoji = match($key) {
                                            'maintenance' => '🔧',
                                            'fuel' => '⛽',
                                            'insurance' => '🛡️',
                                            'cleaning' => '🧹',
                                            'repair' => '🔨',
                                            'tax' => '📋',
                                            'marketing' => '📣',
                                            'salary' => '👷',
                                            'utilities' => '💡',
                                            'other' => '📦',
                                            default => '💵'
                                        };
                                    @endphp
                                    <option value="{{ $key }}">{{ $emoji }} {{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
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
                            <label for="modal_car_id" class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1">Kereta</label>
                            <select name="car_id" 
                                    id="modal_car_id" 
                                    class="w-full text-sm border-gray-300 rounded-xl focus:border-blue-500 focus:ring-blue-500">
                                <option value="">🏢 Umum (Perbelanjaan Perniagaan)</option>
                                @foreach($cars as $car)
                                    <option value="{{ $car->id }}">
                                        🚗 {{ $car->name }} ({{ $car->plate_number }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Vendor -->
                        <div>
                            <label for="modal_vendor" class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1">Vendor/Supplier</label>
                            <input type="text" 
                                   name="vendor" 
                                   id="modal_vendor" 
                                   placeholder="Nama kedai / syarikat" 
                                   class="w-full text-sm border-gray-300 rounded-xl focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <!-- Paid By -->
                        <div>
                            <label for="modal_paid_by" class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1">Dibayar Oleh</label>
                            <input type="text" 
                                   name="paid_by" 
                                   id="modal_paid_by" 
                                   placeholder="Nama kakitangan" 
                                   class="w-full text-sm border-gray-300 rounded-xl focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>

                    <!-- Receipt Upload -->
                    <div>
                        <label for="modal_receipt" class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1">Muat Naik Resit (Imej/PDF - Maks 5MB)</label>
                        <input type="file" 
                               name="receipt" 
                               id="modal_receipt" 
                               accept="image/*,application/pdf"
                               class="w-full text-sm border border-gray-300 bg-gray-50 rounded-xl file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all">
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="modal_description" class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1">Keterangan Perbelanjaan *</label>
                        <textarea name="description" 
                                  id="modal_description" 
                                  rows="3" 
                                  required 
                                  placeholder="Sila nyatakan butiran perbelanjaan..." 
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

    <!-- AlpineJS Modal for receipt previewing -->
    <div x-show="activeReceipt"
         class="fixed inset-0 z-50 overflow-y-auto"
         x-cloak>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Overlay -->
            <div class="fixed inset-0 transition-opacity bg-black bg-opacity-75"
                 @click="activeReceipt = null"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <!-- Modal Panel -->
            <div class="inline-block align-middle bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full"
                 x-show="activeReceipt"
                 @click.away="activeReceipt = null">
                
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-900" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        Paparan Resit / Lampiran
                    </h3>
                    <button @click="activeReceipt = null" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="p-6 flex justify-center bg-gray-100 min-h-[300px]">
                    <template x-if="activeReceipt && activeReceipt.endsWith('.pdf')">
                        <iframe :src="activeReceipt" class="w-full h-[500px] border-0 rounded-xl"></iframe>
                    </template>
                    <template x-if="activeReceipt && !activeReceipt.endsWith('.pdf')">
                        <img :src="activeReceipt" class="max-w-full max-h-[500px] object-contain rounded-xl shadow-sm">
                    </template>
                </div>

                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end">
                    <a :href="activeReceipt" 
                       target="_blank" 
                       class="px-4 py-2 bg-blue-600 text-white hover:bg-blue-700 font-semibold text-sm rounded-xl transition-colors inline-flex items-center gap-1.5 shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        Buka dalam Tab Baru
                    </a>
                </div>
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
