<?php

namespace App\Actions\User;

use App\Livewire\Forms\Settings\UserForm;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdatePasswordAction
{
    use AsAction;

    public function handle(User $user, UserForm $data): User
    {
        $user->password = bcrypt($data->password);

        $user->save();

        return $user;
    }
}
