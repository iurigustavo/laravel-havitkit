<?php

namespace App\Actions\User;

use App\Livewire\Forms\Settings\UserForm;
use App\Models\User;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateProfileAction
{
    use AsAction;

    public function handle(User $user, UserForm $data): User
    {
        $user->name  = $data->name;
        $user->email = $data->email;

        if ($data->avatar_file instanceof TemporaryUploadedFile) {
            $user->avatar = $data->avatar_file->storePublicly('users', 's3');
        }

        $user->save();

        return $user;
    }
}
