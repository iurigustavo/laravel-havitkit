<div>
    <x-header :title="isset($permission) ? 'Edit Permission' : 'New Permission'" progress-indicator/>

    <x-card>
        <x-form wire:submit="save">
            <x-input label="Name" wire:model="form.name"/>
            <x-input label="Description" wire:model="form.description"/>
            <x-slot:actions>
                <x-button.back link="{{ route('management.permissions.index') }}"/>
                <x-button.submit/>
            </x-slot:actions>
        </x-form>
    </x-card>
</div>
