<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Revenue;
use App\Exports\RevenuesExport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class RevenueController extends Controller
{
    /**
     * Display a listing of revenues.
     */
    public function index(Request $request)
    {
        $query = Revenue::with(['car', 'rental']);

        // Filter by Date Range
        $startDate = null;
        $endDate = null;
        if ($request->filled('date_range')) {
            $dates = explode(' to ', $request->query('date_range'));
            if (count($dates) === 2) {
                $startDate = Carbon::parse($dates[0])->startOfDay();
                $endDate = Carbon::parse($dates[1])->endOfDay();
                $query->whereBetween('revenue_date', [$startDate, $endDate]);
            }
        }

        // Filter by Car
        if ($request->filled('car_id')) {
            $query->where('car_id', $request->query('car_id'));
        }

        // Filter by Type
        if ($request->filled('type')) {
            $query->where('type', $request->query('type'));
        }

        $totalRevenue = $query->sum('amount');
        $revenues = $query->orderBy('revenue_date', 'desc')->paginate(15)->withQueryString();
        
        $cars = Car::orderBy('name')->get();
        $types = Revenue::types();

        return view('admin.kewangan.pendapatan', compact('revenues', 'cars', 'types', 'totalRevenue'));
    }

    /**
     * Store a newly created revenue.
     */
    public function store(Request $request)
    {
        $request->validate([
            'revenue_date' => 'required|date',
            'type' => 'required|in:rental,deposit,penalty,refund,other',
            'amount' => 'required|numeric',
            'description' => 'required|string|max:1000',
            'car_id' => 'nullable|exists:cars,id',
        ]);

        Revenue::create([
            'revenue_date' => $request->input('revenue_date'),
            'type' => $request->input('type'),
            'amount' => $request->input('amount'),
            'description' => $request->input('description'),
            'car_id' => $request->input('car_id'),
        ]);

        return back()->with('success', 'Rekod pendapatan manual berjaya disimpan.');
    }

    /**
     * Export revenue data.
     */
    public function export(Request $request)
    {
        $filters = $request->only(['date_range', 'car_id', 'type']);
        if ($request->filled('date_range')) {
            $dates = explode(' to ', $request->query('date_range'));
            if (count($dates) === 2) {
                $filters['start_date'] = Carbon::parse($dates[0])->startOfDay()->toDateString();
                $filters['end_date'] = Carbon::parse($dates[1])->endOfDay()->toDateString();
            }
        }

        return Excel::download(new RevenuesExport($filters), 'Rekod-Pendapatan-' . now()->format('Ymd') . '.xlsx');
    }
}
