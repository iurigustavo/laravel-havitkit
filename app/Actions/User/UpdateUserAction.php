<?php

namespace App\Actions\User;

use App\Livewire\Forms\Settings\UserForm;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateUserAction
{
    use AsAction;

    public function handle(User $user, UserForm $data): User
    {
        $user->name   = $data->name;
        $user->email  = $data->email;
        $user->active = $data->active;

        if ($data->avatar_file instanceof TemporaryUploadedFile) {
            $user->avatar = $data->avatar_file->storePublicly('users', 's3');
        }

        if ($data->password !== null && $data->password !== '' && $data->password !== '0') {
            $user->password = bcrypt($data->password);
        }

        DB::table('model_has_roles')->where('model_id', $user->id)->delete();

        $user->save();
        $user->syncRoles($data->roles);

        return $user;
    }
}
