<?php

namespace App\Livewire\Settings\Permissions;

use App\Actions\Permission\DeletePermissionAction;
use App\Models\Permission;
use App\Traits\ResetsPaginationWhenPropsChanges;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class Index extends Component
{
    use ResetsPaginationWhenPropsChanges;
    use Toast;
    use WithPagination;

    #[Url]
    public string $name = '';

    #[Url]
    public array $sortBy = ['column' => 'id', 'direction' => 'asc'];

    #[Url]
    public int $perPage = 20;

    public ?Permission $permission = null;

    public function render()
    {
        return view('livewire.settings.permissions.index')->with(
            [
                'permissions' => $this->permissions(),
                'headers' => $this->headers(),
            ]
        );
    }

    public function permissions(): LengthAwarePaginator
    {
        return Permission::query()
            ->when($this->name, fn (Builder $q) => $q->where('name', 'like', '%'.$this->name.'%'))
            ->orderBy(...array_values($this->sortBy))
            ->paginate($this->perPage);
    }

    public function edit(Permission $permission): void
    {
        $this->permission = $permission;
    }

    public function headers(): array
    {
        return [
            ['key' => 'id', 'label' => '#', 'class' => 'hidden lg:table-cell'],
            ['key' => 'name', 'label' => 'Permission', 'sortBy' => 'name'],
            ['key' => 'description', 'label' => 'Description', 'sortBy' => 'description'],
        ];
    }

    #[On('permission-saved')]
    #[On('permission-cancel')]
    public function clear(): void
    {
        $this->reset();
    }

    public function delete(Permission $permission): void
    {
        DeletePermissionAction::run($permission);
        $this->success(__('form.deleted'));
        $this->reset();
    }
}
