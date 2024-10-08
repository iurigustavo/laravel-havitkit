<div>
    @includeIf(data_get($setUp, 'footer.includeViewOnTop'))
    <div
            id="pg-footer"
            @class([
                'justify-between' => filled(data_get($setUp, 'footer.perPage')),
                'justify-end' => blank(data_get($setUp, 'footer.perPage')),
                'mary-table-pagination',
                'md:flex md:flex-row w-full items-center py-3 bg-inherit overflow-y-auto pl-2 pr-2 relative' => blank(
                    data_get($setUp, 'footer.pagination')),
            ])
    >
        @if (filled(data_get($setUp, 'footer.perPage')) &&
                count(data_get($setUp, 'footer.perPageValues')) > 1 &&
                blank(data_get($setUp, 'footer.pagination')))
            <div class="flex flex-row justify-center md:justify-start mb-2 md:mb-0">
                <div class="relative">
                    <select
                            wire:model.live="setUp.footer.perPage"
                            class="{{ data_get($theme, 'footer.selectClass') }}"
                            style="{{ data_get($theme, 'footer.selectStyle') }}"
                    >
                        @foreach (data_get($setUp, 'footer.perPageValues') as $value)
                            <option value="{{ $value }}">
                                @if ($value == 0)
                                    {{ trans('livewire-powergrid::datatable.labels.all') }}
                                @else
                                    {{ $value }}
                                @endif
                            </option>
                        @endforeach
                    </select>

                </div>
                <div
                        class="pl-4 hidden sm:block md:block lg:block w-full"
                        style="padding-top: 6px;"
                >
                </div>
            </div>
        @endif

        @if (filled($data))
            <div>
                @if (method_exists($data, 'links'))
                    {!! $data->links(data_get($setUp, 'footer.pagination') ?: powerGridThemeRoot() . '.pagination', [
                        'recordCount' => data_get($setUp, 'footer.recordCount'),
                        'perPage' => data_get($setUp, 'footer.perPage'),
                        'perPageValues' => data_get($setUp, 'footer.perPageValues'),
                    ]) !!}
                @endif
            </div>
        @endif
    </div>
    @includeIf(data_get($setUp, 'footer.includeViewOnBottom'))
</div>
