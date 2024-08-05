<div>
    <x-header title="List Users" progress-indicator>
        <x-slot:actions>
            <div>
                <x-button class="btn-primary" label="Create" icon="o-plus" link="{{ route('management.users.create') }}" responsive/>
            </div>
        </x-slot:actions>
    </x-header>

    <livewire:settings.users.user-table/>
</div>
