@php use Illuminate\Support\Str; @endphp
<div>
    <x-header title="Permissions" progress-indicator separator>
        {{--  SEARCH --}}
        <x-slot:middle class="!justify-end">
            <x-input placeholder="Permission..." wire:model.live.debounce="name" icon="o-magnifying-glass" clearable />
        </x-slot:middle>

        <x-slot:actions>
            <x-button label="Create" link="/management/permissions/create" icon="o-plus" class="btn-primary" responsive />
        </x-slot:actions>
    </x-header>

    <x-card class="!shadow-xl" >
        <x-table :headers="$headers" :rows="$permissions" link="/management/permissions/{id}" with-pagination :sort-by="$sortBy" per-page="perPage">
            @scope('actions', $permission)
            <div class="flex items-center space-x-2">
                <x-button.view link="{{ route('management.permissions.show', $permission->id) }}"/>
                <x-button.delete wire:click="delete({{ $permission->id }})"/>
            </div>
            @endscope
        </x-table>
    </x-card>
</div>
