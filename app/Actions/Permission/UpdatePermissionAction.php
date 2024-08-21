<?php

namespace App\Actions\Permission;

use App\Livewire\Forms\Settings\PermissionForm;
use App\Models\Permission;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdatePermissionAction
{
    use AsAction;

    public function handle(Permission $permission, PermissionForm $data): Permission
    {
        $permission->name = $data->name;
        $permission->description = $data->description;
        $permission->save();

        return $permission;
    }
}
