<?php

namespace App\Exports;

use App\Models\Expense;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExpensesExport implements FromCollection, WithHeadings, WithMapping, WithTitle, ShouldAutoSize
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Expense::with(['car']);

        if (!empty($this->filters['car_id'])) {
            if ($this->filters['car_id'] === 'umum') {
                $query->whereNull('car_id');
            } else {
                $query->where('car_id', $this->filters['car_id']);
            }
        }

        if (!empty($this->filters['category'])) {
            $query->where('category', $this->filters['category']);
        }

        if (!empty($this->filters['start_date']) && !empty($this->filters['end_date'])) {
            $query->whereBetween('expense_date', [$this->filters['start_date'], $this->filters['end_date']]);
        }

        return $query->orderBy('expense_date', 'desc')->get();
    }

    public function title(): string
    {
        return 'Perbelanjaan';
    }

    public function headings(): array
    {
        return [
            'Tarikh',
            'Kategori',
            'Kereta',
            'Vendor/Pembekal',
            'Dibayar Oleh',
            'Keterangan',
            'Jumlah (RM)'
        ];
    }

    public function map($expense): array
    {
        $categories = [
            'maintenance' => 'Penyelenggaraan',
            'fuel' => 'Bahan Api',
            'insurance' => 'Insurans',
            'cleaning' => 'Pembersihan',
            'repair' => 'Pembaikan',
            'tax' => 'Cukai Jalan',
            'marketing' => 'Pemasaran',
            'salary' => 'Gaji',
            'utilities' => 'Utiliti',
            'other' => 'Lain-lain',
        ];

        return [
            $expense->expense_date ? $expense->expense_date->format('d/m/Y') : '',
            $categories[$expense->category] ?? $expense->category,
            $expense->car ? $expense->car->name : 'Umum',
            $expense->vendor ?? '-',
            $expense->paid_by ?? '-',
            $expense->description,
            (float) $expense->amount
        ];
    }
}
