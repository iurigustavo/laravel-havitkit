<?php

namespace App\Livewire\Settings\Roles;

use App\Actions\Role\DeleteRoleAction;
use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Url;
use Livewire\Component;
use Mary\Traits\Toast;

class Index extends Component
{
    use Toast;

    #[Url]
    public string $name = '';

    #[Url]
    public array $sortBy = ['column' => 'id', 'direction' => 'asc'];

    public function render()
    {
        return view('livewire.settings.roles.index')->with(
            [
                'roles' => $this->roles(),
                'headers' => $this->headers(),
            ]
        );
    }

    public function roles(): LengthAwarePaginator
    {
        return Role::query()->withCount(['permissions'])
            ->when($this->name, fn (Builder $q) => $q->where('name', 'like', sprintf('%%%s%%', $this->name)))
            ->orderBy(...array_values($this->sortBy))
            ->paginate(10);
    }

    public function headers(): array
    {
        return [
            ['key' => 'id', 'label' => '#', 'class' => 'hidden lg:table-cell'],
            ['key' => 'name', 'label' => 'Name', 'sortBy' => 'name'],
            ['key' => 'description', 'label' => 'Description', 'sortBy' => 'description'],
            ['key' => 'guard_name', 'label' => 'Guard'],
            ['key' => 'permissions_count', 'label' => 'Permissions'],
        ];
    }

    public function delete(Role $role, DeleteRoleAction $action): void
    {
        $action->handle($role);
        $this->success(__('form.deleted'));
    }
}
