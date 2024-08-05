<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy extends AbstractBasePolicy
{
    public function getModel(): string
    {
       return User::class;
    }
}
