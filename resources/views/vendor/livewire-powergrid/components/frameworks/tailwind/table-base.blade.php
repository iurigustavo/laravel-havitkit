<div
        class="flex flex-col"
        @if ($deferLoading) wire:init="fetchDatasource" @endif
>
    <div
            id="power-grid-table-container"
            class="{{ data_get($theme, 'table.containerClass', '-my-2 overflow-x-auto sm:-mx-3 lg:-mx-8') }}"
            style="{{ data_get($theme, 'table.containerStyle') }}"
    >
        <div
                id="power-grid-table-base"
                class="{{ data_get($theme, 'table.baseClass', 'p-3 align-middle inline-block min-w-full w-full sm:px-6 lg:px-8') }}"
                style="{{ data_get($theme, 'table.baseStyle') }}"
        >

            @include(data_get($theme, 'layout.header'), [
                'enabledFilters' => $enabledFilters,
            ])

            @if (config('livewire-powergrid.filter') === 'outside')
                @php
                    $filtersFromColumns = collect($columns)
                        ->filter(fn($column) => filled($column->filters));
                @endphp

                @if ($filtersFromColumns->count() > 0)
                    <x-livewire-powergrid::frameworks.tailwind.filter
                            :enabled-filters="$enabledFilters"
                            :tableName="$tableName"
                            :columns="$columns"
                            :filtersFromColumns="$filtersFromColumns"
                            :theme="$theme"
                    />
                @endif
            @endif
            @if (config('livewire-powergrid.filter') === 'drawer')
                @php
                    $filtersFromColumns = collect($columns)
                        ->filter(fn($column) => filled($column->filters));
                @endphp

                @if ($filtersFromColumns->count() > 0)
                    <x-livewire-powergrid::frameworks.tailwind.drawer
                            :enabled-filters="$enabledFilters"
                            :tableName="$tableName"
                            :columns="$columns"
                            :filtersFromColumns="$filtersFromColumns"
                            :theme="$theme"
                    />

                @endif
            @endif

            <div
                    @class([
                        'overflow-auto' => $readyToLoad,
                        'overflow-hidden' => !$readyToLoad,
                        data_get($theme, 'table.divClass'),
                    ])
                    style="{{ data_get($theme, 'table.divStyle') }}"
            >
                @include($table)
            </div>

            @include(data_get($theme, 'footer.view'))
        </div>
    </div>
</div>
