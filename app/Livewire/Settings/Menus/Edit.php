<?php

namespace App\Livewire\Settings\Menus;

use App\Actions\Menu\UpdateMenuAction;
use App\Livewire\Forms\Settings\MenuForm;
use App\Livewire\Forms\Settings\MenuItemForm;
use App\Models\Menu;
use App\Models\Permission;
use App\Traits\HandlesNavigationBuilder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Livewire\Component;
use Mary\Traits\Toast;

class Edit extends Component
{
    use HandlesNavigationBuilder;
    use Toast;

    public MenuForm $form;

    public MenuItemForm $itemForm;

    public Menu $menu;

    public Collection $permissionsList;

    public function mount(): void
    {
        $this->form->fill($this->menu);
        $this->permissionsList = Permission::all();
    }

    public function save(UpdateMenuAction $action)
    {
        $this->authorize('update', $this->menu);

        $this->form->validate();
        $action->run($this->menu, $this->form);

        $this->success(__('form.created'), redirectTo: route('management.menus.index'));
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
