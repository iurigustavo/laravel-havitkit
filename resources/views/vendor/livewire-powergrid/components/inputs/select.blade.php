@props([
    'theme' => '',
    'inline' => true,
    'filter' => null,
    'tableName' => null,
    'multiple' => true,
    'initialValues' => [],
    'title' => ''
])
@php
    $framework = config('livewire-powergrid.plugins.select');
    $collection = collect();

    if (filled(data_get($filter, 'dataSource'))) {
        $collection = collect(data_get($filter, 'dataSource'))
            ->transform(function (array|\Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Model $entry) use ($filter) {
                if (is_array($entry)) {
                    $entry = collect($entry);
                }
            return $entry->only([data_get($filter, 'optionValue'), data_get($filter, 'optionLabel')]);
        });
    } elseif (filled(data_get($filter, 'computedDatasource'))) {
        $collection = collect(data_get($filter, 'computedDatasource'))
            ->transform(function (array|\Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Model $entry) use ($filter) {
                if (is_array($entry)) {
                    $entry = collect($entry);
                }
            return $entry->only([data_get($filter, 'optionValue'), data_get($filter, 'optionLabel')]);
        });
    }

    $params = [
        'tableName' => $tableName,
        'label' => $title,
        'dataField' => data_get($filter, 'field'),
        'optionValue' => data_get($filter, 'optionValue'),
        'optionLabel' => data_get($filter, 'optionLabel'),
        'initialValues' => $initialValues,
        'framework' => $framework[config('livewire-powergrid.plugins.select.default')],
    ];

    if (\Illuminate\Support\Arr::has($filter, ['url', 'method'])) {
        $params['asyncData'] = [
            'url' => data_get($filter, 'url'),
            'method' => data_get($filter, 'method'),
            'parameters' => data_get($filter, 'parameters'),
            'headers' => data_get($filter, 'headers'),
        ];
    }
    $alpineData = $framework['default'] == 'tom' ? 'pgTomSelect(' . \Illuminate\Support\Js::from($params) . ')' : 'pgSlimSelect(' . \Illuminate\Support\Js::from($params) . ')';
@endphp
<div
    x-cloak
    wire:ignore
    x-data="{{ $alpineData }}"
>
    @if (filled($filter))
        <div
            class="{{ data_get($theme, 'baseClass') }}"
            style="{{ data_get($theme, 'baseStyle') }}"
        >
            @if (!$inline)
                <label class="pt-0 label label-text font-semibold">
                    {{ $title }}
                </label>
            @endif

            <select
                @if ($multiple) multiple @endif
                class="select select-bordered select-primary w-full h-fit pe-16 pb-1 pt-1.5 inline-block cursor-pointer relative"
                wire:model="filters.multi_select.{{ data_get($filter, 'field') }}.values"
                x-ref="select_picker_{{ data_get($filter, 'field') }}_{{ $tableName }}"
            >
                <option value="">{{ trans('livewire-powergrid::datatable.multi_select.all') }}</option>
                @if (blank(data_get($params, 'asyncData', [])))
                    @foreach ($collection->toArray() as $item)
                        <option wire:key="multi-select-option-{{ $loop->index }}"
                                value="{{ data_get($item, data_get($filter, 'optionValue')) }}">
                            {{ data_get($item, data_get($filter, 'optionLabel')) }}
                        </option>
                    @endforeach
                @endif
            </select>
        </div>
    @endif
</div>
