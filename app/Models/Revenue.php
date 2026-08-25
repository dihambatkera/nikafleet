<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Revenue extends Model
{
    use HasFactory;

    protected $fillable = [
        'rental_id',
        'car_id',
        'type',
        'amount',
        'description',
        'revenue_date',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'revenue_date' => 'date',
        ];
    }

    public function rental(): BelongsTo
    {
        return $this->belongsTo(Rental::class);
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public static function types(): array
    {
        return [
            'rental' => 'Rental',
            'deposit' => 'Deposit',
            'penalty' => 'Penalty',
            'refund' => 'Refund',
            'other' => 'Other',
        ];
    }
}
