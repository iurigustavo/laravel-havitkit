<?php

namespace App\Livewire\Settings\Menus;

use App\Models\Menu;
use App\Traits\ClearsProperties;
use App\Traits\ResetsPaginationWhenPropsChanges;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use ClearsProperties;
    use ResetsPaginationWhenPropsChanges;
    use WithPagination;

    #[Url]
    public array $sortBy = ['column' => 'id', 'direction' => 'desc'];

    #[Url]
    public string $search = '';

    #[Url]
    public int $perPage = 10;

    // Selected Brand to edit on modal
    public ?Menu $menu = null;

    public function render()
    {
        return view('livewire.settings.menus.index', ['headers' => $this->headers(), 'menus' => $this->menus()]);
    }

    #[On('menu-cancel')]
    public function clear(): void
    {
        $this->reset();
    }

    public function headers(): array
    {
        return [
            ['key' => 'id', 'label' => '#', 'class' => 'hidden lg:table-cell'],
            ['key' => 'name', 'label' => 'Name'],
            ['key' => 'handle', 'label' => 'Handle'],
        ];
    }

    public function menus(): LengthAwarePaginator
    {
        return Menu::query()
                   ->when($this->search, fn(Builder $q) => $q->whereAny(['name', 'handle'], 'like', '%'.$this->search.'%'))
                   ->orderBy(...array_values($this->sortBy))
                   ->paginate($this->perPage);
    }

    public function show(Menu $menu): void
    {
        $this->menu = $menu;
    }
}
