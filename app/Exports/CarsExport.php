<?php

namespace App\Exports;

use App\Models\Car;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CarsExport implements FromCollection, WithHeadings, WithMapping, WithTitle, ShouldAutoSize
{
    public function collection()
    {
        return Car::all();
    }

    public function title(): string
    {
        return 'Kereta';
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Kereta',
            'No. Plat',
            'Jenama',
            'Model',
            'Tahun',
            'Warna',
            'Jenis',
            'Transmisi',
            'Tempat Duduk',
            'Bahan Api',
            'Kadar Harian (RM)',
            'Deposit (RM)',
            'Status'
        ];
    }

    public function map($car): array
    {
        $types = [
            'sedan' => 'Sedan',
            'suv' => 'SUV',
            'mpv' => 'MPV',
            'pickup' => 'Pikap',
            'van' => 'Van',
            'hatchback' => 'Hatchback',
        ];

        $transmissions = [
            'auto' => 'Automatik',
            'manual' => 'Manual',
        ];

        $fuelTypes = [
            'petrol' => 'Petrol',
            'diesel' => 'Diesel',
            'hybrid' => 'Hibrid',
            'electric' => 'Elektrik',
        ];

        $statusLabels = [
            'available' => 'Tersedia',
            'rented' => 'Disewa',
            'maintenance' => 'Penyelenggaraan',
            'hidden' => 'Sorok',
        ];

        return [
            $car->id,
            $car->name,
            $car->plate_number,
            $car->brand,
            $car->model,
            $car->year,
            $car->color,
            $types[$car->type] ?? $car->type,
            $transmissions[$car->transmission] ?? $car->transmission,
            $car->seats,
            $fuelTypes[$car->fuel_type] ?? $car->fuel_type,
            (float) $car->price_per_day,
            (float) $car->deposit_amount,
            $statusLabels[$car->status] ?? $car->status,
        ];
    }
}
