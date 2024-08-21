<div>
    <x-header title="Users" progress-indicator separator>
        <x-slot:actions>
            <div>
                <x-button
                    class="btn-primary"
                    label="Create"
                    icon="o-plus"
                    link="{{ route('management.users.create') }}"
                    responsive
                />
            </div>
        </x-slot>
    </x-header>

    <livewire:settings.users.user-table />
</div>
