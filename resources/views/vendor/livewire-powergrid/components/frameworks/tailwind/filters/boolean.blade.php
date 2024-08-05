@props([
    'theme' => '',
    'column' => null,
    'class' => '',
    'inline' => null,
    'filter' => null,
])
@php
    $fieldClassName = data_get($filter, 'className');
    $field = data_get($filter, 'field');
    $title = data_get($column, 'title');

    $trueLabel = data_get($filter, 'trueLabel');
    $falseLabel = data_get($filter, 'falseLabel');

    $defaultAttributes = $fieldClassName::getWireAttributes($field, $title);

    $selectClasses = Arr::toCssClasses([
        data_get($theme, 'selectClass'),
        $class,
        'power_grid',
    ]);

    $params = array_merge([...data_get($filter, 'attributes'), ...$defaultAttributes], $filter);
@endphp

@if ($params['component'])
    @unset($params['attributes'])

    <x-dynamic-component
            :component="$params['component']"
            :attributes="new \Illuminate\View\ComponentAttributeBag($params)"
    />
@else
    <div
            @class([data_get($theme, 'baseClass'), 'space-y-1' => !$inline])
            style="{{ data_get($theme, 'baseStyle') }}"
    >
        @php
            $options = [
                ['id' => 'all', 'name' => trans('livewire-powergrid::datatable.boolean_filter.all')],
                ['id' => 'true', 'name' => $trueLabel],
                ['id' => 'false', 'name' => $falseLabel]
        ];
        @endphp
        <x-select
                label="{{ $title }}"
                class="{{ $selectClasses }}"
                style="{{ data_get($column, 'headerStyle') }}"
                :attributes=" $defaultAttributes['selectAttributes']"
                :inline="$inline"
                :options="$options"
        />
    </div>
@endif
