@php
    use Illuminate\Support\Str;
@endphp

<div>
    <x-header title="Roles" progress-indicator separator>
        {{-- SEARCH --}}
        <x-slot:middle class="!justify-end">
            <x-input placeholder="Role..." wire:model.live.debounce="name" icon="o-magnifying-glass" clearable />
        </x-slot>

        <x-slot:actions>
            <x-button label="Create" link="/management/roles/create" icon="o-plus" class="btn-primary" responsive />
        </x-slot>
    </x-header>

    <div class="lg:gap-7.5 grid grid-cols-1 gap-5 lg:grid-cols-2 xl:grid-cols-3">
        @foreach ($roles as $role)
            <div class="lg:p-7.5 border-grey-500 card flex flex-col gap-5 rounded-lg border bg-base-100 p-5 !shadow-xl">
                <div class="flex flex-wrap items-center justify-between gap-1">
                    <div class="flex items-center gap-2.5">
                        <div class="relative size-[44px] shrink-0">
                            <x-mary-icon class="h-10" name="c-rectangle-group" />
                            <div class="absolute left-2/4 top-2/4 -translate-x-2/4 -translate-y-2/4 leading-none">
                                <i class="ki-filled ki-setting text-1.5xl text-primary"></i>
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <a
                                wire:navigate
                                class="text-md hover:text-primary-active mb-px font-medium text-gray-900 dark:text-inherit"
                                href="{{ route('management.roles.show', $role->id) }}"
                            >
                                {{ Str::title($role->name) }}
                            </a>
                            <x-badge class="bg-amber-500 text-base-100" value="{{ $role->guard_name }}" />
                        </div>
                    </div>
                    <div class="menu inline-flex" data-menu="true">
                        <div
                            class="menu-item menu-item-dropdown"
                            data-menu-item-offset="0, 10px"
                            data-menu-item-placement="bottom-end"
                            data-menu-item-toggle="dropdown"
                            data-menu-item-trigger="click|lg:click"
                        >
                            <x-dropdown class="btn-sm" no-x-anchor>
                                <x-menu-item title="View" link="{{ route('management.roles.show', $role->id) }}" />
                                <x-menu-item
                                    title="Delete"
                                    wire:click="delete({{ $role->id }})"
                                    wire:confirm="Are you sure?"
                                    spinner
                                />
                            </x-dropdown>
                        </div>
                    </div>
                </div>
                <p class="h-16 text-gray-700 dark:text-inherit">{{ $role->description }}</p>
                <div class="flex justify-between text-sm">
                    <span class="text-2sm text-gray-800 dark:text-inherit">
                        {{ $role->users_count }}
                        {{ Str::pluralStudly('Person', $role->users_count) }}
                    </span>
                    <span class="text-2sm text-gray-800 dark:text-inherit">
                        {{ $role->permissions_count }}
                        {{ Str::pluralStudly('Permission', $role->permissions_count) }}
                    </span>
                </div>
            </div>
        @endforeach
    </div>
    <x-mary-pagination :rows="$roles" />
</div>
