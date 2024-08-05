@if (data_get($setUp, 'header.toggleColumns'))
    <div
        x-data="{ open: false }"
        class="mr-2 mt-2 sm:mt-0"
        @click.outside="open = false"
    >
        <button
            @click.prevent="open = ! open"
            class="btn btn-sm btn-primary btn-circle btn-outline"
        >
            <div class="flex">
                <x-livewire-powergrid::icons.eye-off class="inline w-5 h-5" />
            </div>
        </button>

        <div
            x-cloak
            x-show="open"
            x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
            class="absolute z-10 mt-2 w-56 rounded-md dark:bg-pg-primary-700 bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
            tabindex="-1"
            @keydown.tab="open = false"
            @keydown.enter.prevent="open = false;"
            @keyup.space.prevent="open = false;"
        >
            <div
                role="none"
            >
                @foreach ($this->visibleColumns as $column)
                    <div
                        wire:click="$dispatch('pg:toggleColumn-{{ $tableName }}', { field: '{{ data_get($column, 'field') }}'})"
                        wire:key="toggle-column-{{ data_get($column, 'field') }}"
                        @class([
                            'font-semibold bg-pg-primary-100 dark:bg-pg-primary-800 ' => data_get($column, 'hidden'),
                            'py-1' => $loop->first || $loop->last,
                            'cursor-pointer text-sm flex justify-between block px-4 py-2 text-pg-primary-800 hover:bg-primary hover:text-white rounded'
                        ])
                    >
                        <div>
                            {!! data_get($column, 'title') !!}
                        </div>
                        @if (!data_get($column, 'hidden'))
                            <x-livewire-powergrid::icons.eye class="text-pg-primary-200 dark:text-pg-primary-300" />
                        @else
                            <x-livewire-powergrid::icons.eye-off class="text-pg-primary-500 dark:text-pg-primary-300" />
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif
