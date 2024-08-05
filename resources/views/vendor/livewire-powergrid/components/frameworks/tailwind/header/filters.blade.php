<div
        wire:key="toggle-filters-{{ $tableName }}')"
        id="toggle-filters"
        class="flex mr-2 mt-2 sm:mt-0 gap-3"
>
    <x-button icon="o-funnel"
              wire:click="toggleFilters"
              :badge="count($enabledFilters)"
              badge-classes="font-mono"
              class="btn btn-sm btn-primary btn-circle btn-outline"
              responsive/>
</div>
