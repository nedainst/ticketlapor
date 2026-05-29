<?php

namespace App\Livewire\Pages\Admin;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Models\Ticket;
use App\Models\User;
use App\Services\TicketService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
#[Title('Kelola Tiket')]
class TicketList extends Component
{
    use WithPagination;

    #[Url] public string $search = '';
    #[Url] public string $status = '';
    #[Url] public string $priority = '';
    #[Url] public string $category = '';

    public function updateStatus(int $ticketId, string $status, TicketService $ticketService)
    {
        $ticket = Ticket::findOrFail($ticketId);
        $ticketService->updateStatus($ticket, TicketStatus::from($status));
        $this->dispatch('toast', message: 'Status tiket berhasil diperbarui', type: 'success');
    }

    public function assignTicket(int $ticketId, int $adminId, TicketService $ticketService)
    {
        $ticket = Ticket::findOrFail($ticketId);
        $ticketService->assign($ticket, $adminId);
        $this->dispatch('toast', message: 'Tiket berhasil ditugaskan', type: 'success');
    }

    public function updatingSearch() { $this->resetPage(); }

    public function render()
    {
        $tickets = Ticket::with(['user', 'category', 'assignee'])
            ->when($this->search, fn ($q) => $q->where('title', 'like', "%{$this->search}%")->orWhere('ticket_number', 'like', "%{$this->search}%"))
            ->when($this->status, fn ($q) => $q->where('status', $this->status))
            ->when($this->priority, fn ($q) => $q->where('priority', $this->priority))
            ->when($this->category, fn ($q) => $q->where('category_id', $this->category))
            ->latest()
            ->paginate(15);

        return view('livewire.pages.admin.ticket-list', [
            'tickets' => $tickets,
            'admins' => User::role(['admin', 'super_admin'])->get(),
            'statuses' => TicketStatus::cases(),
            'priorities' => TicketPriority::cases(),
            'categories' => \App\Models\Category::active()->get(),
        ]);
    }
}
