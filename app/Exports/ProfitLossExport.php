<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ProfitLossExport implements WithMultipleSheets
{
    protected $data;
    protected $filters;

    public function __construct($data, $filters = [])
    {
        $this->data = $data;
        $this->filters = $filters;
    }

    public function sheets(): array
    {
        return [
            new ProfitLossSummarySheet($this->data),
            new RevenuesExport($this->filters),
            new ExpensesExport($this->filters),
        ];
    }
}
