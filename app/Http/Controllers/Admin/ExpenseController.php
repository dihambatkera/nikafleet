<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Expense;
use App\Exports\ExpensesExport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExpenseController extends Controller
{
    /**
     * Display a listing of expenses.
     */
    public function index(Request $request)
    {
        $query = Expense::with('car');

        // Filter by Date Range
        if ($request->filled('date_range')) {
            $dates = explode(' to ', $request->query('date_range'));
            if (count($dates) === 2) {
                $query->whereBetween('expense_date', [
                    Carbon::parse($dates[0])->startOfDay(),
                    Carbon::parse($dates[1])->endOfDay()
                ]);
            }
        }

        // Filter by Category
        if ($request->filled('category')) {
            $query->where('category', $request->query('category'));
        }

        // Filter by Car (can be 'umum')
        if ($request->filled('car_id')) {
            $carId = $request->query('car_id');
            if ($carId === 'umum') {
                $query->whereNull('car_id');
            } else {
                $query->where('car_id', $carId);
            }
        }

        $totalExpense = $query->sum('amount');
        $expenses = $query->orderBy('expense_date', 'desc')->paginate(15)->withQueryString();

        $cars = Car::orderBy('name')->get();
        $categories = Expense::categories();

        return view('admin.kewangan.perbelanjaan', compact('expenses', 'cars', 'categories', 'totalExpense'));
    }

    /**
     * Store a newly created expense in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|in:maintenance,fuel,insurance,cleaning,repair,tax,marketing,salary,utilities,other',
            'car_id' => 'nullable|exists:cars,id',
            'amount' => 'required|numeric|min:0.01',
            'expense_date' => 'required|date',
            'description' => 'required|string|max:1000',
            'vendor' => 'nullable|string|max:255',
            'paid_by' => 'nullable|string|max:255',
            'receipt' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:5120', // 5MB max
        ]);

        $receiptPath = null;
        if ($request->hasFile('receipt')) {
            $receiptPath = $request->file('receipt')->store('receipts', 'public');
        }

        Expense::create([
            'category' => $request->input('category'),
            'car_id' => $request->input('car_id'), // null if "umum"
            'amount' => $request->input('amount'),
            'expense_date' => $request->input('expense_date'),
            'description' => $request->input('description'),
            'vendor' => $request->input('vendor'),
            'paid_by' => $request->input('paid_by'),
            'receipt_path' => $receiptPath,
        ]);

        return back()->with('success', 'Rekod perbelanjaan berjaya disimpan.');
    }

    /**
     * Export expense data.
     */
    public function export(Request $request)
    {
        $filters = $request->only(['date_range', 'car_id', 'category']);
        if ($request->filled('date_range')) {
            $dates = explode(' to ', $request->query('date_range'));
            if (count($dates) === 2) {
                $filters['start_date'] = Carbon::parse($dates[0])->startOfDay()->toDateString();
                $filters['end_date'] = Carbon::parse($dates[1])->endOfDay()->toDateString();
            }
        }

        return Excel::download(new ExpensesExport($filters), 'Rekod-Perbelanjaan-' . now()->format('Ymd') . '.xlsx');
    }
}
