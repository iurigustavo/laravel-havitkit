<?php

namespace App\Policies;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Support\Str;

class MenuPolicy
{
    public function before(User $user, $ability): ?true
    {
        if ($user->hasPermissionTo('management')) {
            return true;
        }

        return null;
    }

    public function getModel(): string
    {
        return Menu::class;
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
    public function view(User $user, Menu $menu): bool
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
    public function update(User $user, Menu $menu): bool
    {
        return $user->can('update '.$this->getModelName());
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Menu $menu): bool
    {
        return $user->can('delete '.$this->getModelName());
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Menu $menu): bool
    {
        return $user->can('restore '.$this->getModelName());
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Menu $menu): bool
    {
        return $user->can('forceDelete '.$this->getModelName());
    }
}
