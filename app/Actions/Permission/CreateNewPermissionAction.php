<?php

namespace App\Actions\Permission;

use App\Livewire\Forms\Settings\PermissionForm;
use App\Models\Permission;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateNewPermissionAction
{
    use AsAction;

    public function handle(PermissionForm $data): Permission
    {
        return Permission::create(['name' => $data->name, 'description' => $data->description]);
    }
}
