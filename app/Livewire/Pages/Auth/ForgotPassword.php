<?php

namespace App\Livewire\Pages\Auth;

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.layouts.guest')]
#[Title('Lupa Password - TicketLapor')]
class ForgotPassword extends Component
{
    #[Validate('required|email')]
    public string $email = '';
    public bool $sent = false;

    public function sendResetLink()
    {
        $this->validate();
        $status = Password::sendResetLink(['email' => $this->email]);
        if ($status === Password::RESET_LINK_SENT) {
            $this->sent = true;
        } else {
            $this->addError('email', 'Email tidak ditemukan.');
        }
    }

    public function render()
    {
        return view('livewire.pages.auth.forgot-password');
    }
}
