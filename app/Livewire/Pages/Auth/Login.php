<?php

namespace App\Livewire\Pages\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.layouts.guest')]
#[Title('Masuk - TicketLapor')]
class Login extends Component
{
    #[Validate('required|email')]
    public string $email = '';

    #[Validate('required|min:6')]
    public string $password = '';

    public bool $remember = false;

    public function login()
    {
        $this->validate();

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            $this->addError('email', 'Email atau password tidak valid.');
            return;
        }

        session()->regenerate();

        $user = Auth::user();

        if ($user->isAdmin()) {
            return $this->redirect(route('admin.dashboard'), navigate: true);
        }

        return $this->redirect(route('user.dashboard'), navigate: true);
    }

    public function render()
    {
        return view('livewire.pages.auth.login');
    }
}
