<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Expense;
use App\Models\Revenue;
use App\Models\Rental;
use App\Exports\ProfitLossExport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class ProfitLossController extends Controller
{
    /**
     * Display Profit & Loss dashboard.
     */
    public function index(Request $request)
    {
        $data = $this->calculatePlData($request);
        
        $cars = Car::orderBy('name')->get();
        $chartData = $this->getYearlyChartData();

        return view('admin.kewangan.untung-rugi', array_merge($data, [
            'cars' => $cars,
            'chartData' => $chartData,
            'currentPeriod' => $request->query('period', 'this_month'),
            'currentDateRange' => $request->query('date_range', '')
        ]));
    }

    /**
     * Export Profit & Loss report as PDF.
     */
    public function exportPdf(Request $request)
    {
        $data = $this->calculatePlData($request);
        $pdf = Pdf::loadView('admin.kewangan.pdf-report', $data);
        return $pdf->download('Laporan-Untung-Rugi-' . now()->format('Ymd') . '.pdf');
    }

    /**
     * Export Profit & Loss report as Excel.
     */
    public function exportExcel(Request $request)
    {
        $data = $this->calculatePlData($request);
        
        $filters = [];
        $filters['start_date'] = $data['start_date'];
        $filters['end_date'] = $data['end_date'];

        return Excel::download(new ProfitLossExport($data, $filters), 'Laporan-Untung-Rugi-' . now()->format('Ymd') . '.xlsx');
    }

    /**
     * Core P&L calculation logic.
     */
    private function calculatePlData(Request $request): array
    {
        $period = $request->query('period', 'this_month');
        $start = now()->startOfMonth();
        $end = now()->endOfMonth();
        $periodLabel = 'Bulan Ini (' . now()->translatedFormat('F Y') . ')';

        if ($period === 'this_week') {
            $start = now()->startOfWeek();
            $end = now()->endOfWeek();
            $periodLabel = 'Minggu Ini (' . $start->format('d/m/Y') . ' - ' . $end->format('d/m/Y') . ')';
        } elseif ($period === 'last_month') {
            $start = now()->subMonth()->startOfMonth();
            $end = now()->subMonth()->endOfMonth();
            $periodLabel = 'Bulan Lepas (' . $start->translatedFormat('F Y') . ')';
        } elseif ($period === 'this_year') {
            $start = now()->startOfYear();
            $end = now()->endOfYear();
            $periodLabel = 'Tahun Ini (' . now()->format('Y') . ')';
        } elseif ($period === 'custom' && $request->filled('date_range')) {
            $dates = explode(' to ', $request->query('date_range'));
            if (count($dates) === 2) {
                $start = Carbon::parse($dates[0])->startOfDay();
                $end = Carbon::parse($dates[1])->endOfDay();
                $periodLabel = 'Kustom (' . $start->format('d/m/Y') . ' - ' . $end->format('d/m/Y') . ')';
            }
        }

        // Queries inside Period
        $revenues = Revenue::whereBetween('revenue_date', [$start->toDateString(), $end->toDateString()])->get();
        $expenses = Expense::whereBetween('expense_date', [$start->toDateString(), $end->toDateString()])->get();

        $totalRevenue = $revenues->sum('amount');
        $revenueCount = $revenues->count();

        $totalExpense = $expenses->sum('amount');
        $expenseCount = $expenses->count();

        $netProfit = $totalRevenue - $totalExpense;
        $profitMargin = $totalRevenue > 0 ? ($netProfit / $totalRevenue) * 100 : 0;

        // Breakdown Tables
        $revenueBreakdown = [
            'rental' => $revenues->where('type', 'rental')->sum('amount'),
            'deposit' => $revenues->where('type', 'deposit')->sum('amount'),
            'penalty' => $revenues->where('type', 'penalty')->sum('amount'),
            'other_refund' => $revenues->whereIn('type', ['other', 'refund'])->sum('amount'),
        ];

        $expenseBreakdown = [
            'Penyelenggaraan' => $expenses->where('category', 'maintenance')->sum('amount'),
            'Bahan Api' => $expenses->where('category', 'fuel')->sum('amount'),
            'Insurans' => $expenses->where('category', 'insurance')->sum('amount'),
            'Pembersihan' => $expenses->where('category', 'cleaning')->sum('amount'),
            'Pembaikan' => $expenses->where('category', 'repair')->sum('amount'),
            'Cukai Jalan' => $expenses->where('category', 'tax')->sum('amount'),
            'Pemasaran' => $expenses->where('category', 'marketing')->sum('amount'),
            'Gaji' => $expenses->where('category', 'salary')->sum('amount'),
            'Utiliti' => $expenses->where('category', 'utilities')->sum('amount'),
            'Lain-lain' => $expenses->where('category', 'other')->sum('amount'),
        ];

        // Per-Car Profitability
        $cars = Car::all();
        $carProfitability = [];

        foreach ($cars as $car) {
            $carRev = $revenues->where('car_id', $car->id)->sum('amount');
            $carExp = $expenses->where('car_id', $car->id)->sum('amount');
            $carNet = $carRev - $carExp;
            $carMargin = $carRev > 0 ? ($carNet / $carRev) * 100 : 0;

            $carProfitability[] = [
                'id' => $car->id,
                'name' => $car->name,
                'plate' => $car->plate_number ?? '-',
                'revenue' => $carRev,
                'expense' => $carExp,
                'net' => $carNet,
                'margin' => $carMargin,
                'status' => $carNet >= 0 ? 'UNTUNG' : 'RUGI'
            ];
        }

        // Sort by most profitable
        usort($carProfitability, function ($a, $b) {
            return $b['net'] <=> $a['net'];
        });

        // Smart Insights Logic
        $insights = [];

        // 1. Most profitable car
        if (count($carProfitability) > 0 && $carProfitability[0]['revenue'] > 0) {
            $topCar = $carProfitability[0];
            $insights[] = "🚗 Kereta paling menguntungkan tempoh ini: <strong>{$topCar['name']}</strong> dengan keuntungan bersih <strong>RM " . number_format($topCar['net'], 2) . "</strong> (Margin: " . number_format($topCar['margin'], 1) . "%).";
        } else {
            $insights[] = "🚗 Tiada rekod keuntungan kereta untuk tempoh ini.";
        }

        // 2. Highest expense category
        $maxExpenseCategory = '';
        $maxExpenseAmount = 0;
        foreach ($expenseBreakdown as $cat => $amount) {
            if ($amount > $maxExpenseAmount) {
                $maxExpenseAmount = $amount;
                $maxExpenseCategory = $cat;
            }
        }
        if ($maxExpenseAmount > 0) {
            $insights[] = "📈 Kategori perbelanjaan tertinggi: <strong>{$maxExpenseCategory}</strong> (<strong>RM " . number_format($maxExpenseAmount, 2) . "</strong>).";
        } else {
            $insights[] = "📈 Tiada perbelanjaan direkodkan dalam tempoh ini.";
        }

        // 3. Occupancy rate (fleet occupancy)
        $rentedCarIdsCount = Rental::whereIn('status', ['confirmed', 'active', 'completed'])
            ->where(function ($q) use ($start, $end) {
                $q->whereBetween('start_date', [$start, $end])
                  ->orWhereBetween('end_date', [$start, $end])
                  ->orWhere(function ($q2) use ($start, $end) {
                      $q2->where('start_date', '<=', $start)
                         ->where('end_date', '>=', $end);
                  });
            })
            ->distinct('car_id')
            ->count('car_id');

        $totalCars = $cars->count();
        $occupancyRate = $totalCars > 0 ? ($rentedCarIdsCount / $totalCars) * 100 : 0;
        $insights[] = "🔑 Kadar penginapan fleet (fleet occupancy): <strong>" . number_format($occupancyRate, 1) . "%</strong> ({$rentedCarIdsCount} daripada {$totalCars} kereta disewa).";

        // 4. Average daily revenue
        $days = max(1, $start->diffInDays($end) + 1);
        $avgDailyRevenue = $totalRevenue / $days;
        $insights[] = "📅 Pendapatan harian purata: <strong>RM " . number_format($avgDailyRevenue, 2) . "</strong>.";

        // 5. Warning messages
        if ($netProfit < 0) {
            $insights[] = "⚠️ <span class='text-red-600 font-bold'>Perbelanjaan melebihi pendapatan sebanyak RM " . number_format(abs($netProfit), 2) . ". Sila semak rekod perbelanjaan anda.</span>";
        } elseif ($totalRevenue > 0 && $profitMargin < 20) {
            $insights[] = "💡 <span class='text-amber-600 font-bold'>Margin keuntungan rendah (" . number_format($profitMargin, 1) . "%). Pertimbangkan untuk optimumkan harga sewaan atau kurangkan perbelanjaan operasi.</span>";
        }

        return [
            'start_date' => $start->toDateString(),
            'end_date' => $end->toDateString(),
            'period_label' => $periodLabel,
            'total_revenue' => $totalRevenue,
            'revenue_count' => $revenueCount,
            'total_expense' => $totalExpense,
            'expense_count' => $expenseCount,
            'net_profit' => $netProfit,
            'profit_margin' => $profitMargin,
            'revenue_breakdown' => $revenueBreakdown,
            'expense_breakdown' => $expenseBreakdown,
            'car_profitability' => $carProfitability,
            'insights' => $insights,
        ];
    }

    /**
     * Get yearly chart data.
     */
    private function getYearlyChartData(): array
    {
        $now = Carbon::now();
        $months = collect(range(0, 11))->map(fn($i) => Carbon::create($now->year, $i + 1, 1));

        $revenueData = [];
        $expenseData = [];
        $netData = [];
        $labels = [];

        foreach ($months as $month) {
            $labels[] = $month->translatedFormat('M Y');

            $rev = Revenue::whereYear('revenue_date', $month->year)
                ->whereMonth('revenue_date', $month->month)
                ->sum('amount');

            $exp = Expense::whereYear('expense_date', $month->year)
                ->whereMonth('expense_date', $month->month)
                ->sum('amount');

            $revenueData[] = (float) $rev;
            $expenseData[] = (float) $exp;
            $netData[] = (float) ($rev - $exp);
        }

        return [
            'labels' => $labels,
            'revenue' => $revenueData,
            'expense' => $expenseData,
            'net' => $netData,
        ];
    }
}
