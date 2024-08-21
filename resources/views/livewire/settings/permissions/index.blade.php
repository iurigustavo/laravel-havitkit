<div>
    <x-header title="Permissions" progress-indicator separator>
        {{-- SEARCH --}}
        <x-slot:middle class="!justify-end">
            <x-input placeholder="Permission..." wire:model.live.debounce="name" icon="o-magnifying-glass" clearable />
        </x-slot>

        <x-slot:actions>
            <livewire:settings.permissions.create />
        </x-slot>
    </x-header>

    <x-card class="!shadow-xl">
        <x-table
            :headers="$headers"
            :rows="$permissions"
            with-pagination
            :sort-by="$sortBy"
            per-page="perPage"
            show-empty-text
        >
            @scope('actions', $permission)
                <div class="flex items-center space-x-2">
                    <x-button.view wire:click="edit({{ $permission->id }})" />
                    <x-button.delete wire:click="delete({{ $permission->id }})" />
                </div>
            @endscope
        </x-table>
    </x-card>

    {{-- EIDT MODAL --}}
    <livewire:settings.permissions.edit wire:model="permission" />
</div>
