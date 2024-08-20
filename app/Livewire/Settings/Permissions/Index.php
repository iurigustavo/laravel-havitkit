<?php

namespace App\Livewire\Settings\Permissions;

use App\Models\Permission;
use App\Traits\ResetsPaginationWhenPropsChanges;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class Index extends Component
{
    use Toast;
    use WithPagination;
    use ResetsPaginationWhenPropsChanges;
    #[Url]
    public string $name = '';

    #[Url]
    public array $sortBy = ['column' => 'id', 'direction' => 'asc'];

    #[Url]
    public int $perPage = 20;

    public function render()
    {
        return view('livewire.settings.permissions.index')->with(
            [
                'permissions' => $this->permissions(),
                'headers'     => $this->headers(),
            ]
        );
    }

    public function permissions(): LengthAwarePaginator
    {
        return Permission::query()
            ->when($this->name, fn(Builder $q) => $q->where('name', 'like', sprintf('%%%s%%', $this->name)))
            ->orderBy(...array_values($this->sortBy))
            ->paginate($this->perPage);
    }

    public function headers(): array
    {
        return [
            ['key' => 'id', 'label' => '#', 'class' => 'hidden lg:table-cell'],
            ['key' => 'name', 'label' => 'Permission', 'sortBy' => 'name'],
            ['key' => 'description', 'label' => 'Description', 'sortBy' => 'description'],
        ];
    }

    public function delete(Permission $permission): void
    {
        $permission->delete();
        $this->success(__('form.deleted'));
    }
}
