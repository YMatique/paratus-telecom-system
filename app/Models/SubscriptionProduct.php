<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubscriptionProduct extends Model
{
        use HasFactory;

    protected $fillable = [
        'subscription_id', 'product_id', 'equipment_id', 'type',
        'price', 'start_date', 'end_date', 'is_active'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeRentals($query)
    {
        return $query->where('type', 'rental');
    }

    public function scopeSales($query)
    {
        return $query->where('type', 'sale');
    }

    // Helper methods
    public function isRental(): bool
    {
        return $this->type === 'rental';
    }

    public function isSale(): bool
    {
        return $this->type === 'sale';
    }
}
