<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Expense;
use App\Models\Rental;
use App\Models\Revenue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BookingReportExport;
use App\Exports\CarPerformanceReportExport;
use App\Exports\CustomerReportExport;
use App\Exports\ExpenseReportExport;

class ReportController extends Controller
{
    // =========================================================================
    // HELPER: DATE RESOLUTION
    // =========================================================================
    private function resolveDateFilters(Request $request): array
    {
        $preset = $request->query('preset', 'this_month');
        $start = now()->startOfMonth();
        $end = now()->endOfMonth();
        $periodLabel = 'Bulan Ini (' . now()->translatedFormat('F Y') . ')';

        if ($preset === 'this_week') {
            $start = now()->startOfWeek();
            $end = now()->endOfWeek();
            $periodLabel = 'Minggu Ini (' . $start->format('d/m/Y') . ' - ' . $end->format('d/m/Y') . ')';
        } elseif ($preset === 'last_3_months') {
            $start = now()->subMonths(3)->startOfDay();
            $end = now()->endOfDay();
            $periodLabel = '3 Bulan Terakhir (' . $start->format('d/m/Y') . ' - ' . $end->format('d/m/Y') . ')';
        } elseif ($preset === 'this_year') {
            $start = now()->startOfYear();
            $end = now()->endOfYear();
            $periodLabel = 'Tahun Ini (' . now()->format('Y') . ')';
        } elseif ($preset === 'custom' && $request->filled('date_range')) {
            $dates = explode(' to ', $request->query('date_range'));
            if (count($dates) === 2) {
                $start = Carbon::parse($dates[0])->startOfDay();
                $end = Carbon::parse($dates[1])->endOfDay();
                $periodLabel = 'Kustom (' . $start->format('d/m/Y') . ' - ' . $end->format('d/m/Y') . ')';
            }
        }

        return [$start, $end, $periodLabel, $preset];
    }

    // =========================================================================
    // INDEX: REPORTS CENTER
    // =========================================================================
    public function index()
    {
        $now = now();
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();

        // High level stats for summary cards
        $totalBookingsThisMonth = Rental::whereBetween('start_date', [$startOfMonth, $endOfMonth])->count();
        $activeRentals = Rental::where('status', 'active')->count();
        $totalCustomers = Rental::whereNotNull('customer_phone')->distinct('customer_phone')->count();
        
        $expensesThisMonth = Expense::whereBetween('expense_date', [$startOfMonth, $endOfMonth])->sum('amount');
        $revenueThisMonth = Revenue::whereBetween('revenue_date', [$startOfMonth, $endOfMonth])->sum('amount');

        return view('admin.laporan.index', compact(
            'totalBookingsThisMonth',
            'activeRentals',
            'totalCustomers',
            'expensesThisMonth',
            'revenueThisMonth'
        ));
    }

