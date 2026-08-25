@extends('layouts.admin')

@section('title', 'Laporan Perbelanjaan')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    @media print {
        #admin-sidebar, #admin-topbar, .filters-panel, .export-actions, footer {
            display: none !important;
        }
        #main-wrapper {
            margin-left: 0 !important;
            padding: 0 !important;
            background: #ffffff !important;
        }
        body {
            background: #ffffff !important;
            font-size: 10px !important;
        }
        .admin-card {
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
            margin-bottom: 20px !important;
        }
        .print-header {
            display: block !important;
            margin-bottom: 20px;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 10px;
        }
        .print-title {
            font-size: 20px;
            font-weight: bold;
            color: #1e293b;
        }
        .dash-table {
            width: 100% !important;
            border-collapse: collapse !important;
        }
        .dash-table th {
            background-color: #f8fafc !important;
            border-bottom: 1px solid #cbd5e1 !important;
            color: #475569 !important;
        }
        .dash-table td {
            border-bottom: 1px solid #f1f5f9 !important;
        }
        .charts-row {
            display: none !important;
        }
    }
    .print-header {
        display: none;
    }
</style>
@endpush

@section('content')
<div style="max-width: 1400px; margin: 0 auto;">

    <!-- Print Header (Hidden on Screen) -->
    <div class="print-header">
        <table style="width: 100%;">
            <tr>
                <td>
                    <h1 style="margin:0; color:#2563eb; font-size:24px; font-weight:bold; text-transform:uppercase;">NikaFleet</h1>
                    <p style="margin:2px 0 0 0; font-size:10px; color:#64748b;">Sistem Pengurusan Fleet & Kewangan</p>
                </td>
                <td style="text-align: right;">
                    <h2 class="print-title" style="margin:0;">Laporan Perbelanjaan</h2>
                    <p style="margin:4px 0 0 0; font-size:10px; color:#475569;">Tempoh: {{ $periodLabel }}</p>
                </td>
            </tr>
        </table>
    </div>

    <!-- Page Header -->
    <div class="mb-7 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                Laporan Perbelanjaan
            </h1>
            <p class="text-gray-500 text-sm mt-0.5">
                Carta kategori perbelanjaan, trend bulanan, dan pecahan terperinci item operasi fleet.
            </p>
        </div>
        <div class="flex items-center gap-2.5 export-actions">
            <button onclick="window.print()"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 border border-gray-200 transition-colors shadow-sm cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Cetak Laporan
            </button>
            <a href="{{ route('admin.laporan.perbelanjaan.export', array_merge(request()->query(), ['type' => 'excel'])) }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-green-700 bg-green-50 hover:bg-green-100 transition-colors border border-green-200 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Eksport Excel
            </a>
            <a href="{{ route('admin.laporan.perbelanjaan.export', array_merge(request()->query(), ['type' => 'pdf'])) }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-red-700 bg-red-50 hover:bg-red-100 transition-colors border border-red-200 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
                Eksport PDF
            </a>
        </div>
    </div>

    <!-- Filters Panel -->
    <div class="admin-card p-5 mb-6 filters-panel bg-white border border-slate-100">
        <form method="GET" action="{{ route('admin.laporan.perbelanjaan') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
            <!-- Preset date range selection -->
            <div>
                <label for="preset" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Pilihan Cepat</label>
                <select name="preset" id="preset" class="w-full text-sm border-gray-300 rounded-xl focus:border-blue-500 focus:ring-blue-500 bg-gray-50">
                    <option value="this_week" {{ $preset === 'this_week' ? 'selected' : '' }}>Minggu Ini</option>
                    <option value="this_month" {{ $preset === 'this_month' ? 'selected' : '' }}>Bulan Ini</option>
                    <option value="last_3_months" {{ $preset === 'last_3_months' ? 'selected' : '' }}>3 Bulan Terakhir</option>
                    <option value="this_year" {{ $preset === 'this_year' ? 'selected' : '' }}>Tahun Ini</option>
                    <option value="custom" {{ $preset === 'custom' ? 'selected' : '' }}>Kustom (Pilih Julat)</option>
                </select>
            </div>

            <!-- Custom Date Range picker -->
            <div id="date_range_wrapper">
                <label for="date_range" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Julat Tarikh</label>
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
                <label for="category" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Kategori</label>
                <select name="category" id="category" class="w-full text-sm border-gray-300 rounded-xl focus:border-blue-500 focus:ring-blue-500 bg-gray-50">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $key => $name)
                        <option value="{{ $key }}" {{ request('category') === $key ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Car Filter -->
            <div>
                <label for="car_id" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Kereta / Belanja</label>
                <select name="car_id" id="car_id" class="w-full text-sm border-gray-300 rounded-xl focus:border-blue-500 focus:ring-blue-500 bg-gray-50">
                    <option value="">Semua Rekod</option>
                    <option value="umum" {{ request('car_id') === 'umum' ? 'selected' : '' }}>Operasi Umum (Tanpa Kereta)</option>
                    @foreach($cars as $car)
                        <option value="{{ $car->id }}" {{ request('car_id') == $car->id ? 'selected' : '' }}>
                            {{ $car->name }} ({{ $car->plate_number }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Submit button -->
            <div>
                <button type="submit" 
                        class="w-full px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold text-sm transition-colors shadow-sm flex items-center justify-center gap-1.5 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Janakan Laporan
                </button>
            </div>
        </form>
    </div>

    <!-- Summary Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
        <!-- Total Expense -->
        <div class="admin-card p-6 bg-red-50 border border-red-100 text-red-800 md:col-span-1 flex flex-col justify-center">
            <span class="text-xs uppercase font-bold tracking-wider opacity-85">Jumlah Perbelanjaan</span>
            <p class="text-3xl font-black mt-3">RM {{ number_format($totalExpense, 2) }}</p>
            <p class="text-xs opacity-75 mt-1">Bagi kriteria tapisan semasa</p>
        </div>

        <!-- Period Info -->
        <div class="admin-card p-6 bg-slate-50 border border-slate-200 text-slate-700 md:col-span-2 flex flex-col justify-center">
            <span class="text-xs uppercase font-bold tracking-wider text-slate-500">Keterangan Tempoh Tapisan</span>
            <p class="text-lg font-bold mt-2 text-slate-900">{{ $periodLabel }}</p>
            <p class="text-xs text-slate-500 mt-1">Laporan yang dipaparkan adalah dinamik berdasarkan tetapan tarikh pilihan anda.</p>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6 charts-row">
        <!-- Category Breakdown Chart (Bar) -->
        <div class="lg:col-span-1 admin-card p-5 bg-white border border-slate-100 flex flex-col">
            <h3 class="text-sm font-bold text-gray-800 border-b border-slate-100 pb-3 uppercase tracking-wider">
                Perbelanjaan Mengikut Kategori
            </h3>
            <div class="flex-1 mt-4 relative min-h-[220px] flex items-center justify-center">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>

        <!-- MoM Expense Trend Chart (Line) -->
        <div class="lg:col-span-2 admin-card p-5 bg-white border border-slate-100 flex flex-col">
            <h3 class="text-sm font-bold text-gray-800 border-b border-slate-100 pb-3 uppercase tracking-wider">
                Trend Perbelanjaan Bulanan
            </h3>
            <div class="flex-1 mt-4 min-h-[220px]">
                <canvas id="trendChart" style="max-height: 250px;"></canvas>
            </div>
        </div>
    </div>

    <!-- Expenses Table Card -->
    <div class="admin-card bg-white border border-slate-100">
        <div class="p-5 border-b border-slate-100">
            <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider">
                Butiran Item Perbelanjaan
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>Tarikh</th>
                        <th>Kategori</th>
                        <th>Keterangan</th>
                        <th>Kereta</th>
                        <th class="text-right">Jumlah</th>
                        <th>Vendor</th>
                        <th>Dibayar Oleh</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($expenses as $expense)
                        <tr>
                            <td class="font-medium text-gray-900">
                                {{ $expense->expense_date ? $expense->expense_date->format('d/m/Y') : '' }}
                            </td>
                            <td>
                                <span class="font-bold text-slate-800">
                                    {{ $categories[$expense->category] ?? $expense->category }}
                                </span>
                            </td>
                            <td class="max-w-xs truncate" title="{{ $expense->description }}">{{ $expense->description }}</td>
                            <td>
                                @if($expense->car)
                                    <span class="font-semibold text-gray-800 block">{{ $expense->car->name }}</span>
                                    <span class="text-[10px] text-gray-500 font-mono">[{{ $expense->car->plate_number }}]</span>
                                @else
                                    <span class="text-slate-400 font-medium text-xs">Operasi Umum</span>
                                @endif
                            </td>
                            <td class="text-right font-bold text-rose-600">RM {{ number_format($expense->amount, 2) }}</td>
                            <td class="text-gray-600 text-xs">{{ $expense->vendor ?? '-' }}</td>
                            <td class="text-gray-600 text-xs">{{ $expense->paid_by ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-8 text-gray-400">
                                Tiada rekod perbelanjaan ditemui untuk tapisan ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Init Date Picker
        const fp = flatpickr("#date_range", {
            mode: "range",
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "d/m/Y",
            allowInput: true,
            onClose: function(selectedDates) {
                if (selectedDates.length === 2) {
                    document.getElementById('preset').value = 'custom';
                }
            }
        });

        // Quick Preset change synchronization
        const presetSelect = document.getElementById('preset');
        presetSelect.addEventListener('change', function() {
            const val = this.value;
            if (val === 'custom') {
                fp.open();
                return;
            }

            const today = new Date();
            let start = new Date();
            let end = new Date();

            if (val === 'this_week') {
                const day = today.getDay();
                const diffToMonday = today.getDate() - day + (day === 0 ? -6 : 1);
                start = new Date(today.setDate(diffToMonday));
                end = new Date(start);
                end.setDate(start.getDate() + 6);
            } else if (val === 'this_month') {
                start = new Date(today.getFullYear(), today.getMonth(), 1);
                end = new Date(today.getFullYear(), today.getMonth() + 1, 0);
            } else if (val === 'last_3_months') {
                start = new Date(today.getFullYear(), today.getMonth() - 3, today.getDate());
                end = today;
            } else if (val === 'this_year') {
                start = new Date(today.getFullYear(), 0, 1);
                end = new Date(today.getFullYear(), 12, 0);
            }

            fp.setDate([start, end]);
        });

        // Category Chart (Bar Chart)
        const catCtx = document.getElementById('categoryChart').getContext('2d');
        const catLabels = @json($chartCategoryLabels);
        const catValues = @json($chartCategoryValues);

        new Chart(catCtx, {
            type: 'bar',
            data: {
                labels: catLabels.length ? catLabels : ['Tiada Data'],
                datasets: [{
                    label: 'Perbelanjaan (RM)',
                    data: catValues.length ? catValues : [0],
                    backgroundColor: 'rgba(239, 68, 68, 0.75)',
                    borderColor: '#ef4444',
                    borderWidth: 1,
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { color: '#94a3b8', font: { size: 10 } },
                        grid: { color: '#f1f5f9' }
                    },
                    x: {
                        ticks: { color: '#475569', font: { size: 10, weight: 'semibold' } },
                        grid: { display: false }
                    }
                }
            }
        });

        // MoM Trend Chart (Line Chart)
        const trendCtx = document.getElementById('trendChart').getContext('2d');
        const trendLabels = @json($chartTrendLabels);
        const trendValues = @json($chartTrendValues);

        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: trendLabels,
                datasets: [{
                    label: 'Aliran Perbelanjaan (RM)',
                    data: trendValues,
                    borderColor: '#ef4444',
                    backgroundColor: 'rgba(239, 68, 68, 0.04)',
                    borderWidth: 3,
                    pointBackgroundColor: '#ef4444',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 4.5,
                    fill: true,
                    tension: 0.25
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { color: '#94a3b8', font: { size: 10 } },
                        grid: { color: '#f1f5f9' }
                    },
                    x: {
                        ticks: { color: '#94a3b8', font: { size: 10 } },
                        grid: { display: false }
                    }
                }
            }
        });
    });
</script>
@endpush
