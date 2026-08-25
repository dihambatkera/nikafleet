<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExpenseReportExport implements FromCollection, WithHeadings, WithMapping, WithTitle, ShouldAutoSize
{
    protected $expenses;
    protected $periodLabel;

    public function __construct($expenses, $periodLabel)
    {
        $this->expenses = $expenses;
        $this->periodLabel = $periodLabel;
    }

    public function collection()
    {
        return $this->expenses;
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
            'Keterangan',
            'Kereta',
            'Jumlah (RM)',
            'Vendor',
            'Dibayar Oleh'
        ];
    }

    public function map($expense): array
    {
        $categoriesMap = \App\Models\Expense::categories();

        return [
            $expense->expense_date ? $expense->expense_date->format('d/m/Y') : '',
            $categoriesMap[$expense->category] ?? $expense->category,
            $expense->description,
            $expense->car ? $expense->car->name : 'Operasi Umum',
            (float) $expense->amount,
            $expense->vendor ?? 'N/A',
            $expense->paid_by ?? 'N/A',
        ];
    }
}
