<?php

namespace App\View\Components\Form;

use BladeUI\Icons\Factory as IconFactory;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Mary\View\Components\ChoicesOffline;
use Symfony\Component\Finder\SplFileInfo;

class IconPicker extends ChoicesOffline
{
    protected function tryCache(string $key, Closure $callback)
    {
        return Cache::remember($key, '7 days', $callback);
    }

    private function loadIcons(): Collection
    {
        $iconsHash = md5(serialize('icons-sets'));
        $key = "icon-picker.fields.{$iconsHash}";

        $sets = $this->tryCache(
            $key,
            function () {
                $iconsFactory = App::make(IconFactory::class);

                return collect($iconsFactory->all());
            });

        $allowedSetsHash = md5(serialize($sets));
        $iconsKey = "icon-picker.fields.icons.{$iconsHash}.{$allowedSetsHash}";

        $icons = $this->tryCache($iconsKey, function () use ($sets) {
            $icons = [];

            foreach ($sets as $set) {
                $prefix = $set['prefix'];
                foreach ($set['paths'] as $path) {
                    // To include icons from sub-folders, we use File::allFiles instead of File::files
                    // See https://github.com/blade-ui-kit/blade-icons/blob/ce60487deeb7bcbccd5e69188dc91b4c29622aff/src/IconsManifest.php#L40
                    foreach (File::allFiles($path) as $file) {
                        // Simply ignore files that aren't SVGs
                        if ($file->getExtension() !== 'svg') {
                            continue;
                        }

                        $iconName = $this->getIconName($file, parentPath: $path, prefix: $prefix);

                        $icons[] = ['id' => $iconName, 'name' => $iconName];
                    }
                }
            }

            return $icons;
        });

        return collect($icons);
    }

    private function getIconName(SplFileInfo $file, string $parentPath, string $prefix): string
    {
        // BladeIcons uses a simple (and view-compliant) naming convention for icon names
        // `xtra-icon` is the `icon.svg` from the `xtra` icon set
        // `xtra-dir.icon` is the `icon.svg` from the `dir/` folder from the `xtra` icon set
        // `xtra-sub.dir.icon` is the `icon.svg` from the `sub/dir/` folder from the `xtra` icon set
        //
        // As such, we:
        // - get the string after the parent directory's path
        // - replace every directory separator by a dot
        // - add the prefix at the beginning, followed by a dash

        $iconName = str($file->getPathname())
            ->after($parentPath.DIRECTORY_SEPARATOR)
            ->replace(DIRECTORY_SEPARATOR, '.')
            ->basename('.svg')
            ->toString();

        return "$prefix-$iconName";
    }

    public function render(): View|Closure|string
    {
        $this->options = $this->loadIcons();

        return <<<'HTML'
                <div x-data="{ focused: false, selection: @entangle($attributes->wire('model')) }">
                    <div
                        @click.outside = "clear()"
                        @keyup.esc = "clear()"

                        x-data="{
                            id: $id('{{ $uuid }}'),
                            options: {{ json_encode($options) }},
                            isSingle: {{ json_encode($single) }},
                            isSearchable: {{ json_encode($searchable) }},
                            isReadonly: {{ json_encode($isReadonly()) }},
                            isDisabled: {{ json_encode($isDisabled()) }},
                            isRequired: {{ json_encode($isRequired()) }},
                            minChars: {{ $minChars }},
                            noResults: false,
                            search: '',

                            init() {
                                // Fix weird issue when navigating back
                                document.addEventListener('livewire:navigating', () => {
                                    let elements = document.querySelectorAll('.mary-choices-element');
                                    elements.forEach(el =>  el.remove());
                                });
                            },
                            get selectedOptions() {
                                return this.isSingle
                                    ? this.options.filter(i => i.{{ $optionValue }} == this.selection)
                                    : this.selection.map(i => this.options.filter(o => o.{{ $optionValue }} == i)[0])
                            },
                            get isAllSelected() {
                                return this.options.length == this.selection.length
                            },
                            get isSelectionEmpty() {
                                return this.isSingle
                                    ? this.selection == null || this.selection == ''
                                    : this.selection.length == 0
                            },
                            selectAll() {
                                this.selection = this.options.map(i => i.{{ $optionValue }})
                            },
                            clear() {
                                this.focused = false;
                                this.search = ''
                            },
                            reset() {
                                this.clear();
                                this.isSingle
                                    ? this.selection = null
                                    : this.selection = []

                                this.dispatchChangeEvent({ value: this.selection })
                            },
                            focus() {
                                if (this.isReadonly || this.isDisabled) {
                                    return
                                }

                                this.focused = true
                                this.$refs.searchInput.focus()
                            },
                            isActive(id) {
                                return this.isSingle
                                    ? this.selection == id
                                    : this.selection.includes(id)
                            },
                            toggle(id) {
                                if (this.isReadonly || this.isDisabled) {
                                    return
                                }

                                if (this.isSingle) {
                                    this.selection = id
                                    this.focused = false
                                    this.search = ''
                                } else {
                                    this.selection.includes(id)
                                        ? this.selection = this.selection.filter(i => i != id)
                                        : this.selection.push(id)
                                }

                                this.dispatchChangeEvent({ value: this.selection })
                                this.$refs.searchInput.focus()
                            },
                            lookup() {
                                Array.from(this.$refs.choicesOptions.children).forEach(child => {
                                    if (!child.getAttribute('search-value').match(new RegExp(this.search, 'i'))){
                                        child.classList.add('hidden')
                                    } else {
                                        child.classList.remove('hidden')
                                    }
                                })

                                this.noResults = Array.from(this.$refs.choicesOptions.querySelectorAll('div > .hidden')).length ==
                                                 Array.from(this.$refs.choicesOptions.querySelectorAll('[search-value]')).length
                            },
                            dispatchChangeEvent(detail) {
                                this.$refs.searchInput.dispatchEvent(new CustomEvent('change-selection', { bubbles: true, detail }))
                            }
                        }"
                    >
                        <!-- STANDARD LABEL -->
                        @if($label)
                            <label :for="id" class="pt-0 label label-text font-semibold">
                                <span>
                                    {{ $label }}

