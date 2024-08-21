<?php

namespace App\Actions\Role;

use App\Livewire\Forms\Settings\RoleForm;
use Lorisleiva\Actions\Concerns\AsAction;
use Spatie\Permission\Models\Role;

class UpdateRoleAction
{
    use AsAction;

    public function handle(Role $role, RoleForm $data): Role
    {
        $role->name = $data->name;
        $role->description = $data->description;
        $role->save();
        $role->syncPermissions($data->permissions);

        return $role;
    }
}
