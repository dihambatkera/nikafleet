<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CarAvailabilityBlock extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_id',
        'blocked_from',
        'blocked_until',
        'reason',
    ];

    protected function casts(): array
    {
        return [
            'blocked_from' => 'date',
            'blocked_until' => 'date',
        ];
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }
}