                                    @if($attributes->get('required'))
                                        <span class="text-error">*</span>
                                    @endif
                                </span>
                            </label>
                        @endif

                        <!-- PREPEND/APPEND CONTAINER -->
                        @if($prepend || $append)
                            <div class="flex">
                        @endif

                        <!-- PREPEND -->
                        @if($prepend)
                            <div class="rounded-s-lg flex items-center bg-base-200">
                                {{ $prepend }}
                            </div>
                        @endif

                        <!-- SELECTED OPTIONS + SEARCH INPUT -->
                        <div
                            @click="focus();"
                            x-ref="container"

                            {{
                                $attributes->except(['wire:model', 'wire:model.live'])->class([
                                    "select select-bordered select-primary w-full h-fit pe-16 pb-1 pt-1.5 inline-block cursor-pointer relative",
                                    'border border-dashed' => $isReadonly(),
                                    'select-error' => $errors->has($errorFieldName()),
                                    'rounded-s-none' => $prepend,
                                    'rounded-e-none' => $append,
                                    'ps-10' => $icon,
                                ])
                            }}
                        >
                            <!-- ICON  -->
                            @if($icon)
                                <x-mary-icon :name="$icon" class="absolute top-1/2 -translate-y-1/2 start-3 text-gray-400 pointer-events-none" />
                            @endif

                            <!-- CLEAR ICON  -->
                            @if(! $isReadonly() && ! $isDisabled())
                                <x-mary-icon @click="reset()"  name="o-x-mark" x-show="!isSelectionEmpty" class="absolute top-1/2 end-8 -translate-y-1/2 cursor-pointer text-gray-400 hover:text-gray-600" />
                            @endif

                            <!-- SELECTED OPTIONS -->
                            <span wire:key="selected-options-{{ $uuid }}">
                                @if($compact)
                                    <div class="bg-primary/5 text-primary hover:bg-primary/10 dark:bg-primary/20 dark:hover:bg-primary/40 dark:text-inherit px-2 me-2 mt-0.5 mb-1.5 last:me-0 rounded inline-block cursor-pointer">
                                        <span class="font-black" x-text="selectedOptions.length"></span> {{ $compactText }}
                                    </div>
                                @else
                                    <template x-for="(option, index) in selectedOptions" :key="index">
                                        <div class="mary-choices-element bg-primary/5 text-primary hover:bg-primary/10 dark:bg-primary/20 dark:hover:bg-primary/40 dark:text-inherit px-2 me-2 mt-0.5 mb-1.5 last:me-0 inline-block rounded cursor-pointer">
                                            <!-- SELECTION SLOT -->
                                             @if($selection)
                                                <span x-html="document.getElementById('selection-{{ $uuid . '-\' + option.'. $optionValue }}).innerHTML"></span>
                                             @else
                                                <span x-text="option.{{ $optionLabel }}"></span>
                                             @endif

