<?php

namespace App\Livewire\Settings\Users;

use App\Actions\User\CreateUserAction;
use App\Livewire\Forms\Settings\UserForm;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;
use App\Models\Role;

class Create extends Component
{
    use Toast, WithFileUploads;

    public UserForm   $form;
    public Collection $rolesList;

    public function mount(): void
    {
        $this->rolesList = Role::all();
    }

    public function save(CreateUserAction $action): void
    {
        $this->form->validate($this->form->rules());

        $action->handle($this->form);

        $this->success(__('form.created'), redirectTo: route('management.users.index'));
    }

    public function render()
    {
        return view('livewire.settings.users.show');
    }
}
