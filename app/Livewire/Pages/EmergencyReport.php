<?php

namespace App\Livewire\Pages;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Models\Category;
use App\Models\Ticket;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.guest')]
#[Title('Laporan Darurat')]
class EmergencyReport extends Component
{
    use WithFileUploads;

    #[Validate('required|string|max:255')]
    public string $reporter_name = '';

    #[Validate('required|string|max:20')]
    public string $reporter_phone = '';

    #[Validate('required|exists:categories,id')]
    public string $category_id = '';

    #[Validate('required|string|max:255')]
    public string $title = '';

    #[Validate('required|string')]
    public string $description = '';

    #[Validate('nullable|image|max:10240')]
    public $photo;

    #[Validate('nullable|numeric|between:-90,90')]
    public ?float $latitude = null;

    #[Validate('nullable|numeric|between:-180,180')]
    public ?float $longitude = null;

    public ?Ticket $submittedTicket = null;

    public function submit()
    {
        $this->validate();

        $ticket = Ticket::create([
            'reporter_name' => $this->reporter_name,
            'reporter_phone' => $this->reporter_phone,
            'category_id' => $this->category_id,
            'title' => $this->title,
            'description' => $this->description,
            'priority' => TicketPriority::DARURAT->value,
            'status' => TicketStatus::PENDING->value,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            // user_id is left null explicitly for emergency public tickets
        ]);

        if ($this->photo) {
            $path = $this->photo->store('attachments', 'public');
            $ticket->attachments()->create([
                'file_path' => $path,
                'file_name' => $this->photo->getClientOriginalName(),
                'file_type' => $this->photo->getMimeType(),
                'file_size' => $this->photo->getSize(),
            ]);
        }

        $this->submittedTicket = $ticket;
    }

    public function render()
    {
        return view('livewire.pages.emergency-report', [
            'categories' => Category::active()->get(),
        ]);
    }
}
