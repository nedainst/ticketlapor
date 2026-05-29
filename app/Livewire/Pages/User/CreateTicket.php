<?php

namespace App\Livewire\Pages\User;

use App\Enums\TicketPriority;
use App\Models\Category;
use App\Services\TicketService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.app')]
#[Title('Buat Laporan Baru')]
class CreateTicket extends Component
{
    use WithFileUploads;

    #[Url(as: 'kategori')]
    public string $category_id = '';

    #[Validate('required|string|max:255')]
    public string $title = '';

    #[Validate('required|in:rendah,sedang,tinggi,darurat')]
    public string $priority = 'sedang';

    #[Validate('required|string|min:20')]
    public string $description = '';

    public ?float $latitude = null;
    public ?float $longitude = null;
    public ?string $address = '';

    #[Validate(['files.*' => 'file|max:10240|mimes:jpg,jpeg,png,gif,pdf,mp4,webm'])]
    public array $files = [];

    public int $step = 1;

    public function nextStep()
    {
        if ($this->step === 1) {
            $this->validate([
                'title' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'priority' => 'required|in:rendah,sedang,tinggi,darurat',
            ]);
        } elseif ($this->step === 2) {
            $this->validate([
                'description' => 'required|string|min:20',
            ]);
        }

        $this->step++;
    }

    public function previousStep()
    {
        $this->step = max(1, $this->step - 1);
    }

    public function removeFile($index)
    {
        unset($this->files[$index]);
        $this->files = array_values($this->files);
    }

    public function submit(TicketService $ticketService)
    {
        $this->validate();

        $uploadedFiles = [];
        foreach ($this->files as $file) {
            $uploadedFiles[] = $file;
        }

        $ticket = $ticketService->create([
            'title' => $this->title,
            'category_id' => $this->category_id,
            'priority' => $this->priority,
            'description' => $this->description,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'address' => $this->address,
        ], $uploadedFiles);

        session()->flash('success', 'Laporan berhasil dibuat dengan nomor ' . $ticket->ticket_number);

        return $this->redirect(route('user.tickets.show', $ticket), navigate: true);
    }

    public function render()
    {
        return view('livewire.pages.user.create-ticket', [
            'categories' => Category::active()->get(),
            'priorities' => TicketPriority::cases(),
        ]);
    }
}
