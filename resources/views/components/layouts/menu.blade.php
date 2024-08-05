<x-menu activate-by-route>
    @foreach(config('app.menu.main') as $menu)
        @if(isset($menu['type']) && $menu['type'] === 'separator')
            <x-menu-separator/>
            @continue
        @endif
        @if(isset($menu['sub']))
            <x-menu-sub :title="$menu['title']" :icon="$menu['icon'] ?? null"
                        :enabled="isset($menu['permission']) ? auth()->user()->can($menu['permission']) : true">
                @foreach($menu['sub'] as $sub)
                    <x-menu-item :title="$sub['title']" :link="$sub['link']" :icon="$sub['icon'] ?? null"
                                 :enabled="isset($sub['permission']) ? auth()->user()->can($sub['permission']) : true"/>
                @endforeach
            </x-menu-sub>
        @else
            <x-menu-item :title="$menu['title']" :icon="$menu['icon'] ?? null" :link="$menu['link']"
                         :enabled="isset($menu['permission']) ? auth()->user()->can($menu['permission']) : true"/>
        @endif
    @endforeach
    <x-menu-separator/>
    <x-menu-item title="Search" @click.stop="$dispatch('mary-search-open')" icon="o-magnifying-glass" class="max-h-screen-2xl mh-auto" badge="Cmd + G"/>
</x-menu>
