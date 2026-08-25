<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CustomerReportExport implements FromCollection, WithHeadings, WithMapping, WithTitle, ShouldAutoSize
{
    protected $customers;

    public function __construct($customers)
    {
        $this->customers = $customers;
    }

    public function collection()
    {
        return $this->customers;
    }

    public function title(): string
    {
        return 'Pelanggan';
    }

    public function headings(): array
    {
        return [
            'Nama Pelanggan',
            'No. Telefon',
            'Jumlah Tempahan',
            'Jumlah Spent (RM)',
            'Tarikh Pertama Sewa',
            'Tarikh Terakhir Sewa'
        ];
    }

    public function map($customer): array
    {
        return [
            $customer->customer_name,
            $customer->customer_phone,
            $customer->total_bookings,
            (float) $customer->total_spent,
            $customer->first_booking ? \Carbon\Carbon::parse($customer->first_booking)->format('d/m/Y') : '',
            $customer->last_booking ? \Carbon\Carbon::parse($customer->last_booking)->format('d/m/Y') : '',
        ];
    }
}
