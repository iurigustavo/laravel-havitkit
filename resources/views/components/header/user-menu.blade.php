@auth
    <x-dropdown>
        <x-slot:trigger>
            <x-avatar :image="auth()->user()->avatar_url" class="!w-8 !rounded-lg"/>
        </x-slot:trigger>
        <div class="w-64">
            <x-avatar :image="auth()->user()->avatar_url" :title="auth()->user()->name" :subtitle="auth()->user()->email" class="!w-10"/>
            <x-menu-separator/>
            <x-menu-item icon="o-user" :title="__('My Profile')" link="{{ route('my-profile') }}"/>
            <x-menu-separator/>
            <x-menu-item icon="o-swatch" :label="__('Toggle theme')" @click.stop="$dispatch('mary-toggle-theme')"/>
            <x-menu-separator/>
            @impersonating($guard = null)
            <x-menu-item icon="o-user-minus" :label="__('Leave impersonation')" link="{{ route('impersonate.leave') }}" no-wire-navigate/>
            @endImpersonating
            <x-menu-item icon="o-power" :label="__('Logout')" link="/logout" no-wire-navigate/>
        </div>
    </x-dropdown>
@endauth


