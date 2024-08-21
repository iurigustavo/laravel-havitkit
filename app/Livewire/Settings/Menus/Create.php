<?php

namespace App\Livewire\Settings\Menus;

use App\Actions\Menu\CreateNewMenuAction;
use App\Livewire\Forms\Settings\MenuForm;
use App\Livewire\Forms\Settings\MenuItemForm;
use App\Models\Menu;
use App\Models\Permission;
use App\Traits\HandlesNavigationBuilder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Livewire\Component;
use Mary\Traits\Toast;

class Create extends Component
{
    use HandlesNavigationBuilder;
    use Toast;

    public MenuForm $form;

    public MenuItemForm $itemForm;

    public Menu $menu;

    public Collection $permissionsList;

    public function save(CreateNewMenuAction $action)
    {
        $this->form->validate();
        $action->run($this->form);

        $this->success(__('form.created'), redirectTo: route('management.menus.index'));
    }

    public function mount()
    {
        $this->permissionsList = Permission::all();
    }

    public function generateSlug(): void
    {
        $this->form->handle = Str::slug($this->form->name);
    }

    public function render()
    {
        return view('livewire.settings.menus.create');
    }
}
