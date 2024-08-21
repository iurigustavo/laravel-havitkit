<?php

namespace App\Policies;

use App\Models\Menu;

class MenuPolicy extends AbstractBasePolicy
{
    public function getModel(): string
    {
        return Menu::class;
    }
}
