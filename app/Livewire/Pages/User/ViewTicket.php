<?php

namespace App\Livewire\Pages\User;

use App\Models\Ticket;
use App\Models\TicketMessage;
use App\Services\TicketService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.app')]
#[Title('Detail Laporan')]
class ViewTicket extends Component
{
    use WithFileUploads;

    public Ticket $ticket;
    public string $newMessage = '';
    public array $chatFiles = [];

    public function mount(Ticket $ticket)
    {
        abort_unless(auth()->user()->can('view', $ticket), 403);
        $this->ticket = $ticket;

        // Mark messages as read
        $ticket->messages()
            ->where('user_id', '!=', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);
    }

    public function sendMessage(TicketService $ticketService)
    {
        $this->validate([
            'newMessage' => 'required|string|min:1',
        ]);

        $ticketService->addMessage($this->ticket, $this->newMessage, false, $this->chatFiles);

        $this->newMessage = '';
        $this->chatFiles = [];
        $this->ticket->refresh();
    }

    public function render()
    {
        return view('livewire.pages.user.view-ticket', [
            'messages' => $this->ticket->messages()->with('user')->get(),
        ]);
    }
}
