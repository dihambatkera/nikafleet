<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CarPerformanceReportExport implements FromArray, WithHeadings, WithTitle, ShouldAutoSize
{
    protected $performanceData;
    protected $periodLabel;

    public function __construct($performanceData, $periodLabel)
    {
        $this->performanceData = $performanceData;
        $this->periodLabel = $periodLabel;
    }

    public function array(): array
    {
        $rows = [];
        foreach ($this->performanceData as $row) {
            $rows[] = [
                $row['name'],
                $row['plate_number'],
                $row['days_available'],
                $row['days_rented'],
                number_format($row['occupancy_rate'], 1) . '%',
                (float) $row['revenue'],
                (float) $row['expense'],
                (float) $row['net'],
                $row['rentals_count']
            ];
        }
        return $rows;
    }

    public function title(): string
    {
        return 'Prestasi Kereta';
    }

    public function headings(): array
    {
        return [
            'Nama Kereta',
            'No. Pendaftaran',
            'Hari Tersedia',
            'Hari Disewa',
            'Kadar Penginapan %',
            'Pendapatan (RM)',
            'Perbelanjaan (RM)',
            'Sumbangan Bersih (RM)',
            'Bilangan Sewaan'
        ];
    }
}
