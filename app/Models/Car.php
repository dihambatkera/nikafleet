<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'plate_number',
        'brand',
        'model',
        'year',
        'color',
        'type',
        'transmission',
        'seats',
        'fuel_type',
        'price_per_day',
        'price_per_week',
        'deposit_amount',
        'late_return_penalty',
        'mileage',
        'last_service_date',
        'next_service_due',
        'insurance_expiry',
        'road_tax_expiry',
        'location',
        'status',
        'featured',
        'description',
        'availability_note',
    ];

    protected function casts(): array
    {
        return [
            'year' => 'integer',
            'seats' => 'integer',
            'price_per_day' => 'decimal:2',
            'price_per_week' => 'decimal:2',
            'deposit_amount' => 'decimal:2',
            'late_return_penalty' => 'decimal:2',
            'mileage' => 'integer',
            'last_service_date' => 'date',
            'next_service_due' => 'date',
            'insurance_expiry' => 'date',
            'road_tax_expiry' => 'date',
            'featured' => 'boolean',
        ];
    }

    public function images(): HasMany
    {
        return $this->hasMany(CarImage::class)->orderBy('sort_order');
    }

    public function primaryImage(): ?CarImage
    {
        return $this->images()->where('is_primary', true)->first()
            ?? $this->images()->first();
    }

    public function rentals(): HasMany
    {
        return $this->hasMany(Rental::class);
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    public function availabilityBlocks(): HasMany
    {
        return $this->hasMany(CarAvailabilityBlock::class);
    }

    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }

    public function getPrimaryImageUrlAttribute(): string
    {
        $img = $this->images()->where('is_primary', true)->first()
            ?? $this->images()->first();

        if ($img) {
            return asset('storage/' . $img->image_path);
        }

        return asset('images/car-placeholder.png');
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }
}
