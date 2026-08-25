@extends('layouts.admin')

@section('title', 'Laporan Prestasi Kereta')

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
            padding: 8px 6px !important;
        }
        .dash-table td {
            border-bottom: 1px solid #f1f5f9 !important;
            padding: 8px 6px !important;
        }
    }
    .print-header {
        display: none;
    }
    .sort-link {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        color: inherit;
        text-decoration: none;
    }
    .sort-link:hover {
        color: #1e40af;
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
                    <h2 class="print-title" style="margin:0;">Laporan Prestasi Kereta</h2>
                    <p style="margin:4px 0 0 0; font-size:10px; color:#475569;">Tempoh: {{ $periodLabel }}</p>
                </td>
            </tr>
        </table>
    </div>

    <!-- Page Header -->
    <div class="mb-7 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                Laporan Prestasi Kereta
            </h1>
            <p class="text-gray-500 text-sm mt-0.5">
                Kadar occupancy, sumbangan hasil sewaan, dan perbandingan perbelanjaan bagi setiap kenderaan.
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
            <a href="{{ route('admin.laporan.prestasi-kereta.export', array_merge(request()->query(), ['type' => 'excel'])) }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-green-700 bg-green-50 hover:bg-green-100 transition-colors border border-green-200 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Eksport Excel
            </a>
            <a href="{{ route('admin.laporan.prestasi-kereta.export', array_merge(request()->query(), ['type' => 'pdf'])) }}"
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
        <form method="GET" action="{{ route('admin.laporan.prestasi-kereta') }}" class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-end flex-1">
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
            </div>

            <!-- Janakan Button and hidden sort inputs to keep sorting state when filter is submitted -->
            <div class="flex gap-2">
                <input type="hidden" name="sort_by" value="{{ $sortBy }}">
                <input type="hidden" name="sort_dir" value="{{ $sortDir }}">

                <button type="submit" 
                        class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold text-sm transition-colors shadow-sm flex items-center justify-center gap-1.5 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Janakan Laporan
                </button>
            </div>
        </form>
    </div>

    <!-- Table Card -->
    @php
        // Helper to generate sort link URL
        function getSortLink($column, $currentSortBy, $currentSortDir) {
            $dir = ($currentSortBy === $column && $currentSortDir === 'desc') ? 'asc' : 'desc';
            return request()->fullUrlWithQuery(['sort_by' => $column, 'sort_dir' => $dir]);
        }

        // Helper to render sort icon
        function getSortIcon($column, $currentSortBy, $currentSortDir) {
            if ($currentSortBy !== $column) {
                return '<svg class="w-3.5 h-3.5 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"/></svg>';
            }
            if ($currentSortDir === 'asc') {
                return '<svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>';
            }
            return '<svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>';
        }
    @endphp

    <div class="admin-card bg-white border border-slate-100">
        <div class="overflow-x-auto">
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>
                            <a href="{{ getSortLink('name', $sortBy, $sortDir) }}" class="sort-link">
                                Nama Kereta {!! getSortIcon('name', $sortBy, $sortDir) !!}
                            </a>
                        </th>
                        <th>No. Pendaftaran</th>
                        <th class="text-center">Hari Tersedia</th>
                        <th class="text-center">Hari Disewa</th>
                        <th class="text-center">
                            <a href="{{ getSortLink('occupancy_rate', $sortBy, $sortDir) }}" class="sort-link">
                                Kadar Penginapan % {!! getSortIcon('occupancy_rate', $sortBy, $sortDir) !!}
                            </a>
                        </th>
                        <th class="text-right">
                            <a href="{{ getSortLink('revenue', $sortBy, $sortDir) }}" class="sort-link justify-end">
                                Pendapatan {!! getSortIcon('revenue', $sortBy, $sortDir) !!}
                            </a>
                        </th>
                        <th class="text-right">
                            <a href="{{ getSortLink('expense', $sortBy, $sortDir) }}" class="sort-link justify-end">
                                Perbelanjaan {!! getSortIcon('expense', $sortBy, $sortDir) !!}
                            </a>
                        </th>
                        <th class="text-right">
                            <a href="{{ getSortLink('net', $sortBy, $sortDir) }}" class="sort-link justify-end">
                                Sumbangan Bersih {!! getSortIcon('net', $sortBy, $sortDir) !!}
                            </a>
                        </th>
                        <th class="text-center">
                            <a href="{{ getSortLink('rentals_count', $sortBy, $sortDir) }}" class="sort-link justify-center">
                                Tempahan {!! getSortIcon('rentals_count', $sortBy, $sortDir) !!}
                            </a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($performanceData as $row)
                        <tr>
                            <td class="font-bold text-gray-900">{{ $row['name'] }}</td>
                            <td class="font-mono text-xs text-gray-500">{{ $row['plate_number'] }}</td>
                            <td class="text-center text-gray-600">{{ $row['days_available'] }} hari</td>
                            <td class="text-center text-gray-600">{{ $row['days_rented'] }} hari</td>
                            <td class="text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <div class="w-16 bg-slate-100 rounded-full h-2 overflow-hidden hidden sm:block">
                                        <div class="h-full rounded-full {{ $row['occupancy_rate'] > 60 ? 'bg-emerald-500' : ($row['occupancy_rate'] > 20 ? 'bg-amber-500' : 'bg-slate-400') }}"
                                             style="width: {{ min(100, $row['occupancy_rate']) }}%"></div>
                                    </div>
                                    <span class="font-bold {{ $row['occupancy_rate'] > 50 ? 'text-emerald-600' : 'text-slate-700' }}">
                                        {{ number_format($row['occupancy_rate'], 1) }}%
                                    </span>
                                </div>
                            </td>
                            <td class="text-right font-medium text-gray-800">RM {{ number_format($row['revenue'], 2) }}</td>
                            <td class="text-right text-rose-600 font-medium">RM {{ number_format($row['expense'], 2) }}</td>
                            <td class="text-right font-bold {{ $row['net'] >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                                RM {{ number_format($row['net'], 2) }}
                            </td>
                            <td class="text-center font-medium text-slate-600">
                                {{ $row['rentals_count'] }} kali
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-8 text-gray-400">
                                Tiada data prestasi ditemui.
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
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
    });
</script>
@endpush
