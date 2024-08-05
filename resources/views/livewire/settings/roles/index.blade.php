@php use Illuminate\Support\Str; @endphp
<div>
    <x-header title="Roles" progress-indicator separator>
        {{--  SEARCH --}}
        <x-slot:middle class="!justify-end">
            <x-input placeholder="Role..." wire:model.live.debounce="name" icon="o-magnifying-glass" clearable/>
        </x-slot:middle>

        <x-slot:actions>
            <x-button label="Create" link="/management/roles/create" icon="o-plus" class="btn-primary" responsive/>
        </x-slot:actions>
    </x-header>

    <x-card class="!shadow-xl">
        <x-table :headers="$headers" :rows="$roles" link="/management/roles/{id}" with-pagination :sort-by="$sortBy">
            @scope('cell_guard_name', $role)
                <x-badge class="bg-amber-500 text-base-100" value="{{ $role->guard_name }}"/>
            @endscope
            @scope('cell_permissions_count', $role)
                <x-badge class="badge-success text-base-100" value="{{ $role->permissions_count }}"/>
            @endscope
            @scope('actions', $role)
            <div class="flex items-center space-x-2">
                <x-button.view link="{{ route('management.roles.show', $role->id) }}"/>
                <x-button.delete wire:click="delete({{ $role->id }})"/>
            </div>
            @endscope
        </x-table>
    </x-card>
</div>
