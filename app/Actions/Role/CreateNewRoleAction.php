<?php

namespace App\Actions\Role;

use App\Livewire\Forms\Settings\RoleForm;
use Lorisleiva\Actions\Concerns\AsAction;
use Spatie\Permission\Models\Role;

class CreateNewRoleAction
{
    use AsAction;

    public function handle(RoleForm $data): Role
    {
        $role = Role::create(['name' => $data->name, 'description' => $data->description]);

        $role->givePermissionTo($data->permissions);

        return $role;
    }
}
