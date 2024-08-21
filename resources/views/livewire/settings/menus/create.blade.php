<div>
    <x-header :title="isset($menu) ? 'Edit Menu' : 'New Menu'" progress-indicator />
    <x-card>
        <x-form wire:submit="save">
            <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-4">
                <div class="sm:col-span-2">
                    <x-input label="Name" wire:model.live.debounce="form.name" wire:keyup.debounce.500="generateSlug" />
                </div>
                <div class="sm:col-span-2">
                    <x-input label="Handle" wire:model="form.handle" />
                </div>
            </div>

            <div>
                <div wire:key="navigation-items-wrapper">
                    <label class="label label-text pt-0 font-semibold">
                        <span>Items</span>
                    </label>
                    <div
                        class="space-y-2"
                        x-data="navigationSortableContainer({
                                    statePath: @js('form.items'),
                                })"
                        data-sortable-container
                    >
                        @forelse ($form->items as $uuid => $item)
                            <x-nav-item :statePath="'form.items.'.$uuid" :item="$item" />
                        @empty
                            <div
                                @class([
                                    'peer input input-primary flex w-full items-center',
                                ])
                            >
                                {{ __('No items.') }}
                            </div>
                        @endforelse
                    </div>
                </div>
                <div class="mt-5 flex justify-end">
                    <x-button label="Add Item" wire:click="createItem" />
                </div>
            </div>

            <x-slot:actions>
                <x-button.back link="{{ route('management.menus.index') }}" />
                <x-button.submit />
            </x-slot>
        </x-form>
    </x-card>

    <template x-teleport="body">
        <x-modal wire:model="show" :title="isset($item) ? 'Edit Item' : 'New Item'">
            <hr class="mb-5" />
            <x-form wire:submit="addItem">
                <x-input label="Name" wire:model.live="itemForm.label" required />
                <x-input
                    label="Description"
                    wire:model.live="itemForm.description"
                    hint="Fill in this field to be used as a description in the Spotlight component"
                />
                <x-select
                    label="Type"
                    wire:model.live="itemForm.type"
                    :options="$itemForm->types"
                    placeholder="Select One"
                    placeholder-value=""
                />
                <div x-data="{ open: $wire.entangle('itemForm.type').live }">
                    <div x-show="open !== 'separator'">
                        <x-form.icon-picker label="Icon" wire:model="itemForm.icon" single searchable>
                            @scope('selection', $icon)
                                <x-mary-icon :name="\Illuminate\Support\Str::replaceFirst('-', '.', $icon['name'])" />
                                {{ $icon['name'] }}
                            @endscope
                        </x-form.icon-picker>
                    </div>
                    <div x-show="open !== '' && open !== 'separator'">
                        <x-input label="URL" wire:model.live="itemForm.url" />

                        <x-choices-offline
                            label="Permissions"
                            wire:model="itemForm.permissions"
                            :options="$permissionsList"
                            option-label="description"
                            searchable
                        />
                    </div>
                </div>
                <x-slot:actions>
                    <x-button.back @click="$wire.show = false" />
                    <x-button.submit />
                </x-slot>
            </x-form>
        </x-modal>
    </template>
</div>
