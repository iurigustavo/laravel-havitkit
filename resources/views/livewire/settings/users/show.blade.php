<div>
    <x-header :title="isset($role) ? 'Edit User' : 'New User'" progress-indicator />

    <x-card>
        <x-form wire:submit="save">
            <x-file
                label="Avatar"
                wire:model="form.avatar"
                accept="image/png, image/jpeg"
                hint="Click to change | Max 1MB"
                crop-after-change
            >
                <img
                    src="{{ ! empty($user->avatar) ? $user->avatar_url : '/media/avatars/blank.png' }}"
                    class="mb-3 h-40 rounded-lg"
                />
            </x-file>
            <x-input label="Name" wire:model="form.name" />
            <x-input label="Email" wire:model="form.email" />
            <x-input label="Password" type="password" wire:model="form.password" />
            <x-input label="Confirm password" type="password" wire:model="form.password_confirmation" />
            <x-select
                label="Status"
                wire:model="form.active"
                :options="[['id' => 1, 'name' => 'Active'], ['id' => 0, 'name' => 'Disabled']]"
            />
            <x-choices-offline label="Roles" wire:model="form.roles" :options="$rolesList" option-label="name" />
            <x-slot:actions>
                <x-button.back link="{{ route('management.users.index') }}" />
                <x-button.submit />
            </x-slot>
        </x-form>
    </x-card>
</div>