    // =========================================================================
    // BOOKING REPORT
    // =========================================================================
    public function bookingReport(Request $request)
    {
        list($start, $end, $periodLabel, $preset) = $this->resolveDateFilters($request);

        // Sub-query logic for bookings overlapping with range
        $query = Rental::with(['car'])
            ->where(function($q) use ($start, $end) {
                $q->whereBetween('start_date', [$start, $end])
                  ->orWhereBetween('end_date', [$start, $end])
                  ->orWhere(function($q2) use ($start, $end) {
                      $q2->where('start_date', '<=', $start)
                         ->where('end_date', '>=', $end);
                  });
            });

        // Filters
        if ($request->filled('car_id')) {
            $query->where('car_id', $request->query('car_id'));
        }
        if ($request->filled('status')) {
            $query->where('status', $request->query('status'));
        }

        // Summary Calculations (Based on the filter result)
        $bookingsForSummary = clone $query;
        $allBookings = $bookingsForSummary->get();

        $totalBookings = $allBookings->count();
        $completedBookings = $allBookings->where('status', 'completed')->count();
        $cancelledBookings = $allBookings->where('status', 'cancelled')->count();

        // Calculate Revenue from the Revenue table for the given period and car filter
        $revQuery = Revenue::whereBetween('revenue_date', [$start, $end]);
        if ($request->filled('car_id')) {
            $revQuery->where('car_id', $request->query('car_id'));
        }
        $revenueGenerated = $revQuery->sum('amount');

        // Paginate for list
        $bookings = $query->orderBy('start_date', 'desc')->paginate(15)->withQueryString();

        // Chart 1: Status Distribution
        $statuses = ['pending', 'confirmed', 'active', 'completed', 'cancelled', 'refunded'];
        $statusCounts = [];
        foreach ($statuses as $st) {
            $statusCounts[$st] = $allBookings->where('status', $st)->count();
        }

        // Chart 2: Bookings per day (start_date)
        $bookingsPerDayRaw = Rental::whereBetween('start_date', [$start, $end]);
        if ($request->filled('car_id')) {
            $bookingsPerDayRaw->where('car_id', $request->query('car_id'));
        }
        if ($request->filled('status')) {
            $bookingsPerDayRaw->where('status', $request->query('status'));
        }
        
        $bookingsPerDayRaw = $bookingsPerDayRaw->select(DB::raw('DATE(start_date) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $chartBookingsLabels = [];
        $chartBookingsValues = [];
        foreach ($bookingsPerDayRaw as $item) {
            $chartBookingsLabels[] = Carbon::parse($item->date)->format('d/m');
            $chartBookingsValues[] = (int) $item->count;
        }

        $cars = Car::orderBy('name')->get();

        return view('admin.laporan.tempahan', compact(
            'bookings',
            'cars',
            'totalBookings',
            'completedBookings',
            'cancelledBookings',
            'revenueGenerated',
            'periodLabel',
            'preset',
            'statusCounts',
            'chartBookingsLabels',
            'chartBookingsValues'
        ));
    }

    public function exportBooking(Request $request)
    {
        list($start, $end, $periodLabel, $preset) = $this->resolveDateFilters($request);
        $type = $request->query('type', 'excel');

        // Fetch query details
        $query = Rental::with(['car'])
            ->where(function($q) use ($start, $end) {
                $q->whereBetween('start_date', [$start, $end])
                  ->orWhereBetween('end_date', [$start, $end])
                  ->orWhere(function($q2) use ($start, $end) {
                      $q2->where('start_date', '<=', $start)
                         ->where('end_date', '>=', $end);
                  });
            });

        if ($request->filled('car_id')) {
            $query->where('car_id', $request->query('car_id'));
        }
        if ($request->filled('status')) {
            $query->where('status', $request->query('status'));
        }

        $bookings = $query->orderBy('start_date', 'desc')->get();

        if ($type === 'pdf') {
            $revQuery = Revenue::whereBetween('revenue_date', [$start, $end]);
            if ($request->filled('car_id')) {
                $revQuery->where('car_id', $request->query('car_id'));
            }
            $revenueGenerated = $revQuery->sum('amount');

            $pdf = Pdf::loadView('admin.laporan.pdf.tempahan', [
                'bookings' => $bookings,
                'period_label' => $periodLabel,
                'revenue_generated' => $revenueGenerated,
                'total_bookings' => $bookings->count(),
                'completed' => $bookings->where('status', 'completed')->count(),
                'cancelled' => $bookings->where('status', 'cancelled')->count(),
            ]);
            return $pdf->download('Laporan-Tempahan-' . now()->format('Ymd') . '.pdf');
        }

        return Excel::download(
            new BookingReportExport($bookings, $periodLabel),
            'Laporan-Tempahan-' . now()->format('Ymd') . '.xlsx'
        );
    }

    // =========================================================================
    // CAR PERFORMANCE REPORT
    // =========================================================================
    public function carPerformanceReport(Request $request)
    {
        list($start, $end, $periodLabel, $preset) = $this->resolveDateFilters($request);

        $totalPeriodDays = max(1, $start->diffInDays($end) + 1);
        $cars = Car::orderBy('name')->get();
        $performanceData = [];

        foreach ($cars as $car) {
            // Overlapping rentals (not cancelled or refunded)
            $rentals = $car->rentals()
                ->whereIn('status', ['confirmed', 'active', 'completed'])
                ->where(function($q) use ($start, $end) {
                    $q->whereBetween('start_date', [$start, $end])
                      ->orWhereBetween('end_date', [$start, $end])
                      ->orWhere(function($q2) use ($start, $end) {
                          $q2->where('start_date', '<=', $start)
                             ->where('end_date', '>=', $end);
                      });
                })
                ->get();

            // Calculate rented days overlapping selected period
            $daysRented = 0;
            foreach ($rentals as $rental) {
                $rentalStart = Carbon::parse($rental->start_date);
                $rentalEnd = Carbon::parse($rental->end_date);

                $overlapStart = $rentalStart->max($start);
                $overlapEnd = $rentalEnd->min($end);

                $days = $overlapStart->diffInDays($overlapEnd) + 1;
                $daysRented += max(0, $days);
            }

            // Cap days rented at total period days
            $daysRented = min($daysRented, $totalPeriodDays);

            // Revenue generated by this car in period
            $revenue = Revenue::where('car_id', $car->id)
                ->whereBetween('revenue_date', [$start, $end])
                ->sum('amount');

            // Expenses incurred by this car in period
            $expense = Expense::where('car_id', $car->id)
                ->whereBetween('expense_date', [$start, $end])
                ->sum('amount');

            $net = $revenue - $expense;
            $occupancyRate = $totalPeriodDays > 0 ? ($daysRented / $totalPeriodDays) * 100 : 0;

            $performanceData[] = [
                'id' => $car->id,
                'name' => $car->name,
                'plate_number' => $car->plate_number,
                'days_rented' => $daysRented,
                'days_available' => $totalPeriodDays,
                'occupancy_rate' => $occupancyRate,
                'revenue' => (float) $revenue,
                'expense' => (float) $expense,
                'net' => (float) $net,
                'rentals_count' => $rentals->count(),
            ];
        }

        // Sorting
        $sortBy = $request->query('sort_by', 'occupancy_rate');
        $sortDir = $request->query('sort_dir', 'desc');

        $collection = collect($performanceData);
        if ($sortDir === 'asc') {
            $collection = $collection->sortBy($sortBy);
        } else {
            $collection = $collection->sortByDesc($sortBy);
        }
        $performanceData = $collection->values()->all();

        return view('admin.laporan.prestasi-kereta', compact(
            'performanceData',
            'periodLabel',
            'preset',
            'sortBy',
            'sortDir'
        ));
    }

    public function exportCarPerformance(Request $request)
    {
        list($start, $end, $periodLabel, $preset) = $this->resolveDateFilters($request);
        $type = $request->query('type', 'excel');

        // We re-calculate performance details for export
        $totalPeriodDays = max(1, $start->diffInDays($end) + 1);
        $cars = Car::orderBy('name')->get();
        $performanceData = [];

        foreach ($cars as $car) {
            $rentals = $car->rentals()
                ->whereIn('status', ['confirmed', 'active', 'completed'])
                ->where(function($q) use ($start, $end) {
                    $q->whereBetween('start_date', [$start, $end])
                      ->orWhereBetween('end_date', [$start, $end])
                      ->orWhere(function($q2) use ($start, $end) {
                          $q2->where('start_date', '<=', $start)
                             ->where('end_date', '>=', $end);
                      });
                })
                ->get();

            $daysRented = 0;
            foreach ($rentals as $rental) {
                $rentalStart = Carbon::parse($rental->start_date);
                $rentalEnd = Carbon::parse($rental->end_date);
                $overlapStart = $rentalStart->max($start);
                $overlapEnd = $rentalEnd->min($end);
                $days = $overlapStart->diffInDays($overlapEnd) + 1;
                $daysRented += max(0, $days);
            }
            $daysRented = min($daysRented, $totalPeriodDays);

            $revenue = Revenue::where('car_id', $car->id)->whereBetween('revenue_date', [$start, $end])->sum('amount');
            $expense = Expense::where('car_id', $car->id)->whereBetween('expense_date', [$start, $end])->sum('amount');
            $net = $revenue - $expense;

            $performanceData[] = [
                'name' => $car->name,
                'plate_number' => $car->plate_number,
                'days_rented' => $daysRented,
                'days_available' => $totalPeriodDays,
                'occupancy_rate' => $totalPeriodDays > 0 ? ($daysRented / $totalPeriodDays) * 100 : 0,
                'revenue' => (float) $revenue,
                'expense' => (float) $expense,
                'net' => (float) $net,
                'rentals_count' => $rentals->count(),
            ];
        }

        // Apply sorting to export just like screen if parameters exist
        if ($request->filled('sort_by')) {
            $sortBy = $request->query('sort_by');
            $sortDir = $request->query('sort_dir', 'desc');
            $collection = collect($performanceData);
            if ($sortDir === 'asc') {
                $collection = $collection->sortBy($sortBy);
            } else {
                $collection = $collection->sortByDesc($sortBy);
            }
            $performanceData = $collection->values()->all();
        }

        if ($type === 'pdf') {
            $pdf = Pdf::loadView('admin.laporan.pdf.prestasi-kereta', [
                'performanceData' => $performanceData,
                'period_label' => $periodLabel
            ]);
            return $pdf->download('Laporan-Prestasi-Kereta-' . now()->format('Ymd') . '.pdf');
        }

        return Excel::download(
            new CarPerformanceReportExport($performanceData, $periodLabel),
            'Laporan-Prestasi-Kereta-' . now()->format('Ymd') . '.xlsx'
        );
    }

    // =========================================================================
    // CUSTOMER REPORT
    // =========================================================================
    public function customerReport(Request $request)
    {
        // For customer report, we show all customers who made bookings
        $query = Rental::select(
                'customer_name',
                'customer_phone',
                DB::raw('COUNT(*) as total_bookings'),
                DB::raw('SUM(CASE WHEN status IN ("confirmed", "active", "completed") THEN total_amount ELSE 0 END) as total_spent'),
                DB::raw('MIN(start_date) as first_booking'),
                DB::raw('MAX(start_date) as last_booking')
            )
            ->whereNotNull('customer_phone')
            ->groupBy('customer_phone', 'customer_name');

        if ($request->filled('search')) {
            $search = $request->query('search');
            $query->where(function($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        $customers = $query->orderBy('total_spent', 'desc')->paginate(15)->withQueryString();

        return view('admin.laporan.pelanggan', compact('customers'));
    }

    public function exportCustomer(Request $request)
    {
        $query = Rental::select(
                'customer_name',
                'customer_phone',
                DB::raw('COUNT(*) as total_bookings'),
                DB::raw('SUM(CASE WHEN status IN ("confirmed", "active", "completed") THEN total_amount ELSE 0 END) as total_spent'),
                DB::raw('MIN(start_date) as first_booking'),
                DB::raw('MAX(start_date) as last_booking')
            )
            ->whereNotNull('customer_phone')
            ->groupBy('customer_phone', 'customer_name');

        if ($request->filled('search')) {
            $search = $request->query('search');
            $query->where(function($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        $customers = $query->orderBy('total_spent', 'desc')->get();

        return Excel::download(
            new CustomerReportExport($customers),
            'Laporan-Pelanggan-' . now()->format('Ymd') . '.xlsx'
        );
    }

    // =========================================================================
    // EXPENSE REPORT
    // =========================================================================
    public function expenseReport(Request $request)
    {
        list($start, $end, $periodLabel, $preset) = $this->resolveDateFilters($request);

        $query = Expense::with('car')->whereBetween('expense_date', [$start, $end]);

        // Filters
        if ($request->filled('category')) {
            $query->where('category', $request->query('category'));
        }
        if ($request->filled('car_id')) {
            $carId = $request->query('car_id');
            if ($carId === 'umum') {
                $query->whereNull('car_id');
            } else {
                $query->where('car_id', $carId);
            }
        }

        $expenses = $query->orderBy('expense_date', 'desc')->get();
        $totalExpense = $expenses->sum('amount');

        // Chart 1: Total by category
        $byCategoryQuery = Expense::whereBetween('expense_date', [$start, $end]);
        if ($request->filled('category')) {
            $byCategoryQuery->where('category', $request->query('category'));
        }
        if ($request->filled('car_id')) {
            $carId = $request->query('car_id');
            if ($carId === 'umum') {
                $byCategoryQuery->whereNull('car_id');
            } else {
                $byCategoryQuery->where('car_id', $carId);
            }
        }

        $byCategoryRaw = $byCategoryQuery->select('category', DB::raw('SUM(amount) as total'))
            ->groupBy('category')
            ->get();

        $categoriesMap = Expense::categories();
        $chartCategoryLabels = [];
        $chartCategoryValues = [];
        foreach ($byCategoryRaw as $item) {
            $chartCategoryLabels[] = $categoriesMap[$item->category] ?? $item->category;
            $chartCategoryValues[] = (float) $item->total;
        }

        // Chart 2: Month-over-month trend (last 6 months if range is short, else months within range)
        $trendStart = $start->copy()->startOfMonth();
        $trendEnd = $end->copy()->endOfMonth();
        if ($start->diffInMonths($end) < 2) {
            $trendStart = now()->subMonths(5)->startOfMonth();
            $trendEnd = now()->endOfMonth();
        }

        $chartTrendLabels = [];
        $chartTrendValues = [];
        $current = $trendStart->copy();
        while ($current->lte($trendEnd)) {
            $chartTrendLabels[] = $current->translatedFormat('M Y');
            
            $trendQuery = Expense::whereYear('expense_date', $current->year)
                ->whereMonth('expense_date', $current->month);

            if ($request->filled('category')) {
                $trendQuery->where('category', $request->query('category'));
            }
            if ($request->filled('car_id')) {
                $carId = $request->query('car_id');
                if ($carId === 'umum') {
                    $trendQuery->whereNull('car_id');
                } else {
                    $trendQuery->where('car_id', $carId);
                }
            }

            $chartTrendValues[] = (float) $trendQuery->sum('amount');
            $current->addMonth();
        }

        $cars = Car::orderBy('name')->get();
        $categories = Expense::categories();

        return view('admin.laporan.perbelanjaan', compact(
            'expenses',
            'cars',
            'categories',
            'totalExpense',
            'periodLabel',
            'preset',
            'chartCategoryLabels',
            'chartCategoryValues',
            'chartTrendLabels',
            'chartTrendValues'
        ));
    }

    public function exportExpense(Request $request)
    {
        list($start, $end, $periodLabel, $preset) = $this->resolveDateFilters($request);
        $type = $request->query('type', 'excel');

        $query = Expense::with('car')->whereBetween('expense_date', [$start, $end]);

        if ($request->filled('category')) {
            $query->where('category', $request->query('category'));
        }
        if ($request->filled('car_id')) {
            $carId = $request->query('car_id');
            if ($carId === 'umum') {
                $query->whereNull('car_id');
            } else {
                $query->where('car_id', $carId);
            }
        }

        $expenses = $query->orderBy('expense_date', 'desc')->get();

        if ($type === 'pdf') {
            $pdf = Pdf::loadView('admin.laporan.pdf.perbelanjaan', [
                'expenses' => $expenses,
                'period_label' => $periodLabel,
                'total_expense' => $expenses->sum('amount'),
            ]);
            return $pdf->download('Laporan-Perbelanjaan-' . now()->format('Ymd') . '.pdf');
        }

        return Excel::download(
            new ExpenseReportExport($expenses, $periodLabel),
            'Laporan-Perbelanjaan-' . now()->format('Ymd') . '.xlsx'
        );
    }

    /**
     * Show report by type.
     */
    public function show(Request $request, $type)
    {
        switch ($type) {
            case 'tempahan':
            case 'booking':
                return $this->bookingReport($request);
            case 'prestasi-kereta':
            case 'car-performance':
                return $this->carPerformanceReport($request);
            case 'pelanggan':
            case 'customer':
                return $this->customerReport($request);
            case 'perbelanjaan':
            case 'expense':
                return $this->expenseReport($request);
            default:
                return $this->index();
        }
    }
}

