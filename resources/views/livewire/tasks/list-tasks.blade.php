@php @endphp
<div>
    <x-header title="Tasks" progress-indicator>

    </x-header>

    <x-card>
        <x-tabs wire:model="selectedTab" label-div-class="border-b-2 border-b-base-200 flex overflow-x-auto justify-end">
            <x-tab name="todo-tab" label="Todo" icon="o-users">
                <div @class(["flex items-center justify-end gap-3 grow order-last sm:order-none"])>
                    <x-input class="mb-10" placeholder="Tasks..." wire:model.live.debounce="name" icon="o-magnifying-glass" clearable/>
                </div>

                @foreach($tasks as $task)
                    <x-card title="{{ strtoupper($task->title) }}" subtitle="{{ $task->code }}" shadow separator>
                        {{ $task->description }}
                    </x-card>
                @endforeach
                <x-pagination :rows="$tasks"/>
            </x-tab>
            <x-tab name="in-progress-tab" label="In Progress" icon="o-sparkles">
                <div>Tricks</div>
            </x-tab>
            <x-tab name="done-tab" label="Done" icon="o-musical-note">
                <div>Musics</div>
            </x-tab>
        </x-tabs>


        {{--        <x-tabs>--}}
        {{--          --}}
        {{--        </x-tabs>--}}
        {{--        --}}{{--        <x-table :headers="$headers" :rows="$tasks" with-pagination per-page="perPage" :sort-by="$sortBy"/>--}}
    </x-card>
</div>
