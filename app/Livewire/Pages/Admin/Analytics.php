<?php

namespace App\Livewire\Pages\Admin;

use App\Enums\TicketStatus;
use App\Models\Category;
use App\Models\Ticket;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Analitik')]
class Analytics extends Component
{
    public function render()
    {
        $categories = Category::withCount('tickets')->get();
        $monthlyData = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthlyData[] = [
                'month' => $date->translatedFormat('M Y'),
                'total' => Ticket::whereYear('created_at', $date->year)->whereMonth('created_at', $date->month)->count(),
                'resolved' => Ticket::whereYear('created_at', $date->year)->whereMonth('created_at', $date->month)->where('status', TicketStatus::SELESAI)->count(),
            ];
        }

        return view('livewire.pages.admin.analytics', [
            'categories' => $categories,
            'monthlyData' => $monthlyData,
            'totalTickets' => Ticket::count(),
            'resolvedTickets' => Ticket::where('status', TicketStatus::SELESAI)->count(),
            'avgResponseTime' => (int) Ticket::whereNotNull('response_time_minutes')->avg('response_time_minutes'),
            'resolutionRate' => Ticket::count() > 0 ? round(Ticket::where('status', TicketStatus::SELESAI)->count() / Ticket::count() * 100, 1) : 0,
        ]);
    }
}
