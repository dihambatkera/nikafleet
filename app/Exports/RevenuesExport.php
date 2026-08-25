<?php

namespace App\Exports;

use App\Models\Revenue;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RevenuesExport implements FromCollection, WithHeadings, WithMapping, WithTitle, ShouldAutoSize
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Revenue::with(['car', 'rental']);

        if (!empty($this->filters['car_id'])) {
            $query->where('car_id', $this->filters['car_id']);
        }

        if (!empty($this->filters['type'])) {
            $query->where('type', $this->filters['type']);
        }

        if (!empty($this->filters['start_date']) && !empty($this->filters['end_date'])) {
            $query->whereBetween('revenue_date', [$this->filters['start_date'], $this->filters['end_date']]);
        }

        return $query->orderBy('revenue_date', 'desc')->get();
    }

    public function title(): string
    {
        return 'Pendapatan';
    }

    public function headings(): array
    {
        return [
            'Tarikh',
            'Keterangan',
            'Kereta',
            'Kod Tempahan',
            'Jenis',
            'Jumlah (RM)'
        ];
    }

    public function map($revenue): array
    {
        $types = [
            'rental' => 'Sewa',
            'deposit' => 'Deposit',
            'penalty' => 'Penalti',
            'refund' => 'Refund',
            'other' => 'Lain-lain',
        ];

        return [
            $revenue->revenue_date ? $revenue->revenue_date->format('d/m/Y') : '',
            $revenue->description,
            $revenue->car ? $revenue->car->name : 'N/A',
            $revenue->rental ? $revenue->rental->booking_code : 'Manual',
            $types[$revenue->type] ?? $revenue->type,
            (float) $revenue->amount
        ];
    }
}
