<?php

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class DeleteUserAction
{
    use AsAction;

    public function handle(User $user): ?bool
    {
        DB::table('model_has_roles')->where('model_id', $user->id)->delete();

        return $user->delete();
    }
}
