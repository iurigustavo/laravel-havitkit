<?php

namespace App\Livewire\Settings\Roles;

use App\Actions\Roles\CreateNewRoleAction;
use App\Livewire\Forms\Settings\RoleForm;
use App\Models\Permission;
use Illuminate\Support\Collection;
use Livewire\Component;
use Mary\Traits\Toast;

class Create extends Component
{
    use Toast;

    public RoleForm   $form;
    public Collection $permissionsList;

    public function mount()
    {
        $this->permissionsList = Permission::all();
    }

    public function save(CreateNewRoleAction $action): void
    {
        $this->form->validate();

        $action->handle($this->form);

        $this->success(__('form.created'), redirectTo: route('management.roles.index'));
    }

    public function render()
    {
        return view('livewire.settings.roles.show');
    }
}
