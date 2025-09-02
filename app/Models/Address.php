<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id', 'type', 'street', 'number', 'neighborhood',
        'district', 'city', 'province', 'postal_code', 'reference',
        'latitude', 'longitude', 'is_primary'
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'is_primary' => 'boolean',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    // Accessors
    public function getFullAddressAttribute(): string
    {
        return trim("{$this->street} {$this->number}, {$this->neighborhood}, {$this->city} - {$this->province}");
    }

    public function getGoogleMapsUrlAttribute(): string
    {
        if ($this->latitude && $this->longitude) {
            return "https://maps.google.com?q={$this->latitude},{$this->longitude}";
        }
        return "https://maps.google.com?q=" . urlencode($this->full_address);
    }

    // Scopes
    public function scopeInstallation($query)
    {
        return $query->where('type', 'installation');
    }

    public function scopeBilling($query)
    {
        return $query->where('type', 'billing');
    }
}
