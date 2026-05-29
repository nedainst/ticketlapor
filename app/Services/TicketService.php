<?php

namespace App\Services;

use App\Enums\TicketStatus;
use App\Models\ActivityLog;
use App\Models\Attachment;
use App\Models\Ticket;
use App\Models\TicketMessage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TicketService
{
    /**
     * Create a new ticket with optional attachments.
     */
    public function create(array $data, array $files = []): Ticket
    {
        return DB::transaction(function () use ($data, $files) {
            $ticket = Ticket::create([
                'user_id' => auth()->id(),
                'category_id' => $data['category_id'],
                'title' => $data['title'],
                'description' => $data['description'],
                'priority' => $data['priority'],
                'latitude' => $data['latitude'] ?? null,
                'longitude' => $data['longitude'] ?? null,
                'address' => $data['address'] ?? null,
            ]);

            // Handle file attachments
            foreach ($files as $file) {
                $this->attachFile($ticket, $file);
            }

            // Log activity
            ActivityLog::log('ticket_created', $ticket, 'Tiket baru dibuat: ' . $ticket->title);

            return $ticket;
        });
    }

    /**
     * Update ticket status.
     */
    public function updateStatus(Ticket $ticket, TicketStatus $status): Ticket
    {
        $oldStatus = $ticket->status;

        $updates = ['status' => $status];

        // Track first response time
        if ($status === TicketStatus::DIPROSES && !$ticket->first_responded_at) {
            $updates['first_responded_at'] = now();
            $updates['response_time_minutes'] = $ticket->created_at->diffInMinutes(now());
        }

        // Track resolution
        if ($status === TicketStatus::SELESAI) {
            $updates['resolved_at'] = now();
        }

        // Track closure
        if (in_array($status, [TicketStatus::SELESAI, TicketStatus::DITOLAK])) {
            $updates['closed_at'] = now();
        }

        $ticket->update($updates);

        ActivityLog::log('status_changed', $ticket, "Status berubah dari {$oldStatus->label()} ke {$status->label()}", [
            'old_status' => $oldStatus->value,
            'new_status' => $status->value,
        ]);

        return $ticket->fresh();
    }

    /**
     * Assign ticket to an admin/officer.
     */
    public function assign(Ticket $ticket, int $assigneeId): Ticket
    {
        $ticket->update(['assigned_to' => $assigneeId]);

        if ($ticket->status === TicketStatus::PENDING) {
            $this->updateStatus($ticket, TicketStatus::DIPROSES);
        }

        ActivityLog::log('ticket_assigned', $ticket, 'Tiket ditugaskan ke petugas');

        return $ticket->fresh();
    }

    /**
     * Add a message to a ticket.
     */
    public function addMessage(Ticket $ticket, string $body, bool $isInternal = false, array $files = []): TicketMessage
    {
        $message = $ticket->messages()->create([
            'user_id' => auth()->id(),
            'body' => $body,
            'is_internal' => $isInternal,
        ]);

        foreach ($files as $file) {
            $this->attachFile($message, $file);
        }

        // Update ticket status if admin replies
        if (auth()->user()->isAdmin() && $ticket->status === TicketStatus::PENDING) {
            $this->updateStatus($ticket, TicketStatus::DIPROSES);
        }

        ActivityLog::log('message_sent', $ticket, 'Pesan baru dikirim');

        return $message;
    }

    /**
     * Attach a file to a model (Ticket or TicketMessage).
     */
    public function attachFile($model, UploadedFile $file): Attachment
    {
        $path = $file->store('attachments/' . date('Y/m'), 'public');

        return $model->attachments()->create([
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'file_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'uploaded_by' => auth()->id(),
        ]);
    }

    /**
     * Get ticket statistics.
     */
    public function getStatistics(): array
    {
        return [
            'total' => Ticket::count(),
            'pending' => Ticket::where('status', TicketStatus::PENDING)->count(),
            'diproses' => Ticket::where('status', TicketStatus::DIPROSES)->count(),
            'selesai' => Ticket::where('status', TicketStatus::SELESAI)->count(),
            'ditolak' => Ticket::where('status', TicketStatus::DITOLAK)->count(),
            'avg_response_time' => (int) Ticket::whereNotNull('response_time_minutes')->avg('response_time_minutes'),
            'today' => Ticket::whereDate('created_at', today())->count(),
            'this_month' => Ticket::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count(),
        ];
    }
}
