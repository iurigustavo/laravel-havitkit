<?php

namespace App\Livewire\Task;

use App\Models\Task;
use App\Traits\ResetsPaginationWhenPropsChanges;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class ListTasks extends Component
{
    use Toast;
    use WithPagination;
    use ResetsPaginationWhenPropsChanges;

    #[Url]
    public string $name = '';

    #[Url]
    public array $sortBy = ['column' => 'id', 'direction' => 'asc'];

    #[Url]
    public int $perPage = 10;

    public $selectedTab = 'todo-tab';

    public function render()
    {
        return view('livewire.tasks.list-tasks')->with(
            [
                'tasks'   => $this->tasks(),
                'headers' => $this->headers(),
            ]
        );
    }

    public function tasks(): LengthAwarePaginator
    {
        return Task::query()
            ->when($this->name, fn(Builder $q) => $q->whereAny(['title', 'code', 'description'], 'like', "%$this->name%"))
            ->orderBy(...array_values($this->sortBy))
            ->paginate($this->perPage);
    }

    public function headers(): array
    {
        return [
            ['key' => 'id', 'label' => '#', 'class' => 'hidden lg:table-cell'],
            ['key' => 'code', 'label' => 'Code', 'sortBy' => 'code'],
            ['key' => 'title', 'label' => 'Title'],
            ['key' => 'status', 'label' => 'Status'],
            ['key' => 'expires_at', 'label' => 'Expires at', 'sortBy' => 'expires_at'],
        ];
    }

}
