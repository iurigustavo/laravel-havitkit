<div class="mt-20 md:w-96 mx-auto">
    <x-brand class="mb-8"/>

    <x-form wire:submit.prevent="login">
        <x-input label="E-Mail" icon="o-envelope" inline wire:model="email"/>
        <x-input label="{{ __('Password') }}" type="password" icon="o-key" inline wire:model="password"/>
        <x-checkbox wire:model="remember" class="self-start">
            <x-slot:label>
               {{ __('Remember Me') }}
            </x-slot:label>
        </x-checkbox>

        <x-slot:actions>
            <x-button label="{{ __('Login') }}" type="submit" icon="o-paper-airplane" class="btn-primary" spinner="login"/>
        </x-slot:actions>
    </x-form>
</div>
