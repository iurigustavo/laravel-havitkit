<?php

namespace App\Livewire\Forms\Settings;

use Livewire\Attributes\Validate;
use Livewire\Form;

class MenuForm extends Form
{
    #[Validate(['required'])]
    public $handle = '';

    #[Validate(['required'])]
    public array $items = [];

    #[Validate(['required'])]
    public $name = '';
}
