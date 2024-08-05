<?php

namespace App\Livewire\Forms\Settings;

use Livewire\Attributes\Validate;
use Livewire\Form;

class RoleForm extends Form
{
    #[Validate(['required'])]
    public $name = '';

    #[Validate(['required'])]
    public $description = '';

    #[Validate(['required', 'array'])]
    public $permissions = [];

    #[Validate(['nullable'])]
    public $guard_name = 'web';
}
