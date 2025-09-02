<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'download_speed', 'upload_speed', 'price',
        'billing_cycle', 'unlimited_data', 'data_limit_gb', 'connection_type',
        'customer_type', 'is_active', 'sort_order'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'unlimited_data' => 'boolean',
        'is_active' => 'boolean',
        'download_speed' => 'integer',
        'upload_speed' => 'integer',
        'data_limit_gb' => 'integer',
        'sort_order' => 'integer',
    ];

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    // public function promotions(): BelongsToMany
    // {
    //     return $this->belongsToMany(Promotion::class, 'plan_promotion');
    // }

    // Accessors
    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, 2, ',', '.') . ' MT';
    }

    public function getSpeedDisplayAttribute(): string
    {
        if ($this->download_speed === $this->upload_speed) {
            return "{$this->download_speed} Mbps";
        }
        return "{$this->download_speed}/{$this->upload_speed} Mbps";
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForIndividual($query)
    {
        return $query->whereIn('customer_type', ['individual', 'both']);
    }

    public function scopeForCompany($query)
    {
        return $query->whereIn('customer_type', ['company', 'both']);
    }

    public function scopeBySpeed($query)
    {
        return $query->orderBy('download_speed');
    }

    // Helper methods
    public function hasActivePromotion(): bool
    {
        return $this->promotions()
            ->where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->exists();
    }

    public function getPromotionalPrice(): float
    {
        $promotion = $this->promotions()
            ->where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        if (!$promotion) {
            return $this->price;
        }

        if ($promotion->discount_type === 'percentage') {
            return $this->price * (1 - $promotion->discount_value / 100);
        }

        return max(0, $this->price - $promotion->discount_value);
    }
}
