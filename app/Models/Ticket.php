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
        'ticket_number',
        'customer_id',
        'subscription_id',
        'assigned_to',
        'subject',
        'description',
        'priority',
        'category',
        'status',
        'opened_at',
        'resolved_at',
        'closed_at'
    ];

    protected $casts = [
        'opened_at' => 'datetime',
        'resolved_at' => 'datetime',
        'closed_at' => 'datetime',
    ];

    // Relationships
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function responses(): HasMany
    {
        return $this->hasMany(TicketResponse::class);
    }

    public function publicResponses(): HasMany
    {
        return $this->hasMany(TicketResponse::class)->where('is_internal', false);
    }

    public function internalNotes(): HasMany
    {
        return $this->hasMany(TicketResponse::class)->where('is_internal', true);
    }

    // Scopes
    public function scopeOpen($query)
    {
        return $query->whereIn('status', ['open', 'in_progress', 'waiting_customer']);
    }

    public function scopeClosed($query)
    {
        return $query->whereIn('status', ['resolved', 'closed']);
    }

    public function scopeUrgent($query)
    {
        return $query->where('priority', 'urgent');
    }

    public function scopeHigh($query)
    {
        return $query->where('priority', 'high');
    }

    public function scopeAssignedTo($query, $userId)
    {
        return $query->where('assigned_to', $userId);
    }

    public function scopeUnassigned($query)
    {
        return $query->whereNull('assigned_to');
    }

    // Accessors & Mutators
    public function getPriorityLabelAttribute(): string
    {
        return match ($this->priority) {
            'low' => 'Baixa',
            'medium' => 'Média',
            'high' => 'Alta',
            'urgent' => 'Urgente',
            default => 'Indefinida'
        };
    }

    public function getPriorityColorAttribute(): string
    {
        return match ($this->priority) {
            'low' => 'green',
            'medium' => 'yellow',
            'high' => 'orange',
            'urgent' => 'red',
            default => 'gray'
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'open' => 'Aberto',
            'in_progress' => 'Em Progresso',
            'waiting_customer' => 'Aguardando Cliente',
            'resolved' => 'Resolvido',
            'closed' => 'Fechado',
            default => 'Indefinido'
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'open' => 'red',
            'in_progress' => 'blue',
            'waiting_customer' => 'yellow',
            'resolved' => 'green',
            'closed' => 'gray',
            default => 'gray'
        };
    }

    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            'technical' => 'Técnico',
            'billing' => 'Faturamento',
            'installation' => 'Instalação',
            'complaint' => 'Reclamação',
            'request' => 'Solicitação',
            default => 'Geral'
        };
    }

    // Helper Methods
    public function isOpen(): bool
    {
        return in_array($this->status, ['open', 'in_progress', 'waiting_customer']);
    }

    public function isClosed(): bool
    {
        return in_array($this->status, ['resolved', 'closed']);
    }

    public function isUrgent(): bool
    {
        return $this->priority === 'urgent';
    }

    public function isAssigned(): bool
    {
        return !is_null($this->assigned_to);
    }

    public function getResponseTimeAttribute(): ?int
    {
        if (!$this->resolved_at) {
            return null;
        }

        return $this->opened_at->diffInHours($this->resolved_at);
    }

    public function getSlaStatus(): string
    {
        if ($this->isClosed()) {
            return 'met'; // Assumindo que foi resolvido no prazo se está fechado
        }

        $hoursSinceOpened = $this->opened_at->diffInHours(now());
        $slaLimit = match ($this->priority) {
            'urgent' => 2,   // 2 horas
            'high' => 8,     // 8 horas
            'medium' => 24,  // 24 horas
            'low' => 72,     // 72 horas
            default => 24
        };

        if ($hoursSinceOpened > $slaLimit) {
            return 'breached';
        } elseif ($hoursSinceOpened > ($slaLimit * 0.8)) {
            return 'warning';
        }

        return 'ok';
    }

    public function getSlaStatusColorAttribute(): string
    {
        return match ($this->getSlaStatus()) {
            'ok' => 'green',
            'warning' => 'yellow',
            'breached' => 'red',
            'met' => 'blue',
            default => 'gray'
        };
    }

    public function canBeAssignedTo($userId): bool
    {
        return $this->isOpen() && ($this->assigned_to === null || $this->assigned_to !== $userId);
    }

    public function markAsResolved($userId): void
    {
        $this->update([
            'status' => 'resolved',
            'resolved_at' => now(),
            'assigned_to' => $this->assigned_to ?? $userId
        ]);
    }

    public function markAsClosed($userId): void
    {
        $this->update([
            'status' => 'closed',
            'closed_at' => now(),
            'resolved_at' => $this->resolved_at ?? now()
        ]);
    }

    public function reopen(): void
    {
        $this->update([
            'status' => 'open',
            'resolved_at' => null,
            'closed_at' => null
        ]);
    }

    // Generate unique ticket number
    public static function generateTicketNumber(): string
    {
        $year = now()->year;
        $lastTicket = static::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = $lastTicket ?
            ((int) substr($lastTicket->ticket_number, -3)) + 1 : 1;

        return 'TK-' . $year . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }

    // Boot method for auto-generating ticket number
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ticket) {
            if (empty($ticket->ticket_number)) {
                $ticket->ticket_number = static::generateTicketNumber();
            }

            if (empty($ticket->opened_at)) {
                $ticket->opened_at = now();
            }
        });
    }
}
