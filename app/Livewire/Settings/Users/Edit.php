<?php

namespace App\Livewire\Settings\Users;

use App\Actions\User\UpdateUserAction;
use App\Livewire\Forms\Settings\UserForm;
use App\Models\User;
use Exception;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;
use App\Models\Role;

class Edit extends Component
{
    use Toast, WithFileUploads;

    public User       $user;
    public UserForm   $form;
    public Collection $rolesList;

    public function mount()
    {
        $this->form->fill($this->user);
        $this->form->roles  = $this->user->roles()->pluck('id')->toArray();
        $this->form->active = (int)$this->user->active;
        $this->rolesList    = Role::all();
    }

    public function save(UpdateUserAction $action): void
    {
        $this->form->validateUpdate();
        try {
            $action->handle($this->user, $this->form);
            $this->success(__('form.updated'), redirectTo: route('management.users.index'));
        } catch (Exception $e) {
            $this->error(__('form.error.update'), redirectTo: route('management.users.index'));
        }
    }

    public function render()
    {
        return view('livewire.settings.users.show');
    }
}
