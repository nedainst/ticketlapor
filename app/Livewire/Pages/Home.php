<?php

namespace App\Livewire\Pages;

use App\Models\Category;
use App\Models\Ticket;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.guest')]
#[Title('TicketLapor - Suara Anda, Perubahan Nyata')]
class Home extends Component
{
    public function render()
    {
        return view('livewire.pages.home', [
            'categories' => Category::active()->withCount('tickets')->get(),
            'totalTickets' => Ticket::count(),
            'resolvedTickets' => Ticket::where('status', 'selesai')->count(),
            'avgResponseTime' => (int) Ticket::whereNotNull('response_time_minutes')->avg('response_time_minutes'),
        ]);
    }
}
