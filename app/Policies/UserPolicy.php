<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Str;

class UserPolicy
{
    public function before(User $user, $ability): ?bool
    {
        if ($user->hasPermissionTo('management')) {
            return true;
        }

        return null;
    }

    public function getModel(): string
    {
        return User::class;
    }

    private function getModelName(): string
    {
        return Str::of($this->getModel())->basename()->afterLast('\\')->lower()->toString();
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('list '.$this->getModelName());
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return $user->can('view '.$this->getModelName());
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create '.$this->getModelName());
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        return $user->can('update '.$this->getModelName());
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        return $user->can('delete '.$this->getModelName());
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return $user->can('restore '.$this->getModelName());
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return $user->can('forceDelete '.$this->getModelName());
    }
}
