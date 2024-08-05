@props([
    'columns' => null,
    'theme' => null,
    'tableName' => null,
    'filtersFromColumns' => null,
    'showFilters' => false,
])
<x-drawer wire:model="showFilters" title="Filters" class="lg:w-1/3" right separator with-close-button>
    <div class="grid gap-5" @keydown.enter="$wire.showFilters = false">

        @foreach ($filtersFromColumns as $column)
            @php
                $filter = data_get($column, 'filters');
                $title = data_get($column, 'title');
                $baseClass = data_get($filter, 'baseClass');
                $className = str(data_get($filter, 'className'));
            @endphp

            <div class="{{ $baseClass }}">
                @if ($className->contains('FilterMultiSelect'))
                    <x-livewire-powergrid::inputs.select
                            :inline="false"
                            :table-name="$tableName"
                            :filter="$filter"
                            :theme="data_get($theme, 'filterMultiSelect')"
                            :title="$title"
                            :initial-values="data_get(data_get($filter, 'multi_select'), data_get($filter, 'field'), [])"
                    />
                @elseif ($className->contains(['FilterDateTimePicker', 'FilterDatePicker']))
                    @includeIf(data_get($theme, 'filterDatePicker.view'), [
                        'filter' => $filter,
                        'tableName' => $tableName,
                        'classAttr' => 'w-full',
                        'theme' => data_get($theme, 'filterDatePicker'),
                        'type' => $className->contains('FilterDateTimePicker') ? 'datetime' : 'date',
                    ])
                @elseif ($className->contains(['FilterSelect', 'FilterEnumSelect']))
                    @includeIf(data_get($theme, 'filterSelect.view'), [
                        'filter' => $filter,
                        'theme' => data_get($theme, 'filterSelect'),
                    ])
                @elseif ($className->contains('FilterNumber'))
                    @includeIf(data_get($theme, 'filterNumber.view'), [
                        'filter' => $filter,
                        'theme' => data_get($theme, 'filterNumber'),
                    ])
                @elseif ($className->contains('FilterInputText'))
                    @includeIf(data_get($theme, 'filterInputText.view'), [
                        'filter' => $filter,
                        'theme' => data_get($theme, 'filterInputText'),
                    ])
                @elseif ($className->contains('FilterBoolean'))
                    @includeIf(data_get($theme, 'filterBoolean.view'), [
                        'filter' => $filter,
                        'theme' => data_get($theme, 'filterBoolean'),
                    ])
                @elseif ($className->contains('FilterDynamic'))
                    <x-dynamic-component
                            :component="data_get($filter, 'component', '')"
                            :attributes="new \Illuminate\View\ComponentAttributeBag(data_get($filter, 'attributes', []))"
                    />
                @endif
            </div>
        @endforeach

    </div>

    {{-- ACTIONS --}}
    <x-slot:actions>
        <x-button label="Reset" icon="o-x-mark" wire:click.prevent="clearAllFilters" spinner/>
        <x-button label="Done" icon="o-check" class="btn-primary" @click="$wire.showFilters = false"/>
    </x-slot:actions>
</x-drawer>

