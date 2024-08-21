<?php

namespace App\Livewire\Settings\Users;

use App\Models\User;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $this->authorize('viewAny', User::class);

        return view('livewire.settings.users.index');
    }
}
