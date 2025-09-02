<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
     use HasFactory;

    protected $fillable = [
        'name', 'model', 'brand', 'category', 'description',
        'sale_price', 'rental_price', 'stock_quantity', 'min_stock_alert', 'is_active'
    ];

    protected $casts = [
        'sale_price' => 'decimal:2',
        'rental_price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'min_stock_alert' => 'integer',
        'is_active' => 'boolean',
    ];

    public function equipment(): HasMany
    {
        return $this->hasMany(Equipment::class);
    }

    public function subscriptionProducts(): HasMany
    {
        return $this->hasMany(SubscriptionProduct::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeLowStock($query)
    {
        return $query->whereRaw('stock_quantity <= min_stock_alert');
    }

    public function scopeInStock($query)
    {
        return $query->where('stock_quantity', '>', 0);
    }

    // Helper methods
    public function isInStock(): bool
    {
        return $this->stock_quantity > 0;
    }

    public function isLowStock(): bool
    {
        return $this->stock_quantity <= $this->min_stock_alert;
    }

    public function getAvailableEquipment()
    {
        return $this->equipment()->where('status', 'available')->get();
    }
}
