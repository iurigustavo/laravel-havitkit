<?php

namespace App\Livewire\Settings\Permissions;

use App\Actions\Permission\CreateNewPermissionAction;
use App\Livewire\Forms\Settings\PermissionForm;
use Exception;
use Livewire\Component;
use Mary\Traits\Toast;

class Create extends Component
{
    use Toast;

    public bool $show = false;

    public bool $isCreate = true;

    public PermissionForm $form;

    public function save(CreateNewPermissionAction $action): void
    {
        $this->form->validate();

        try {
            $permission = $action->run($this->form);

            $this->show = false;
            $this->dispatch('permission-saved', id: $permission->id);
            $this->form->reset();
            $this->success(__('form.created'));
        } catch (Exception) {
            $this->error(__('form.error.create'));
        }

    }

    public function render()
    {
        return view('livewire.settings.permissions.show');
    }
}
