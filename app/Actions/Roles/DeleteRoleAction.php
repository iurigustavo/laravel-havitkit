<?php

namespace App\Actions\Roles;

use Lorisleiva\Actions\Concerns\AsAction;
use Spatie\Permission\Models\Role;

class DeleteRoleAction
{
    use AsAction;

    public function handle(Role $role): ?bool
    {
        return $role->delete();
    }
}
