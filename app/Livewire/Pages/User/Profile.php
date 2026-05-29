<?php

namespace App\Livewire\Pages\User;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\KtpScannerService;
use Exception;

#[Layout('components.layouts.app')]
#[Title('Profil Saya')]
class Profile extends Component
{
    use WithFileUploads;

    #[Validate('required|string|max:255')]
    public string $name = '';
    #[Validate('required|email')]
    public string $email = '';
    #[Validate('nullable|string|max:20')]
    public string $phone = '';
    #[Validate('nullable|string|size:16')]
    public string $nik = '';
    #[Validate('nullable|string')]
    public string $address = '';
    public $avatar = null;

    public $ktpPhoto;
    public ?string $scanError = null;

    public function updatedKtpPhoto()
    {
        $this->scanError = null;
        
        if (!$this->ktpPhoto) {
            return;
        }

        try {
            $scanner = new KtpScannerService();
            $data = $scanner->process($this->ktpPhoto);

            if ($data['nik']) $this->nik = $data['nik'];
            if ($data['name']) $this->name = $data['name'];
            if ($data['address']) $this->address = $data['address'];

            if (!$data['nik'] && !$data['name']) {
                $this->scanError = 'Data KTP tidak terdeteksi jelas. Silakan input manual.';
            } else {
                $this->dispatch('toast', message: 'KTP berhasil dipindai dan dikonversi ke PDF', type: 'success');
            }
        } catch (Exception $e) {
            $this->scanError = 'Gagal memproses gambar: ' . $e->getMessage();
        }
    }

    public function mount()
    {
        $user = auth()->user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone ?? '';
        $this->nik = $user->nik ?? '';
        $this->address = $user->address ?? '';
    }

    public function updateProfile()
    {
        $this->validate();
        $user = auth()->user();
        // Skip unique check for current user
        $this->validate(['nik' => 'nullable|string|size:16|unique:users,nik,' . $user->id]);
        
        $data = ['name' => $this->name, 'email' => $this->email, 'phone' => $this->phone ?: null, 'nik' => $this->nik ?: null, 'address' => $this->address ?: null];

        if ($this->avatar) {
            $data['avatar'] = $this->avatar->store('avatars', 'public');
        }

        $user->update($data);
        $this->dispatch('toast', message: 'Profil berhasil diperbarui', type: 'success');
    }

    public function render()
    {
        return view('livewire.pages.user.profile');
    }
}
