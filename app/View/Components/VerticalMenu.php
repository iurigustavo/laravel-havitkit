<?php

namespace App\View\Components;

use App\Models\Menu;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class VerticalMenu extends Component
{
    public object|array $items;

    public function __construct(
        public string $handle = 'navigation',

    ) {
        $this->items = Cache::remember('menu-'.$this->handle, '1 day', static fn () => Menu::where('handle', $handle)->first()->items);

    }

    public function render(): string
    {

        return <<<'HTML'
            <div>
                <x-menu activate-by-route>
                    @foreach($items as $menu)
                        @if(isset($menu['type']) && $menu['type'] === 'separator')
                            <x-menu-separator/>
                            @continue
                        @endif
                        @if(!empty($menu['children']))
                            <x-menu-sub :title="$menu['label']" :icon="!empty($menu['icon']) ? \Illuminate\Support\Str::replaceFirst('-','.', $menu['icon']) : null"
                                        :enabled="isset($menu['permissions']) ? auth()->user()->can($menu['permissions']) : true">
                                @foreach($menu['children'] as $sub)
                                    <x-menu-item :title="$sub['label']" :link="$sub['url']" :icon="!empty($sub['icon']) ? \Illuminate\Support\Str::replaceFirst('-','.', $sub['icon']) : null"
                                                 :enabled="isset($sub['permissions']) ? auth()->user()->can($sub['permissions']) : true"/>
                                @endforeach
                            </x-menu-sub>
                        @else
                            <x-menu-item :title="$menu['label']" :icon="!empty($menu['icon']) ? \Illuminate\Support\Str::replaceFirst('-','.', $menu['icon']) : null" :link="$menu['url']"
                                         :enabled="isset($menu['permissions']) ? auth()->user()->can($menu['permissions']) : true"/>
                        @endif
                    @endforeach
                    <x-menu-separator/>
                    <x-menu-item title="Search" @click.stop="$dispatch('mary-search-open')" icon="o-magnifying-glass" class="max-h-screen-2xl mh-auto" badge="Cmd + G"/>
                </x-menu>
            </div>
            HTML;
    }
}
