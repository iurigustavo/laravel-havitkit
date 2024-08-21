<?php

namespace App\Actions\Menu;

use App\Livewire\Forms\Settings\MenuForm;
use App\Models\Menu;
use Illuminate\Support\Facades\Cache;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateMenuAction
{
    use AsAction;

    public function handle(Menu $menu, MenuForm $data): Menu
    {
        $menu->name = $data->name;
        $menu->handle = $data->handle;
        $menu->items = $data->items;

        $menu->save();

        Cache::forget('menu-'.$data->handle);

        return $menu;
    }
}
