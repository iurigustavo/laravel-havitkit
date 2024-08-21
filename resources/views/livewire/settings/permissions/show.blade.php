<div>
    @if (isset($isCreate))
        <x-button label="Create" @click="$wire.show = true" icon="o-plus" class="btn-primary" responsive />
    @endif

    <template x-teleport="body">
        <x-modal wire:model="show" :title="isset($permission) ? 'Edit Permission' : 'New Permission'" persistent>
            <hr class="mb-5" />
            <x-form wire:submit="save">
                <x-input label="Name" wire:model="form.name" />
                <x-input label="Description" wire:model="form.description" />
                <x-slot:actions>
                    <x-button.back @click="$dispatch('permission-cancel')" />
                    <x-button.submit />
                </x-slot>
            </x-form>
        </x-modal>
    </template>
</div>
