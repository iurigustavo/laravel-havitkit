<?php

namespace App\Livewire\Settings\Roles;

use App\Actions\Role\UpdateRoleAction;
use App\Livewire\Forms\Settings\RoleForm;
use App\Models\Permission;
use App\Models\Role;
use Exception;
use Illuminate\Support\Str;
use Livewire\Component;
use Mary\Traits\Toast;

class Edit extends Component
{
    use Toast;

    public Role $role;

    public RoleForm $form;

    public array $allOptions = [];

    public array $permissionsList;

    public function mount(): void
    {
        $this->form->fill($this->role);
        $this->form->permissions = $this->role->permissions()->pluck('name')->toArray();
        $this->permissionsList = $this->generateTable();
        $this->allOptions = Permission::query()->pluck('name')->toArray();
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
                    'can' => $this->role->hasPermissionTo($permission->name),
                ];

                $table['permissions']['models'][$model][$action] = $item;
            } else {
                $table['permissions']['others'][$permission->name] = [
                    'id' => $permission->id,
                    'name' => $permission->name,
                    'action' => $permission->name,
                    'can' => $this->role->hasPermissionTo($permission->name),
                ];
            }
        }

        return $table;
    }

    public function toggleAll(): void
    {
        $this->form->permissions = count($this->form->permissions) === count($this->allOptions) ? [] : $this->allOptions;
    }

    public function save(UpdateRoleAction $action): void
    {
        $this->form->validate();
        try {
            $action->handle($this->role, $this->form);
            $this->success(__('form.updated'), redirectTo: route('management.roles.index'));
        } catch (Exception) {
            $this->error(__('form.error.update'), redirectTo: route('management.roles.index'));
        }
    }

    public function render()
    {
        return view('livewire.settings.roles.show');
    }
}
