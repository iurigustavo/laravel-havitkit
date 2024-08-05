<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PermissionPolicy extends AbstractBasePolicy
{
    public function getModel(): string
    {
       return Permission::class;
    }
}
