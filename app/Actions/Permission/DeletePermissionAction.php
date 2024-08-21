<?php

namespace App\Actions\Permission;

use App\Models\Permission;
use Lorisleiva\Actions\Concerns\AsAction;

class DeletePermissionAction
{
    use AsAction;

    public function handle(Permission $permission): ?bool
    {
        return $permission->delete();
    }
}
