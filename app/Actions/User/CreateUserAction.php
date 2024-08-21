<?php

namespace App\Actions\User;

use App\Livewire\Forms\Settings\UserForm;
use App\Models\User;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateUserAction
{
    use AsAction;

    public function handle(UserForm $data): User
    {
        $user = new User;
        $user->name = $data->name;
        $user->email = $data->email;
        $user->password = bcrypt($data->password);
        $user->active = $data->active;

        if ($data->avatar_file instanceof TemporaryUploadedFile) {
            $user->avatar = $data->avatar_file->store('users', 'public');
        }

        $user->save();
        $user->syncRoles($data->roles);

        return $user;
    }
}
