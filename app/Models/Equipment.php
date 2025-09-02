<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Equipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'serial_number', 'mac_address', 'status',
        'customer_id', 'installation_date', 'return_date', 'location_notes'
    ];

    protected $casts = [
        'installation_date' => 'date',
        'return_date' => 'date',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    // public function subscriptionProduct(): HasOne
    // {
    //     return $this->hasOne(SubscriptionProduct::class);
    // }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeInstalled($query)
    {
        return $query->where('status', 'installed');
    }

    // Helper methods
    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }

    public function isInstalled(): bool
    {
        return $this->status === 'installed';
    }
}
