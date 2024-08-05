<?php

namespace App\Livewire\Settings\Permissions;

use App\Livewire\Forms\Settings\PermissionForm;
use Livewire\Component;
use Mary\Traits\Toast;
use App\Models\Permission;

class Create extends Component
{
    use Toast;

    public PermissionForm $form;

    public function save(): void
    {
        Permission::create($this->form->validate());

        $this->success(__('form.created'), redirectTo: route('management.permissions.index'));
    }

    public function render()
    {
        return view('livewire.settings.permissions.show');
    }
}
