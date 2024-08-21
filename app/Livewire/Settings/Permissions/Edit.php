<?php

namespace App\Livewire\Settings\Permissions;

use App\Actions\Permission\UpdatePermissionAction;
use App\Livewire\Forms\Settings\PermissionForm;
use App\Models\Permission;
use Exception;
use Livewire\Attributes\Modelable;
use Livewire\Component;
use Mary\Traits\Toast;

class Edit extends Component
{
    use Toast;

    #[Modelable]
    public ?Permission $permission = null;

    public bool $show = false;

    public PermissionForm $form;

    public function boot(): void
    {
        if (! $this->permission instanceof Permission) {
            $this->show = false;
        }
    }

    public function save(UpdatePermissionAction $action): void
    {
        $this->form->validate();

        try {
            $action->run($this->permission, $this->form);

            $this->show = false;
            $this->dispatch('permission-saved', id: $this->permission->id);
            $this->form->reset();
            $this->success(__('form.updated'));
        } catch (Exception) {
            $this->error(__('form.error.update'));
        }
    }

    public function render()
    {
        if ($this->permission instanceof Permission) {
            $this->show = true;
            $this->form->fill($this->permission);
        }

        return view('livewire.settings.permissions.show');
    }
}
