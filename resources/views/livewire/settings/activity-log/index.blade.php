<div>
    {{--  HEADER  --}}
    <x-header title="Activities Logs" separator progress-indicator>
        {{-- ACTIONS  --}}
        <x-slot:actions>
            <x-button label="Filters"
                      icon="o-funnel"
                      :badge="$filterCount"
                      badge-classes="font-mono"
                      @click="$wire.showFilters = true"
                      class="bg-base-300"
                      responsive/>
        </x-slot:actions>
    </x-header>

    {{--  TABLE --}}
    <x-card>
        <x-table :headers="$headers" :rows="$activities" :sort-by="$sortBy" @row-click="$wire.show($event.detail.id)" with-pagination per-page="perPage">
            @scope('cell_causer', $activity)
            @if($activity->causer)
                <x-avatar :image="$activity->causer->avatar_url" :title="$activity->causer->name" class="!w-5"/>
            @endif
            @endscope
        </x-table>

    </x-card>

    {{-- FILTERS --}}
    <x-drawer wire:model="showFilters" title="Filters" class="lg:w-1/3" right separator with-close-button>
        <div class="grid gap-5" @keydown.enter="$wire.showFilters = false">
            <x-choices-offline
                    label="User"
                    option-avatar="avatar_url"
                    wire:model.live="causer_id"
                    :options="$users"
                    multiple
                    searchable>
            </x-choices-offline>

            <x-input label="Subject Id" wire:model.live.debounce="subject_id" inline/>
            <x-select label="Subject" :options="$subjects" wire:model.live="subject_type" placeholder="All" placeholder-value="0" inline/>
            <x-select label="Events" :options="$events" wire:model.live="event" placeholder="All" placeholder-value="0" inline/>
        </div>

        {{-- ACTIONS --}}
        <x-slot:actions>
            <x-button label="Reset" icon="o-x-mark" wire:click="clear" spinner/>
            <x-button label="Done" icon="o-check" class="btn-primary" @click="$wire.showFilters = false"/>
        </x-slot:actions>
    </x-drawer>

    {{--  DIFF MODAL --}}
    <livewire:settings.activity-log.show wire:model="activity"/>
</div>
