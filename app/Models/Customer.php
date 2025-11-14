<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Customer extends Model implements AuthenticatableContract
{
     use HasFactory, SoftDeletes, Authenticatable;

    protected $fillable = [
        'type', 'name', 'document', 'document_type', 'email', 
        'phone', 'whatsapp','company_name', 'status', 'notes',
        'password', 'last_login_at', 'last_login_ip'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'type' => 'string',
        'document_type' => 'string',
        'status' => 'string',
         'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
    ];

    // Relationships
    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    // public function contacts(): HasMany
    // {
    //     return $this->hasMany(Contact::class);
    // }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function equipment(): HasMany
    {
        return $this->hasMany(Equipment::class);
    }

    // Accessors & Mutators
    public function getFormattedDocumentAttribute(): string
    {
        if ($this->document_type === 'nuit') {
            return chunk_split($this->document, 3, ' ');
        }
        return $this->document;
    }

    public function setDocumentAttribute($value): void
    {
        $this->attributes['document'] = preg_replace('/[^0-9]/', '', $value);
    }

    public function setPhoneAttribute($value): void
    {
        if ($value) {
            $this->attributes['phone'] = preg_replace('/[^0-9+]/', '', $value);
        }
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeIndividual($query)
    {
        return $query->where('type', 'individual');
    }

    public function scopeCompany($query)
    {
        return $query->where('type', 'company');
    }

    // Helper methods
    public function getInstallationAddress(): ?Address
    {
        return $this->addresses()->where('type', 'installation')->first();
    }

    public function getBillingAddress(): ?Address
    {
        return $this->addresses()->where('type', 'billing')->first();
    }

    // public function getPrimaryContact(): ?Contact
    // {
    //     return $this->contacts()->where('is_primary', true)->first();
    // }

    public function getActiveSubscription(): ?Subscription
    {
        return $this->subscriptions()->where('status', 'active')->first();
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    // new for customer portal
      public function hasPortalAccess(): bool
    {
        return !empty($this->password) && !empty($this->email);
    }

    /**
     * Atualizar último login
     */
    public function updateLastLogin(): void
    {
        $this->update([
            'last_login_at' => now(),
            'last_login_ip' => request()->ip(),
        ]);
    }
}
