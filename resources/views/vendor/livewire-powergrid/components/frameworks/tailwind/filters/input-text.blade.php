@props([
    'theme' => '',
    'enabledFilters' => [],
    'column' => null,
    'inline' => null,
    'filter' => null,
])
<div>
    @php
        $fieldClassName = data_get($filter, 'className');

        $field = strval(data_get($filter, 'field'));
        $title = strval(data_get($column, 'title'));
        $operators = (array) data_get($filter, 'operators', []);
        $placeholder = strval(data_get($filter, 'placeholder'));
        $componentAttributes = (array) data_get($filter, 'attributes', []);

        $inputTextOptions = $fieldClassName::getInputTextOperators();
        $inputTextOptions = count($operators) > 0 ? $operators : $inputTextOptions;
        $showSelectOptions = !(count($inputTextOptions) === 1 && in_array('contains', $inputTextOptions));

        $defaultPlaceholder = data_get($column, 'placeholder') ?: data_get($column, 'title');
        $overridePlaceholder = $placeholder ?: $defaultPlaceholder;

        unset($filter['placeholder']);

        $defaultAttributes = $fieldClassName::getWireAttributes($field, $title);

        $selectClasses = \Illuminate\Support\Arr::toCssClasses([
            'power_grid',
            data_get($theme, 'selectClass'),
        ]);
        $inputClasses = \Illuminate\Support\Arr::toCssClasses(['power_grid', data_get($theme, 'inputClass')]);

        $params = array_merge(
            [
                'showSelectOptions' => $showSelectOptions,
                'placeholder' => ($placeholder = $componentAttributes['placeholder'] ?? $overridePlaceholder),
                ...data_get($filter, 'attributes'),
                ...$defaultAttributes,
            ],
            $filter,
        );
    @endphp

    @if ($params['component'])
        @unset($params['operators'], $params['attributes'])

        <x-dynamic-component
                :component="$params['component']"
                :attributes="new \Illuminate\View\ComponentAttributeBag($params)"
        />
    @else
        <div
                @class([data_get($theme, 'baseClass'), 'space-y-1' => !$inline])
                style="{{ data_get($theme, 'baseStyle') }}"
        >
            <div @class([
                'w-full space-y-2 sm:flex sm:space-y-0' => !$inline && $showSelectOptions,
                'flex flex-col space-y-1.5' => $inline && $showSelectOptions,
            ])>

                <div @class([
                    'pl-0 w-full sm:w-1/2' => !$inline && $showSelectOptions,
                    'pt-0' => !$showSelectOptions,
                ])>
                    @php
                        $disabled = isset($enabledFilters[$field]['disabled']) && (bool) $enabledFilters[$field]['disabled'] === true;
                        $attributes = $disabled ? $defaultAttributes['inputAttributes']->merge(['disabled' => true])->except(['wire:model', 'wire:input.live.debounce.600ms']) : $defaultAttributes['inputAttributes'];
                    @endphp
                    <x-input
                            label="{{ $title }}"
                            data-cy="input_text_{{ $tableName }}_{{ $field }}"
                            wire:key="input-{{ $field }}"
                            data-id="{{ $field }}"
                            class="{{ $inputClasses }}"
                            placeholder="{{ $inline ? '' : $placeholder }}"
                            :attributes="$attributes"
                            :inline="$inline"
                    />
                </div>
                @if ($showSelectOptions)
                    <div @class([
                        'pl-1 w-full sm:pr-3 sm:w-1/2' => !$inline,
                    ])>
                        <div class="relative">
                            <select
                                    class="{{ $selectClasses }}"
                                    style="{{ data_get($column, 'headerStyle') }}"
                                    data-cy="input_text_options_{{ $tableName }}_{{ $field }}"
                                    {{ $defaultAttributes['selectAttributes'] }}
                            >
                                @foreach ($inputTextOptions as $key => $value)
                                    <option
                                            wire:key="input-text-options-{{ $tableName }}-{{ $key . '-' . $value }}"
                                            value="{{ $value }}"
                                    >{{ trans('livewire-powergrid::datatable.input_text_options.' . $value) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
