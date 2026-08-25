<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class CarImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_id',
        'image_path',
        'is_primary',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_primary' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function getUrlAttribute(): string
    {
        if (empty($this->image_path)) {
            return asset('assets/images/logo-official.jpeg');
        }

        if (str_starts_with($this->image_path, 'http://') || str_starts_with($this->image_path, 'https://')) {
            return $this->image_path;
        }

        return asset('storage/' . $this->image_path);
    }
}
