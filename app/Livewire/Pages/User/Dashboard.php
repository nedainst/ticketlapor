<?php

namespace App\Livewire\Pages\User;

use App\Enums\TicketStatus;
use App\Models\Category;
use App\Models\Ticket;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Dashboard Saya')]
class Dashboard extends Component
{
    public function render()
    {
        $userId = auth()->id();

        return view('livewire.pages.user.dashboard', [
            'totalTickets' => Ticket::forUser($userId)->count(),
            'pendingTickets' => Ticket::forUser($userId)->status(TicketStatus::PENDING)->count(),
            'processedTickets' => Ticket::forUser($userId)->status(TicketStatus::DIPROSES)->count(),
            'resolvedTickets' => Ticket::forUser($userId)->status(TicketStatus::SELESAI)->count(),
            'recentTickets' => Ticket::forUser($userId)
                ->with(['category', 'assignee'])
                ->latest()
                ->take(5)
                ->get(),
            'categories' => Category::active()->get(),
            'unreadCount' => $this->getUnreadCount($userId),
        ]);
    }

    private function getUnreadCount(int $userId): int
    {
        return Ticket::forUser($userId)
            ->get()
            ->sum(fn ($ticket) => $ticket->unreadMessagesCount($userId));
    }
}

