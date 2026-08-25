@extends('layouts.admin')

@section('title', 'Laporan Tempahan')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    /* Status Badges */
    .badge-pending { background-color: #fef3c7; color: #92400e; }
    .badge-confirmed { background-color: #dbeafe; color: #1e40af; }
    .badge-active { background-color: #d1fae5; color: #065f46; }
    .badge-completed { background-color: #f3f4f6; color: #475569; }
    .badge-cancelled { background-color: #fee2e2; color: #991b1b; }
    .badge-refunded { background-color: #f3e8ff; color: #6b21a8; }

    /* Print Stylesheet */
    @media print {
        #admin-sidebar, #admin-topbar, .filters-panel, .export-actions, .pagination-wrapper, footer {
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
                    <h2 class="print-title" style="margin:0;">Laporan Tempahan</h2>
                    <p style="margin:4px 0 0 0; font-size:10px; color:#475569;">Tempoh: {{ $periodLabel }}</p>
                </td>
            </tr>
        </table>
    </div>

    <!-- Page Header -->
    <div class="mb-7 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                Laporan Tempahan Kereta
            </h1>
            <p class="text-gray-500 text-sm mt-0.5">
                Senarai terperinci, ringkasan, dan statistik tempahan kenderaan.
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
            <a href="{{ route('admin.laporan.tempahan.export', array_merge(request()->query(), ['type' => 'excel'])) }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-green-700 bg-green-50 hover:bg-green-100 transition-colors border border-green-200 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Eksport Excel
            </a>
            <a href="{{ route('admin.laporan.tempahan.export', array_merge(request()->query(), ['type' => 'pdf'])) }}"
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
        <form method="GET" action="{{ route('admin.laporan.tempahan') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
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

            <!-- Car filter -->
            <div>
                <label for="car_id" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Kereta</label>
                <select name="car_id" id="car_id" class="w-full text-sm border-gray-300 rounded-xl focus:border-blue-500 focus:ring-blue-500 bg-gray-50">
                    <option value="">Semua Kereta</option>
                    @foreach($cars as $car)
                        <option value="{{ $car->id }}" {{ request('car_id') == $car->id ? 'selected' : '' }}>
                            {{ $car->name }} ({{ $car->plate_number }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Status filter -->
            <div>
                <label for="status" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Status</label>
                <select name="status" id="status" class="w-full text-sm border-gray-300 rounded-xl focus:border-blue-500 focus:ring-blue-500 bg-gray-50">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu</option>
                    <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Disahkan</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    <option value="refunded" {{ request('status') === 'refunded' ? 'selected' : '' }}>Dipulangkan</option>
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

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-6">
        <!-- Total Bookings -->
        <div class="admin-card p-5 bg-white border border-slate-100 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <div>
                <span class="text-xs text-gray-500 font-medium">Jumlah Tempahan</span>
                <p class="text-2xl font-bold text-gray-900 leading-tight mt-0.5">{{ $totalBookings }}</p>
            </div>
        </div>

        <!-- Completed -->
        <div class="admin-card p-5 bg-white border border-slate-100 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <div>
                <span class="text-xs text-gray-500 font-medium">Sewa Selesai</span>
                <p class="text-2xl font-bold text-gray-900 leading-tight mt-0.5">{{ $completedBookings }}</p>
            </div>
        </div>

        <!-- Cancelled -->
        <div class="admin-card p-5 bg-white border border-slate-100 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </div>
            <div>
                <span class="text-xs text-gray-500 font-medium">Dibatalkan</span>
                <p class="text-2xl font-bold text-gray-900 leading-tight mt-0.5">{{ $cancelledBookings }}</p>
            </div>
        </div>

        <!-- Revenue -->
        <div class="admin-card p-5 bg-white border border-slate-100 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <span class="text-xs text-gray-500 font-medium">Hasil Hasil Penjanaan</span>
                <p class="text-2xl font-bold text-gray-900 leading-tight mt-0.5">RM {{ number_format($revenueGenerated, 2) }}</p>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6 charts-row">
        <!-- Status Breakdown Chart -->
        <div class="lg:col-span-1 admin-card p-5 bg-white border border-slate-100 flex flex-col">
            <h3 class="text-sm font-bold text-gray-800 border-b border-slate-100 pb-3 uppercase tracking-wider">
                Pecahan Status Tempahan
            </h3>
            <div class="flex-1 mt-4 relative min-h-[220px] flex items-center justify-center">
                <canvas id="statusChart"></canvas>
            </div>
        </div>

        <!-- Trend Line Chart -->
        <div class="lg:col-span-2 admin-card p-5 bg-white border border-slate-100 flex flex-col">
            <h3 class="text-sm font-bold text-gray-800 border-b border-slate-100 pb-3 uppercase tracking-wider">
                Trend Tempahan Harian (Tarikh Mula)
            </h3>
            <div class="flex-1 mt-4 min-h-[220px]">
                <canvas id="bookingsTrendChart" style="max-height: 250px;"></canvas>
            </div>
        </div>
    </div>

    <!-- Bookings Table Card -->
    <div class="admin-card bg-white border border-slate-100">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider">
                Senarai Butiran Tempahan
            </h3>
            <span class="text-xs text-gray-400 font-semibold italic">Menunjukkan {{ $bookings->count() }} rekod pada halaman ini</span>
        </div>
        <div class="overflow-x-auto">
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>Kod</th>
                        <th>Nama Pelanggan</th>
                        <th>No. Telefon</th>
                        <th>Kereta</th>
                        <th>Mula</th>
                        <th>Tamat</th>
                        <th class="text-center">Hari</th>
                        <th class="text-right">Kadar</th>
                        <th class="text-right">Jumlah</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                        <tr>
                            <td class="font-bold text-blue-600">
                                <a href="{{ route('admin.bookings.show', $booking->id) }}" class="hover:underline">
                                    {{ $booking->booking_code }}
                                </a>
                            </td>
                            <td class="font-medium text-gray-800">{{ $booking->customer_name }}</td>
                            <td class="text-gray-500 font-mono text-xs">{{ $booking->customer_phone }}</td>
                            <td>
                                @if($booking->car)
                                    <span class="font-semibold text-gray-800 block">{{ $booking->car->name }}</span>
                                    <span class="text-[10px] text-gray-500 font-mono">[{{ $booking->car->plate_number }}]</span>
                                @else
                                    <span class="text-gray-400">N/A</span>
                                @endif
                            </td>
                            <td class="text-xs">{{ $booking->start_date ? $booking->start_date->format('d/m/Y') : '' }}</td>
                            <td class="text-xs">{{ $booking->end_date ? $booking->end_date->format('d/m/Y') : '' }}</td>
                            <td class="text-center font-semibold text-gray-700">{{ $booking->total_days }} hari</td>
                            <td class="text-right text-gray-500 text-xs">RM {{ number_format($booking->price_per_day, 2) }}</td>
                            <td class="text-right font-bold text-gray-900">RM {{ number_format($booking->total_amount, 2) }}</td>
                            <td class="text-center">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide badge-{{ $booking->status }}">
                                    {{ $booking->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-8 text-gray-400">
                                Tiada rekod tempahan ditemui untuk kriteria tapisan ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($bookings->hasPages())
            <div class="p-4 border-t border-slate-100 pagination-wrapper">
                {{ $bookings->links() }}
            </div>
        @endif
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

            // Compute dates in JS to update flatpickr display
            const today = new Date();
            let start = new Date();
            let end = new Date();

            if (val === 'this_week') {
                // Monday to Sunday of this week
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

        // Status Chart (Doughnut)
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        const statusCounts = @json($statusCounts);
        
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Menunggu', 'Disahkan', 'Aktif', 'Selesai', 'Batal', 'Refund'],
                datasets: [{
                    data: [
                        statusCounts.pending,
                        statusCounts.confirmed,
                        statusCounts.active,
                        statusCounts.completed,
                        statusCounts.cancelled,
                        statusCounts.refunded
                    ],
                    backgroundColor: [
                        '#f59e0b', // pending (amber)
                        '#3b82f6', // confirmed (blue)
                        '#10b981', // active (green)
                        '#6b7280', // completed (gray)
                        '#ef4444', // cancelled (red)
                        '#8b5cf6'  // refunded (purple)
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12,
                            font: { size: 10, weight: 'semibold' },
                            color: '#475569'
                        }
                    }
                },
                cutout: '65%'
            }
        });

        // Trend Chart (Line)
        const trendCtx = document.getElementById('bookingsTrendChart').getContext('2d');
        const trendLabels = @json($chartBookingsLabels);
        const trendValues = @json($chartBookingsValues);

        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: trendLabels.length ? trendLabels : ['Tiada Data'],
                datasets: [{
                    label: 'Tempahan',
                    data: trendValues.length ? trendValues : [0],
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.05)',
                    borderWidth: 3,
                    pointBackgroundColor: '#3b82f6',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: true,
                    tension: 0.3
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
                        ticks: {
                            precision: 0,
                            color: '#94a3b8',
                            font: { size: 10 }
                        },
                        grid: { color: '#f1f5f9' }
                    },
                    x: {
                        ticks: {
                            color: '#94a3b8',
                            font: { size: 10 }
                        },
                        grid: { display: false }
                    }
                }
            }
        });
    });
</script>
@endpush
