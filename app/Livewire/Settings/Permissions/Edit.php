<?php

namespace App\Livewire\Settings\Permissions;

use App\Livewire\Forms\Settings\PermissionForm;
use Exception;
use Livewire\Component;
use Mary\Traits\Toast;
use App\Models\Permission;

class Edit extends Component
{
    use Toast;

    public Permission     $permission;

    public PermissionForm $form;

    public function mount(): void
    {
        $this->form->fill($this->permission);
    }

    public function save(): void
    {
        try {
            $this->permission->update($this->form->validate());
            $this->success(__('form.updated'), redirectTo: route('management.permissions.index'));
        } catch (Exception) {
            $this->error(__('form.error.update'), redirectTo: route('management.permissions.index'));
        }
    }

    public function render()
    {
        return view('livewire.settings.permissions.show');
    }
}
