<?php

namespace App\Livewire\Auth;

use Livewire\Attributes\Validate;
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

    #[Validate('required|email')]
    public string $email = 'admin@admin.com';

    #[Validate('required|string')]
    public string $password = '123456';

    public bool $remember = false;

    public function login(Request $request)
    {
        $this->validate();

        if (auth()->user()) {
            return redirect('/');
        }

        if (! Auth::attempt($this->validate(), $this->remember)) {
            $this->addError('email', __('auth.failed'));

            return null;
        }

        $request->session()->regenerate();

        return redirect()->intended();
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
