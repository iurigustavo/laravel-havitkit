<div>
    <x-header :title="'My Profile'" progress-indicator/>

    <x-card>
        <x-tabs wire:model="selectedTab">
            <x-tab name="user-tab" label="My Profile" icon="o-users">
                <x-form wire:submit="save">
                    <x-file label="Avatar" wire:model="form.avatar_file" accept="image/png, image/jpeg" hint="Click to change | Max 1MB" crop-after-change>
                        <img src="{{ !empty($user->avatar) ? $user->avatar_url : '/media/avatars/blank.png' }}" class="h-40 rounded-lg mb-3"/>
                    </x-file>
                    <x-input label="Name" wire:model="form.name"/>
                    <x-input label="Email" wire:model="form.email"/>
                    <x-slot:actions>
                        <x-button.back link="{{ route('home') }}"/>
                        <x-button.submit/>
                    </x-slot:actions>
                </x-form>
            </x-tab>
            <x-tab name="password-tab" label="Change Password" icon="o-lock-closed">
                <x-form wire:submit="changePassword">
                    <x-input label="Password" type="password" wire:model="form.password"/>
                    <x-input label="Confirm password" type="password" wire:model="form.password_confirmation"/>
                    <x-slot:actions>
                        <x-button.back link="{{ route('home') }}"/>
                        <x-button.submit/>
                    </x-slot:actions>
                </x-form>
            </x-tab>
        </x-tabs>
    </x-card>
</div>

