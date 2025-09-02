<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id', 'invoice_id', 'amount', 'method',
        'reference', 'payment_date', 'status', 'notes'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    // Accessors
    public function getFormattedAmountAttribute(): string
    {
        return number_format($this->amount, 2, ',', '.') . ' MT';
    }

    public function getMethodDisplayAttribute(): string
    {
        return match($this->method) {
            'cash' => 'Dinheiro',
            'bank_transfer' => 'Transferência Bancária',
            'mpesa' => 'M-Pesa',
            'emola' => 'e-Mola',
            'mkesh' => 'mKesh',
            'card' => 'Cartão',
            default => $this->method
        };
    }

    // Scopes
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeByMethod($query, $method)
    {
        return $query->where('method', $method);
    }

    // Helper methods
    public function isConfirmed(): bool
    {
        return $this->status === 'confirmed';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isMobileMoney(): bool
    {
        return in_array($this->method, ['mpesa', 'emola', 'mkesh']);
    }
}
