<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id', 'user_id', 'response', 'is_internal', 'is_solution', 'attachments'
    ];

    protected $casts = [
        'is_internal' => 'boolean',
        'is_solution' => 'boolean',
        'attachments' => 'array',
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopePublic($query)
    {
        return $query->where('is_internal', false);
    }

    public function scopeInternal($query)
    {
        return $query->where('is_internal', true);
    }

    public function scopeSolutions($query)
    {
        return $query->where('is_solution', true);
    }

    // Helper methods
    public function isPublic(): bool
    {
        return !$this->is_internal;
    }

    public function hasAttachments(): bool
    {
        return !empty($this->attachments);
    }
}
