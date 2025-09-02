<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id', 'description', 'quantity', 'unit_price', 'total_price', 'type'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    // Accessors
    public function getFormattedUnitPriceAttribute(): string
    {
        return number_format($this->unit_price, 2, ',', '.') . ' MT';
    }

    public function getFormattedTotalPriceAttribute(): string
    {
        return number_format($this->total_price, 2, ',', '.') . ' MT';
    }

    // Scopes
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopePlans($query)
    {
        return $query->where('type', 'plan');
    }

    public function scopeProducts($query)
    {
        return $query->where('type', 'product');
    }
}
