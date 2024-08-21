<div>
    {{-- HEADER --}}
    <x-header title="Menus" separator progress-indicator>
        {{-- SEARCH --}}
        <x-slot:middle class="!justify-end">
            <x-input placeholder="Menu..." wire:model.live.debounce="search" icon="o-magnifying-glass" clearable />
        </x-slot>

        <x-slot:actions>
            <x-button label="Create" link="/management/menus/create" icon="o-plus" class="btn-primary" responsive />
        </x-slot>
    </x-header>

    {{-- TABLE --}}
    <x-card class="!shadow-xl">
        <x-table
            :headers="$headers"
            :rows="$menus"
            :sort-by="$sortBy"
            link="/management/menus/{id}"
            with-pagination
            per-page="perPage"
            show-empty-text
        >
            @scope('actions', $menu)
                <div class="flex items-center space-x-2">
                    <x-button.view link="{{ route('management.menus.show', $menu->id) }}" />
                    <x-button.delete wire:click="delete({{ $menu->id }})" />
                </div>
            @endscope
        </x-table>
    </x-card>
</div>
