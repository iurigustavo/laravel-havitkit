<?php

namespace App\Livewire\Forms\Settings;

use Livewire\Attributes\Validate;
use Livewire\Form;

class PermissionForm extends Form
{
    #[Validate(['required'])]
    public $name = '';

    #[Validate(['required'])]
    public $description = '';

    #[Validate(['nullable'])]
    public $guard_name = 'web';
}
