@extends('layouts.admin')

@section('title', 'Kewangan: Untung & Rugi')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    .card-untung { background-color: #f0fdf4; border-color: #bbf7d0; color: #15803d; }
    .card-rugi { background-color: #fef2f2; border-color: #fecaca; color: #b91c1c; }
    .text-untung { color: #16a34a; }
    .text-rugi { color: #dc2626; }
</style>
@endpush

@section('content')
<div style="max-width: 1400px; margin: 0 auto;">

    <!-- Page Header -->
    <div class="mb-7 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                Laporan Untung & Rugi (P&L)
            </h1>
            <p class="text-gray-500 text-sm mt-0.5">
                Hab kewangan pintar NikaFleet untuk pemantauan prestasi perniagaan.
            </p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.kewangan.pl.export-pdf', request()->query()) }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-red-700 bg-red-50 hover:bg-red-100 transition-colors border border-red-200 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
                Eksport P&L ke PDF
            </a>
            <a href="{{ route('admin.kewangan.pl.export-excel', request()->query()) }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-green-700 bg-green-50 hover:bg-green-100 transition-colors border border-green-200 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Eksport ke Excel
            </a>
        </div>
    </div>

    <!-- Period Selector Card -->
    <div class="admin-card p-5 mb-6">
        <form method="GET" action="{{ route('admin.kewangan.pl.index') }}" class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <!-- Selector Buttons -->
            <div class="flex flex-wrap items-center gap-1">
                <a href="{{ route('admin.kewangan.pl.index', ['period' => 'this_week']) }}" 
                   class="px-4 py-2 rounded-xl text-sm font-semibold transition-all {{ $currentPeriod === 'this_week' ? 'bg-blue-600 text-white shadow-sm' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Minggu Ini
                </a>
                <a href="{{ route('admin.kewangan.pl.index', ['period' => 'this_month']) }}" 
                   class="px-4 py-2 rounded-xl text-sm font-semibold transition-all {{ $currentPeriod === 'this_month' ? 'bg-blue-600 text-white shadow-sm' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Bulan Ini
                </a>
                <a href="{{ route('admin.kewangan.pl.index', ['period' => 'last_month']) }}" 
                   class="px-4 py-2 rounded-xl text-sm font-semibold transition-all {{ $currentPeriod === 'last_month' ? 'bg-blue-600 text-white shadow-sm' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Bulan Lepas
                </a>
                <a href="{{ route('admin.kewangan.pl.index', ['period' => 'this_year']) }}" 
                   class="px-4 py-2 rounded-xl text-sm font-semibold transition-all {{ $currentPeriod === 'this_year' ? 'bg-blue-600 text-white shadow-sm' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Tahun Ini
                </a>
            </div>

            <!-- Custom date range picker -->
            <div class="flex items-center gap-2">
                <input type="hidden" name="period" value="custom">
                <input type="text" 
                       name="date_range" 
                       id="date_range" 
                       value="{{ $currentPeriod === 'custom' ? $currentDateRange : '' }}" 
                       placeholder="Julat Tarikh Kustom" 
                       class="text-sm border-gray-300 rounded-xl focus:border-blue-500 focus:ring-blue-500 bg-gray-50 max-w-[220px]"
                       readonly>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-50 text-blue-700 border border-blue-200 hover:bg-blue-100 rounded-xl font-semibold text-sm transition-colors flex items-center gap-1">
                    Tapis Kustom
                </button>
                @if($currentPeriod === 'custom')
                    <a href="{{ route('admin.kewangan.pl.index') }}" class="text-xs text-red-600 hover:underline">Reset</a>
                @endif
            </div>
        </form>
    </div>

    {{-- ════════════════════════════════════════════════════════
         ROW 1: SUMMARY CARDS (3 cards)
    ════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
        <!-- Revenue Card -->
        <div class="admin-card p-6 bg-emerald-50 border border-emerald-100 text-emerald-800">
            <div class="flex items-center justify-between">
                <span class="text-xs uppercase font-bold tracking-wider opacity-85">💚 PENDAPATAN</span>
                <span class="text-[10px] bg-emerald-100 text-emerald-800 font-extrabold px-2 py-0.5 rounded-full">INFLOW</span>
            </div>
            <p class="text-3xl font-black mt-3">RM {{ number_format($total_revenue, 2) }}</p>
            <p class="text-xs opacity-75 mt-1">{{ $revenue_count }} transaksi direkodkan</p>
        </div>

        <!-- Expense Card -->
        <div class="admin-card p-6 bg-red-50 border border-red-100 text-red-800">
            <div class="flex items-center justify-between">
                <span class="text-xs uppercase font-bold tracking-wider opacity-85">🔴 PERBELANJAAN</span>
                <span class="text-[10px] bg-red-100 text-red-800 font-extrabold px-2 py-0.5 rounded-full">OUTFLOW</span>
            </div>
            <p class="text-3xl font-black mt-3">RM {{ number_format($total_expense, 2) }}</p>
            <p class="text-xs opacity-75 mt-1">{{ $expense_count }} item direkodkan</p>
        </div>

        <!-- Net Profit Card -->
        @php
            $isProfit = $net_profit >= 0;
            $cardClass = $isProfit ? 'card-untung' : 'card-rugi';
            $badgeColor = $isProfit ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800';
            $badgeText = $isProfit ? '🟢 UNTUNG' : '🔴 RUGI';
        @endphp
        <div class="admin-card p-6 border shadow-sm {{ $cardClass }}">
            <div class="flex items-center justify-between">
                <span class="text-xs uppercase font-bold tracking-wider opacity-85">💛 UNTUNG BERSIH</span>
                <span class="text-[10px] font-extrabold px-2 py-0.5 rounded-full {{ $badgeColor }}">
                    {{ $badgeText }}
                </span>
            </div>
            <p class="text-3xl font-black mt-3">RM {{ number_format($net_profit, 2) }}</p>
            <p class="text-xs opacity-75 mt-1">Margin: <strong>{{ number_format($profit_margin, 1) }}%</strong></p>
        </div>
    </div>

    {{-- ════════════════════════════════════════════════════════
         ROW 2: P&L BREAKDOWN & CHARTS
    ════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Breakdown Tables -->
        <div class="lg:col-span-1 flex flex-col gap-6">
            <!-- Revenue breakdown -->
            <div class="admin-card p-5">
                <h3 class="text-sm font-bold text-gray-800 border-b border-gray-100 pb-3 uppercase tracking-wider">
                    Sumber Pendapatan
                </h3>
                <div class="mt-4 space-y-3">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Pendapatan Sewa</span>
                        <span class="font-bold text-gray-900">RM {{ number_format($revenue_breakdown['rental'], 2) }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Deposit Dikutip</span>
                        <span class="font-bold text-gray-900">RM {{ number_format($revenue_breakdown['deposit'], 2) }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Penalti</span>
                        <span class="font-bold text-gray-900">RM {{ number_format($revenue_breakdown['penalty'], 2) }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Lain-lain / Refund</span>
                        <span class="font-bold text-gray-900">RM {{ number_format($revenue_breakdown['other_refund'], 2) }}</span>
                    </div>
                    <div class="flex items-center justify-between text-base font-black border-t border-dashed border-gray-200 pt-3 text-emerald-700">
                        <span>JUMLAH PENDAPATAN</span>
                        <span>RM {{ number_format($total_revenue, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Expense breakdown -->
            <div class="admin-card p-5">
                <h3 class="text-sm font-bold text-gray-800 border-b border-gray-100 pb-3 uppercase tracking-wider">
                    Pecahan Perbelanjaan
                </h3>
                <div class="mt-4 space-y-3 overflow-y-auto max-h-[350px] pr-1">
                    @foreach($expense_breakdown as $label => $amount)
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600">{{ $label }}</span>
                            <span class="font-bold text-gray-900">RM {{ number_format($amount, 2) }}</span>
                        </div>
                    @endforeach
                    <div class="flex items-center justify-between text-base font-black border-t border-dashed border-gray-200 pt-3 text-red-700">
                        <span>JUMLAH PERBELANJAAN</span>
                        <span>RM {{ number_format($total_expense, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart Container -->
        <div class="lg:col-span-2 admin-card p-5 flex flex-col">
            <h3 class="text-sm font-bold text-gray-800 border-b border-gray-100 pb-3 uppercase tracking-wider flex items-center justify-between">
                <span>Graf P&L Bulanan {{ date('Y') }}</span>
                <span class="text-[10px] text-gray-400 normal-case font-medium">Data Terkumpul Jan - Dis</span>
            </h3>
            <div class="mt-6 flex-1 min-h-[300px] flex items-center">
                <canvas id="plMonthlyChart" class="w-full h-full"></canvas>
            </div>
        </div>
    </div>

    {{-- ════════════════════════════════════════════════════════
         ROW 3: PER-CAR PROFITABILITY & SMART INSIGHTS
    ════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Per-Car Profitability Table -->
        <div class="lg:col-span-2 admin-card">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider">
                    Keuntungan Mengikut Kenderaan
                </h3>
                <span class="text-xs text-gray-500 font-semibold">Tapis: {{ $period_label }}</span>
            </div>
            <div class="overflow-x-auto">
                <table class="dash-table">
                    <thead>
                        <tr>
                            <th>Nama Kereta</th>
                            <th class="text-right">Pendapatan</th>
                            <th class="text-right">Perbelanjaan</th>
                            <th class="text-right">Untung Bersih</th>
                            <th class="text-right">Margin</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($car_profitability as $car)
                            <tr>
                                <td>
                                    <span class="font-bold text-gray-900 block">{{ $car['name'] }}</span>
                                    <span class="text-xs text-gray-500 font-mono">[{{ $car['plate'] }}]</span>
                                </td>
                                <td class="text-right font-medium">
                                    RM {{ number_format($car['revenue'], 2) }}
                                </td>
                                <td class="text-right font-medium text-red-500">
                                    RM {{ number_format($car['expense'], 2) }}
                                </td>
                                <td class="text-right font-bold {{ $car['net'] >= 0 ? 'text-emerald-600' : 'text-red-600' }}">
                                    RM {{ number_format($car['net'], 2) }}
                                </td>
                                <td class="text-right font-bold">
                                    {{ number_format($car['margin'], 1) }}%
                                </td>
                                <td class="text-center">
                                    @if($car['net'] >= 0)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700">🟢 UNTUNG</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-red-50 text-red-700">🔴 RUGI</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-6 text-gray-400">
                                    Tiada rekod data kereta.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Smart Insights Panel -->
        <div class="lg:col-span-1 admin-card p-5 bg-slate-900 border-slate-800 text-white flex flex-col">
            <h3 class="text-sm font-bold border-b border-slate-800 pb-3 uppercase tracking-wider text-blue-400 flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                Analisis Pintar (Smart Insights)
            </h3>
            <div class="mt-4 flex-1 space-y-4 text-sm leading-relaxed">
                @forelse($insights as $insight)
                    <div class="p-3 bg-slate-800/50 border border-slate-800 rounded-xl">
                        {!! $insight !!}
                    </div>
                @empty
                    <p class="text-gray-400 text-center py-10">
                        Tiada analisis dapat dihasilkan untuk tempoh ini.
                    </p>
                @endforelse
            </div>
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
        flatpickr("#date_range", {
            mode: "range",
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "d/m/Y",
            allowInput: true
        });

        // Init P&L Bar Chart
        const ctx = document.getElementById('plMonthlyChart').getContext('2d');
        const chartData = @json($chartData);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartData.labels,
                datasets: [
                    {
                        type: 'line',
                        label: 'Untung/Rugi Bersih',
                        data: chartData.net,
                        borderColor: '#f59e0b',
                        borderWidth: 3,
                        pointBackgroundColor: '#f59e0b',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: false,
                        tension: 0.35,
                        order: 1
                    },
                    {
                        type: 'bar',
                        label: 'Pendapatan',
                        data: chartData.revenue,
                        backgroundColor: 'rgba(59, 130, 246, 0.85)',
                        borderColor: '#2563eb',
                        borderWidth: 1,
                        borderRadius: 6,
                        order: 2
                    },
                    {
                        type: 'bar',
                        label: 'Perbelanjaan',
                        data: chartData.expense,
                        backgroundColor: 'rgba(239, 68, 68, 0.85)',
                        borderColor: '#dc2626',
                        borderWidth: 1,
                        borderRadius: 6,
                        order: 3
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: {
                                family: 'Inter',
                                size: 12,
                                weight: '500'
                            },
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        padding: 12,
                        font: {
                            family: 'Inter'
                        },
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('en-MY', { style: 'currency', currency: 'MYR' }).format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                family: 'Inter',
                                size: 11
                            }
                        }
                    },
                    y: {
                        grid: {
                            color: '#f1f5f9'
                        },
                        ticks: {
                            font: {
                                family: 'Inter',
                                size: 11
                            },
                            callback: function(value) {
                                return 'RM ' + value;
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
