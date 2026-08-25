<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Rental extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'car_id',
        'booking_code',
        'customer_name',
        'customer_phone',
        'start_date',
        'end_date',
        'total_days',
        'price_per_day',
        'total_amount',
        'deposit_paid',
        'balance_due',
        'status',
        'payment_method',
        'payment_proof',
        'pickup_location',
        'dropoff_location',
        'admin_notes',
        'customer_notes',
        'confirmed_at',
        'started_at',
        'completed_at',
        'cancelled_at',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'total_days' => 'integer',
            'price_per_day' => 'decimal:2',
            'total_amount' => 'decimal:2',
            'deposit_paid' => 'decimal:2',
            'balance_due' => 'decimal:2',
            'confirmed_at' => 'datetime',
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
            'cancelled_at' => 'datetime',
        ];
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($rental) {
            if (empty($rental->booking_code)) {
                $rental->booking_code = 'NF-' . strtoupper(Str::random(8));
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function revenues(): HasMany
    {
        return $this->hasMany(Revenue::class);
    }

    public function getStatusBadgeColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'yellow',
            'confirmed' => 'blue',
            'active' => 'green',
            'completed' => 'gray',
            'cancelled' => 'red',
            'refunded' => 'purple',
            default => 'gray',
        };
    }

    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['confirmed', 'active']);
    }
}
