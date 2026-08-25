<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AllDataExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new CarsExport(),
            new BookingsExport(),
            new ExpensesExport([]),
            new RevenuesExport([]),
        ];
    }
}
