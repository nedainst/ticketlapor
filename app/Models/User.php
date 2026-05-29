<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasRoles, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'provider_name',
        'provider_id',
        'phone',
        'nik',
        'address',
        'avatar',
        'is_active',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // Tickets created by this user
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    // Tickets assigned to this user (admin)
    public function assignedTickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'assigned_to');
    }

    // Messages sent by this user
    public function messages(): HasMany
    {
        return $this->hasMany(TicketMessage::class);
    }

    // Activity logs for this user
    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    // Avatar URL accessor
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }

        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=3B82F6&color=fff&size=128';
    }

    // Check if user is admin
    public function isAdmin(): bool
    {
        return $this->hasRole(['admin', 'super_admin']);
    }

    // Check if user is super admin
    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super_admin');
    }
}
