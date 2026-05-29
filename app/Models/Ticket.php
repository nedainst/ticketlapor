<?php

namespace App\Models;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'ticket_number',
        'user_id',
        'reporter_name',
        'reporter_phone',
        'category_id',
        'assigned_to',
        'title',
        'description',
        'status',
        'priority',
        'latitude',
        'longitude',
        'address',
        'response_time_minutes',
        'first_responded_at',
        'resolved_at',
        'closed_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => TicketStatus::class,
            'priority' => TicketPriority::class,
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
            'first_responded_at' => 'datetime',
            'resolved_at' => 'datetime',
            'closed_at' => 'datetime',
        ];
    }

    // Auto-generate ticket number on creation
    protected static function booted(): void
    {
        static::creating(function (Ticket $ticket) {
            if (empty($ticket->ticket_number)) {
                $ticket->ticket_number = self::generateTicketNumber();
            }
        });
    }

    public static function generateTicketNumber(): string
    {
        $year = date('Y');
        $lastTicket = self::withTrashed()
            ->where('ticket_number', 'like', "TK-{$year}-%")
            ->orderByDesc('id')
            ->first();

        if ($lastTicket) {
            $lastNumber = (int) substr($lastTicket->ticket_number, -6);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return sprintf('TK-%s-%06d', $year, $newNumber);
    }

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(TicketMessage::class)->orderBy('created_at');
    }

    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function activityLogs(): MorphMany
    {
        return $this->morphMany(ActivityLog::class, 'loggable');
    }

    // Latest message
    public function latestMessage()
    {
        return $this->hasOne(TicketMessage::class)->latestOfMany();
    }

    // Unread messages count for a user
    public function unreadMessagesCount(int $userId): int
    {
        return $this->messages()
            ->where('user_id', '!=', $userId)
            ->where('is_read', false)
            ->count();
    }

    // Scopes
    public function scopeStatus($query, TicketStatus $status)
    {
        return $query->where('status', $status);
    }

    public function scopePriority($query, TicketPriority $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeAssignedTo($query, int $userId)
    {
        return $query->where('assigned_to', $userId);
    }

    public function scopeOpen($query)
    {
        return $query->whereNotIn('status', [
            TicketStatus::SELESAI,
            TicketStatus::DITOLAK,
        ]);
    }
}
