<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_number', 'customer_id', 'subscription_id', 'assigned_to',
        'subject', 'description', 'priority', 'category', 'status',
        'opened_at', 'resolved_at', 'closed_at'
    ];

    protected $casts = [
        'opened_at' => 'datetime',
        'resolved_at' => 'datetime',
        'closed_at' => 'datetime',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function responses(): HasMany
    {
        return $this->hasMany(TicketResponse::class);
    }

    // Scopes
    public function scopeOpen($query)
    {
        return $query->whereIn('status', ['open', 'in_progress', 'waiting_customer']);
    }

    public function scopeUrgent($query)
    {
        return $query->where('priority', 'urgent');
    }

    // Helper methods
    public function isOpen(): bool
    {
        return in_array($this->status, ['open', 'in_progress', 'waiting_customer']);
    }

    public function getResponseTime(): ?int
    {
        $firstResponse = $this->responses()->oldest()->first();
        if (!$firstResponse) {
            return null;
        }
        return $this->opened_at->diffInMinutes($firstResponse->created_at);
    }
}
