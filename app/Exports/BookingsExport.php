<?php

namespace App\Exports;

use App\Models\Rental;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class BookingsExport implements FromCollection, WithHeadings, WithMapping, WithTitle, ShouldAutoSize
{
    public function collection()
    {
        return Rental::with('car')->orderBy('created_at', 'desc')->get();
    }

    public function title(): string
    {
        return 'Tempahan';
    }

    public function headings(): array
    {
        return [
            'Kod Tempahan',
            'Nama Pelanggan',
            'No. Telefon Pelanggan',
            'Kereta',
            'Tarikh Mula',
            'Tarikh Tamat',
            'Jumlah Hari',
            'Kadar Harian (RM)',
            'Jumlah Bayaran (RM)',
            'Status'
        ];
    }

    public function map($rental): array
    {
        $statusLabels = [
            'pending' => 'Menunggu',
            'confirmed' => 'Disahkan',
            'active' => 'Aktif',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            'refunded' => 'Dipulangkan',
        ];

        return [
            $rental->booking_code,
            $rental->customer_name,
            $rental->customer_phone,
            $rental->car ? $rental->car->name : 'N/A',
            $rental->start_date ? $rental->start_date->format('d/m/Y') : '',
            $rental->end_date ? $rental->end_date->format('d/m/Y') : '',
            $rental->total_days,
            (float) $rental->price_per_day,
            (float) $rental->total_amount,
            $statusLabels[$rental->status] ?? $rental->status,
        ];
    }
}
