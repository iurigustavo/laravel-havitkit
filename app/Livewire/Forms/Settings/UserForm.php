<?php

namespace App\Livewire\Forms\Settings;

use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Form;

class UserForm extends Form
{
    public $name  = '';

    public $email = '';

    /**
     * @var TemporaryUploadedFile
     */
    public         $avatar_file;

    public bool    $active                = true;

    public ?string $password              = '';

    public ?string $password_confirmation = '';

    public array   $roles                 = [];

    public function rules(): array
    {
        return [
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'email', 'max:255', 'unique:users,email'],
            'avatar_file'           => ['nullable', 'image', 'max:1024'],
            'active'                => ['boolean', 'required'],
            'password'              => ['required', 'confirmed'],
            'password_confirmation' => ['required'],
            'roles'                 => ['required', 'array'],
        ];
    }

    public function validateUpdate(): void
    {
        $this->validate([
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'email', 'max:255'],
            'avatar_file'           => ['nullable', 'image', 'max:1024'],
            'active'                => ['boolean', 'required'],
            'password'              => ['nullable', 'confirmed'],
            'password_confirmation' => ['nullable'],
            'roles'                 => ['required', 'array'],
        ]);
    }

    public function validateProfile(): void
    {
        $this->validate([
            'name'        => ['required', 'string', 'max:255'],
            'email'       => ['required', 'email', 'max:255'],
            'avatar_file' => ['nullable', 'image', 'max:1024'],
        ]);
    }

    public function validatePassword(): void
    {
        $this->validate([
            'password'              => ['required', 'confirmed'],
            'password_confirmation' => ['required'],
        ]);
    }
}
