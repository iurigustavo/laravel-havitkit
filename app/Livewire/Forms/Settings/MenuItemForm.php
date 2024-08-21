<?php

namespace App\Livewire\Forms\Settings;

use Livewire\Attributes\Validate;
use Livewire\Form;

class MenuItemForm extends Form
{
    #[Validate(['required'])]
    public $label = '';

    #[Validate(['nullable'])]
    public $description = '';

    #[Validate(['required'])]
    public $url = '';

    #[Validate(['nullable'])]
    public $type = '';

    #[Validate(['nullable'])]
    public $icon = '';

    #[Validate(['nullable'])]
    public array $permissions = [];

    public array $items = [];

    public array $types = [['id' => 'internal', 'name' => 'Internal'], ['id' => 'external', 'name' => 'External'], ['id' => 'separator', 'name' => 'Separator']];

    public function getData()
    {
        return ['label' => $this->label, 'description' => $this->description, 'icon' => $this->icon, 'type' => $this->type, 'url' => $this->url, 'permissions' => $this->permissions];
    }
}
