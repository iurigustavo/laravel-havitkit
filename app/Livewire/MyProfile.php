<?php

namespace App\Livewire;

use App\Actions\User\UpdatePasswordAction;
use App\Actions\User\UpdateProfileAction;
use App\Livewire\Forms\Settings\UserForm;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;

class MyProfile extends Component
{
    use Toast, WithFileUploads;

    public UserForm $form;
    public User     $user;
    public string   $selectedTab = 'user-tab';


    public function mount(): void
    {
        $this->user = auth()->user();
        $this->form->fill($this->user);
    }

    public function save(UpdateProfileAction $action): void
    {
        $this->form->validateProfile();

        $action->handle(auth()->user(), $this->form);

        $this->success(__('form.updated'), redirectTo: route('my-profile'));
    }

    public function changePassword(UpdatePasswordAction $action): void
    {
        $this->form->validatePassword();

        $action->handle(auth()->user(), $this->form);

        $this->success(__('form.updated'), redirectTo: route('my-profile'));
    }

    public function render()
    {
        return view('livewire.my-profile');
    }
}
