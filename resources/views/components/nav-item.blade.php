@props(['item', 'statePath'])

<div
    x-data="{ open: $persist(true) }"
    wire:key="{{ $statePath }}"
    data-id="{{ $statePath }}"
    class="space-y-2"
    data-sortable-item
>
    <div class="group relative">
        <div
            @class([
                'flex w-full rounded-lg border border-gray-300 bg-white',
                'dark:border-gray-600 dark:bg-gray-700',
            ])
        >
            <button
                type="button"
                @class([
                    'flex items-center rounded-l-lg border-r border-gray-300 bg-gray-50 px-px',
                    'dark:border-gray-600 dark:bg-gray-800',
                ])
                data-sortable-handle
            >
                @svg('heroicon-o-ellipsis-vertical', '-mr-2 h-4 w-4 text-gray-400')
                @svg('heroicon-o-ellipsis-vertical', 'h-4 w-4 text-gray-400')
            </button>

            <button
                type="button"
                wire:click="editItem('{{ $statePath }}')"
                class="appearance-none px-3 py-2 text-left"
            >
                <span class="flex items-center">
                    @if (! empty($item['icon']))
                        <x-mary-icon
                            class="mr-3"
                            :name="\Illuminate\Support\Str::replaceFirst('-', '.', $item['icon'])"
                        />
                    @endif

                    {{ $item['label'] }}
                </span>
            </button>

            @if (count($item['children']) > 0)
                <button
                    type="button"
                    x-on:click="open = !open"
                    title="Toggle children"
                    class="appearance-none text-gray-500"
                >
                    <svg
                        class="h-3.5 w-3.5 transition duration-200 ease-in-out"
                        x-bind:class="{
                            '-rotate-90': ! open,
                        }"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd"
                        ></path>
                    </svg>
                </button>
            @endif
        </div>

        <div
            @class([
                'duration-250 absolute right-0 top-0 hidden h-6 divide-x overflow-hidden rounded-bl-lg rounded-tr-lg border-b border-l border-gray-300 opacity-0 transition ease-in-out group-hover:flex group-hover:opacity-100 rtl:left-0 rtl:right-auto rtl:rounded-bl-none rtl:rounded-br-lg rtl:rounded-tl-lg rtl:rounded-tr-none rtl:border-l-0 rtl:border-r',
                'dark:divide-gray-600 dark:border-gray-600',
            ])
        >
            <button
                x-init
                x-tooltip.raw.duration.0="{{ __('Add child') }}"
                type="button"
                wire:click="addChild('{{ $statePath }}')"
                class="p-1"
                title="{{ __('Add child') }}"
            >
                @svg('heroicon-o-plus', 'h-3 w-3 text-gray-500 hover:text-gray-900')
            </button>

            <button
                x-init
                x-tooltip.raw.duration.0="{{ __('Remove') }}"
                type="button"
                wire:click="removeItem('{{ $statePath }}')"
                class="p-1"
                title="{{ __('Remove') }}"
            >
                @svg('heroicon-o-trash', 'text-danger-500 hover:text-danger-900 h-3 w-3')
            </button>
        </div>
    </div>

    <div x-show="open" x-collapse class="ml-6">
        <div
            class="space-y-2"
            wire:key="{{ $statePath }}-children"
            x-data="navigationSortableContainer({
                        statePath: @js($statePath.'.children'),
                    })"
        >
            @foreach ($item['children'] as $uuid => $child)
                <x-nav-item :statePath="$statePath.'.children.'.$uuid" :item="$child" />
            @endforeach
        </div>
    </div>
</div>
