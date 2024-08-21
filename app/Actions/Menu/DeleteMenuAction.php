<?php

namespace App\Actions\Menu;

use App\Models\Menu;
use Lorisleiva\Actions\Concerns\AsAction;

class DeleteMenuAction
{
    use AsAction;

    public function handle(Menu $menu): ?bool
    {
        return $menu->delete();
    }
}
