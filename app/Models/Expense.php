<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'car_id',
        'amount',
        'description',
        'expense_date',
        'receipt_path',
        'paid_by',
        'vendor',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'expense_date' => 'date',
        ];
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function getReceiptUrlAttribute(): ?string
    {
        return $this->receipt_path ? asset('storage/' . $this->receipt_path) : null;
    }

    public static function categories(): array
    {
        return [
            'maintenance' => 'Maintenance',
            'fuel' => 'Fuel',
            'insurance' => 'Insurance',
            'cleaning' => 'Cleaning',
            'repair' => 'Repair',
            'tax' => 'Tax',
            'marketing' => 'Marketing',
            'salary' => 'Salary',
            'utilities' => 'Utilities',
            'other' => 'Other',
        ];
    }
}
