<?php

namespace App\Livewire\Pages\User;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Models\Ticket;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
#[Title('Laporan Saya')]
class MyTickets extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $status = '';

    #[Url]
    public string $priority = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $tickets = Ticket::forUser(auth()->id())
            ->with(['category', 'assignee'])
            ->when($this->search, fn ($q) => $q->where('title', 'like', "%{$this->search}%")->orWhere('ticket_number', 'like', "%{$this->search}%"))
            ->when($this->status, fn ($q) => $q->where('status', $this->status))
            ->when($this->priority, fn ($q) => $q->where('priority', $this->priority))
            ->latest()
            ->paginate(10);

        return view('livewire.pages.user.my-tickets', [
            'tickets' => $tickets,
            'statuses' => TicketStatus::cases(),
            'priorities' => TicketPriority::cases(),
        ]);
    }
}
