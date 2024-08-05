<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskPolicy extends AbstractBasePolicy
{
    public function getModel(): string
    {
       return Task::class;
    }
}
