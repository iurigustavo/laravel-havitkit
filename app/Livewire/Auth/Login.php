<?php

namespace App\Livewire\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Mary\Traits\Toast;

#[Layout('components.layouts.empty')]
class Login extends Component
{
    use Toast;

    #[Rule('required|email')]
    public string $email    = '';
    #[Rule('required|string')]
    public string $password = '';
    public bool   $remember = false;

    public function login(Request $request)
    {
        $this->validate();

        if (auth()->user()) {
            return redirect('/');
        }

        if (!Auth::attempt($this->validate(), $this->remember)) {
            $this->addError('email', __('auth.failed'));

            return;
        }

        $request->session()->regenerate();

        return redirect()->intended();
    }

    public function render()
    {
        return view('livewire.auth.login');
    }


}
