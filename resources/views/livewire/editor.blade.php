<div>
    <x-modal wire:model="modal" class="backdrop-blur">
        <form wire:submit="save">

            <div class="divider"></div>

            <x-choices-offline label="Single" wire:model.live="name" :options="$o" single/>

            <button type="submit">Save</button>

            <x-button label="Cancel" @click="$wire.modal = false" class="mt-6"/>
        </form>
    </x-modal>
</div>
