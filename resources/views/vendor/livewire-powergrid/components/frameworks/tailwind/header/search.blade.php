@if (data_get($setUp, 'header.searchInput'))
    <div class="flex flex-row mt-3 md:mt-0 w-full rounded-full flex justify-start sm:justify-center md:justify-end">
        <div class="group relative rounded-full w-full md:w-4/12 float-end float-right md:w-full lg:w-1/2">
            <span class="absolute inset-y-0 left-0 flex items-center pl-1">
                <span class="p-1 focus:outline-none focus:shadow-outline">
                    <x-livewire-powergrid::icons.search
                        class="{{ data_get($theme, 'searchBox.iconSearchClass') }}"
                        style="{{ data_get($theme, 'searchBox.iconSearchStyle') }}"
                    />
                </span>
            </span>
            <x-input placeholder="{{ trans('livewire-powergrid::datatable.placeholders.search') }}" wire:model.live.debounce.700ms="search" icon="o-magnifying-glass" clearable />
        </div>
    </div>
@endif
