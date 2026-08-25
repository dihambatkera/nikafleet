<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ProfitLossSummarySheet implements FromArray, WithTitle, ShouldAutoSize
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        $rows = [
            ['LAPORAN UNTUNG & RUGI - NIKAFLEET'],
            ['Tempoh:', $this->data['period_label']],
            [],
            ['RINGKASAN KEWANGAN'],
            ['Jumlah Pendapatan', 'RM ' . number_format($this->data['total_revenue'], 2)],
            ['Jumlah Perbelanjaan', 'RM ' . number_format($this->data['total_expense'], 2)],
            ['Untung / Rugi Bersih', 'RM ' . number_format($this->data['net_profit'], 2), $this->data['net_profit'] >= 0 ? 'UNTUNG' : 'RUGI'],
            ['Margin Keuntungan', number_format($this->data['profit_margin'], 2) . '%'],
            [],
            ['PECAHAN PENDAPATAN'],
            ['Sewa Kereta', 'RM ' . number_format($this->data['revenue_breakdown']['rental'], 2)],
            ['Deposit Dikutip', 'RM ' . number_format($this->data['revenue_breakdown']['deposit'], 2)],
            ['Penalti', 'RM ' . number_format($this->data['revenue_breakdown']['penalty'], 2)],
            ['Lain-lain / Refund', 'RM ' . number_format($this->data['revenue_breakdown']['other_refund'], 2)],
            ['JUMLAH PENDAPATAN', 'RM ' . number_format($this->data['total_revenue'], 2)],
            [],
            ['PECAHAN PERBELANJAAN'],
        ];

        foreach ($this->data['expense_breakdown'] as $label => $amount) {
            $rows[] = [$label, 'RM ' . number_format($amount, 2)];
        }

        $rows[] = ['JUMLAH PERBELANJAAN', 'RM ' . number_format($this->data['total_expense'], 2)];
        $rows[] = [];
        $rows[] = ['PRESTASI KEUNTUNGAN MENGIKUT KENDERAAN'];
        $rows[] = ['Nama Kereta', 'Jumlah Pendapatan', 'Jumlah Perbelanjaan', 'Untung Bersih', 'Margin', 'Status'];

        foreach ($this->data['car_profitability'] as $car) {
            $rows[] = [
                $car['name'],
                'RM ' . number_format($car['revenue'], 2),
                'RM ' . number_format($car['expense'], 2),
                'RM ' . number_format($car['net'], 2),
                number_format($car['margin'], 2) . '%',
                $car['status']
            ];
        }

        return $rows;
    }

    public function title(): string
    {
        return 'Ringkasan Untung Rugi';
    }
}
