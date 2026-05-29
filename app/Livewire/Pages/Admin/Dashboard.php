<?php

namespace App\Livewire\Pages\Admin;

use App\Enums\TicketStatus;
use App\Models\Category;
use App\Models\Ticket;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Admin Dashboard')]
class Dashboard extends Component
{
    public function render()
    {
        $categoryStats = Category::withCount('tickets')->get();

        return view('livewire.pages.admin.dashboard', [
            'totalTickets' => Ticket::count(),
            'pendingTickets' => Ticket::where('status', TicketStatus::PENDING)->count(),
            'processedTickets' => Ticket::where('status', TicketStatus::DIPROSES)->count(),
            'resolvedTickets' => Ticket::where('status', TicketStatus::SELESAI)->count(),
            'todayTickets' => Ticket::whereDate('created_at', today())->count(),
            'avgResponseTime' => (int) Ticket::whereNotNull('response_time_minutes')->avg('response_time_minutes'),
            'totalUsers' => User::role('masyarakat')->count(),
            'categoryStats' => $categoryStats,
            'recentTickets' => Ticket::with(['user', 'category'])->latest()->take(8)->get(),
            'monthlyData' => $this->getMonthlyData(),
        ]);
    }

    private function getMonthlyData(): array
    {
        $data = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $data[] = [
                'month' => $date->translatedFormat('M'),
                'total' => Ticket::whereYear('created_at', $date->year)->whereMonth('created_at', $date->month)->count(),
                'resolved' => Ticket::whereYear('created_at', $date->year)->whereMonth('created_at', $date->month)->where('status', TicketStatus::SELESAI)->count(),
            ];
        }
        return $data;
    }
}
