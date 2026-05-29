<?php

namespace App\Livewire\Pages;

use App\Models\Ticket;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.guest')]
#[Title('Lacak Laporan - TicketLapor')]
class TrackTicket extends Component
{
    public string $ticketNumber = '';
    public ?Ticket $ticket = null;
    public bool $searched = false;
    public ?string $error = null;

    public function track()
    {
        $this->error = null;
        $this->ticket = null;
        $this->searched = true;

        if (empty(trim($this->ticketNumber))) {
            $this->error = 'Masukkan nomor tiket terlebih dahulu.';
            return;
        }

        $this->ticket = Ticket::with(['category', 'messages' => function ($q) {
            $q->latest()->take(5);
        }])->where('ticket_number', strtoupper(trim($this->ticketNumber)))->first();

        if (!$this->ticket) {
            $this->error = 'Tiket dengan nomor "' . $this->ticketNumber . '" tidak ditemukan. Pastikan format nomor benar (contoh: TK-2026-000001).';
        }
    }

    public function render()
    {
        return view('livewire.pages.track-ticket');
    }
}
