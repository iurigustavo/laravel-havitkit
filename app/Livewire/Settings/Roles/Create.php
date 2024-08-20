<?php

namespace App\Livewire\Settings\Roles;

use App\Actions\Roles\CreateNewRoleAction;
use App\Livewire\Forms\Settings\RoleForm;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Str;
use Livewire\Component;
use Mary\Traits\Toast;

class Create extends Component
{
    use Toast;

    public RoleForm $form;

    public Role $role;

    public array $allOptions = [];

    public array $permissionsList;

    public function mount(): void
    {
        $this->permissionsList = $this->generateTable();
        $this->allOptions = Permission::query()->pluck('name')->toArray();
    }

    public function save(CreateNewRoleAction $action): void
    {
        $this->form->validate();

        $action->handle($this->form);

        $this->success(__('form.created'), redirectTo: route('management.roles.index'));
    }

    private function generateTable(): array
    {
        $table = [];

        $permissionsHeader = [
            'list',
            'view',
            'create',
            'update',
            'delete',
            'restore',
            'forceDelete',
        ];

        $table['headers'] = $permissionsHeader;

        $permissions = Permission::all();
        foreach ($permissions as $permission) {
            if (Str::startsWith($permission->name, $permissionsHeader)) {
                [$action, $model] = explode(' ', $permission->name);

                $item = [
                    'id' => $permission->id,
                    'name' => $permission->name,
                    'action' => $action,
                    'can' => false,
                ];

                $table['permissions']['models'][$model][$action] = $item;
            } else {
                $table['permissions']['others'][$permission->name] = [
                    'id' => $permission->id,
                    'name' => $permission->name,
                    'action' => $permission->name,
                    'can' => false,
                ];
            }
        }

        return $table;
    }

    public function toggleAll(): void
    {
        $this->form->permissions = count($this->form->permissions) === count($this->allOptions) ? [] : $this->allOptions;
    }

    public function render()
    {
        return view('livewire.settings.roles.show');
    }
}