                                            <x-mary-icon @click="toggle(option.{{ $optionValue }})" x-show="!isReadonly && !isDisabled && !isSingle" name="o-x-mark" class="text-gray-500 hover:text-red-500" />
                                        </div>
                                    </template>
                                @endif
                            </span>

                            &nbsp;

                            <!-- INPUT SEARCH -->
                            <input
                                :id="id"
                                x-ref="searchInput"
                                x-model="search"
                                @keyup="lookup()"
                                @input="focus()"
                                :required="isRequired && isSelectionEmpty"
                                :readonly="isReadonly || isDisabled || ! isSearchable"
                                :class="(isReadonly || isDisabled || !isSearchable || !focused) && '!w-1'"
                                class="outline-none mt-0.5 bg-transparent w-20"
                             />
                        </div>


                        <!-- APPEND -->
                        @if($append)
                            <div class="rounded-e-lg flex items-center bg-base-200">
                                {{ $append }}
                            </div>
                        @endif

                        <!-- END: APPEND/PREPEND CONTAINER  -->
                        @if($prepend || $append)
                            </div>
                        @endif

                        <!-- OPTIONS LIST -->
                        <div x-show="focused" x-cloak class="relative" wire:key="options-list-main-{{ $uuid }}" >
                            <div wire:key="options-list-{{ $uuid }}" class="{{ $height }} w-full absolute z-10 shadow-xl bg-base-100 border border-base-300 rounded-lg cursor-pointer overflow-y-auto" x-anchor.bottom-start="$refs.container">

                               <!-- SELECT ALL -->
                               @if($allowAll)
                                   <div
                                        wire:key="allow-all-{{ rand() }}"
                                        class="font-bold   border border-s-4 border-b-base-200 hover:bg-base-200"
                                   >
                                        <div x-show="!isAllSelected" @click="selectAll()" class="p-3 underline decoration-wavy decoration-info">{{ $allowAllText }}</div>
                                        <div x-show="isAllSelected" @click="reset()" class="p-3 underline decoration-wavy decoration-error">{{ $removeAllText }}</div>
                                   </div>
                               @endif

                                <!-- NO RESULTS -->
                                <div
                                    x-show="noResults"
                                    wire:key="no-results-{{ rand() }}"
                                    class="p-3 decoration-wavy decoration-warning underline font-bold border border-s-4 border-s-warning border-b-base-200"
                                >
                                    {{ $noResultText }}
                                </div>

                                <div x-ref="choicesOptions">
                                    @foreach($options as $option)
                                        <div
                                            id="option-{{ $uuid }}-{{ data_get($option, $optionValue) }}"
                                            wire:key="option-{{ data_get($option, $optionValue) }}"
                                            @click="toggle({{ $getOptionValue($option) }})"
                                            :class="isActive({{ $getOptionValue($option) }}) && 'border-s-4 border-s-primary'"
                                            search-value="{{ data_get($option, $optionLabel) }}"
                                            class="border-s-4"
                                        >
                                            <!-- ITEM SLOT -->
                                            @if($item)
                                                {{ $item($option) }}
                                            @else
                                                <x-mary-list-item :item="$option" :value="$optionLabel" :sub-value="$optionSubLabel" :avatar="$optionAvatar">
                                                    <x-slot:avatar>
                                                       <x-mary-icon :name="\Illuminate\Support\Str::replaceFirst('-','.', data_get($option, $optionValue))" />
                                                    </x-slot:avatar>                                                    
                                                </x-mary-list-item>
                                            @endif

                                            <!-- SELECTION SLOT -->
                                            @if($selection)
                                                <span id="selection-{{ $uuid }}-{{ data_get($option, $optionValue) }}" class="hidden">
                                                    {{ $selection($option) }}
                                                </span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- ERROR -->
                        @if(!$omitError && $errors->has($errorFieldName()))
                            @foreach($errors->get($errorFieldName()) as $message)
                                @foreach(Arr::wrap($message) as $line)
                                    <div class="{{ $errorClass }}" x-classes="text-red-500 label-text-alt p-1">{{ $line }}</div>
                                    @break($firstErrorOnly)
                                @endforeach
                                @break($firstErrorOnly)
                            @endforeach
                        @endif

                        <!-- HINT -->
                        @if($hint)
                            <div class="{{ $hintClass }}" x-classes="label-text-alt text-gray-400 py-1 pb-0">{{ $hint }}</div>
                        @endif
                    </div>
                </div>
            HTML;
    }
}
