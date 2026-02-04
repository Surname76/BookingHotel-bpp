<?php

namespace App\Livewire\Pages;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Login')]
#[Layout('layouts.app')]
class Login extends Component
{
    public string $email = '';
    public string $password = '';
    public bool $remember = false;

    public function submit(): void
    {
        $credentials = $this->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $this->remember)) {
            $this->addError('email', 'Email atau password salah.');
            return;
        }

        request()->session()->regenerate();

        $user = Auth::user();
        if ($user && (bool) $user->is_admin) {
            $this->redirectRoute('admin.dashboard', navigate: true);
            return;
        }

        $this->redirectRoute('dashboard', navigate: true);
    }

    public function render()
    {
        return view('livewire.pages.login');
    }
}

