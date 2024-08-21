<?php

namespace App\Actions\Menu;

use App\Livewire\Forms\Settings\MenuForm;
use App\Models\Menu;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateNewMenuAction
{
    use AsAction;

    public function handle(MenuForm $data): Menu
    {
        return Menu::create(['name' => $data->name, 'handle' => $data->handle, 'items' => $data->items]);
    }
}
