<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
     use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_id', 'plan_id', 'installation_address_id', 'start_date',
        'end_date', 'status', 'monthly_price', 'installation_fee',
        'auto_renew', 'billing_day', 'last_invoice_date', 'next_invoice_date', 'notes'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'last_invoice_date' => 'date',
        'next_invoice_date' => 'date',
        'monthly_price' => 'decimal:2',
        'installation_fee' => 'decimal:2',
        'auto_renew' => 'boolean',
        'billing_day' => 'integer',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function installationAddress(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'installation_address_id');
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function subscriptionProducts(): HasMany
    {
        return $this->hasMany(SubscriptionProduct::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function serviceOrders(): HasMany
    {
        return $this->hasMany(ServiceOrder::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeDueForInvoice($query)
    {
        return $query->where('next_invoice_date', '<=', now()->toDateString())
                    ->where('status', 'active');
    }

    // Helper methods
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function canBeSuspended(): bool
    {
        return in_array($this->status, ['active']);
    }

    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['active', 'suspended']);
    }

    public function getEquipment()
    {
        return $this->subscriptionProducts()
                   ->with(['product', 'equipment'])
                   ->where('is_active', true)
                   ->get();
    }
}
