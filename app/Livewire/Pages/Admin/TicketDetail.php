<?php

namespace App\Livewire\Pages\Admin;

use App\Enums\TicketStatus;
use App\Models\Ticket;
use App\Models\User;
use App\Services\TicketService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Detail Tiket')]
class TicketDetail extends Component
{
    public Ticket $ticket;
    public string $newMessage = '';
    public string $internalNote = '';

    public function mount(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    public function updateStatus(string $status, TicketService $ticketService)
    {
        $ticketService->updateStatus($this->ticket, TicketStatus::from($status));
        $this->ticket->refresh();
        $this->dispatch('toast', message: 'Status berhasil diperbarui', type: 'success');
    }

    public function assign(int $adminId, TicketService $ticketService)
    {
        $ticketService->assign($this->ticket, $adminId);
        $this->ticket->refresh();
        $this->dispatch('toast', message: 'Tiket berhasil ditugaskan', type: 'success');
    }

    public function sendMessage(TicketService $ticketService)
    {
        $this->validate(['newMessage' => 'required|min:1']);
        $ticketService->addMessage($this->ticket, $this->newMessage);
        $this->newMessage = '';
        $this->ticket->refresh();
    }

    public function sendInternalNote(TicketService $ticketService)
    {
        $this->validate(['internalNote' => 'required|min:1']);
        $ticketService->addMessage($this->ticket, $this->internalNote, true);
        $this->internalNote = '';
        $this->ticket->refresh();
    }

    public function render()
    {
        return view('livewire.pages.admin.ticket-detail', [
            'messages' => $this->ticket->messages()->with('user')->get(),
            'admins' => User::role(['admin', 'super_admin'])->get(),
            'statuses' => TicketStatus::cases(),
        ]);
    }
}
