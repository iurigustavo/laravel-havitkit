<div>
    <x-header :title="isset($role) ? 'Edit Role' : 'New Role'" progress-indicator/>
    <x-card>
        <x-form wire:submit="save">
            <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                <div class="sm:col-span-2">
                    <x-input label="Name" wire:model="form.name"/>
                </div>
                <div class="sm:col-span-2">
                    <x-input label="Description" wire:model="form.description"/>
                </div>
                <div class="sm:col-span-1">
                    <label class="flex items-center gap-3 cursor-pointer pt-0 label label-text font-semibold">
                        <span class="flex-1">Select all</span>

                    </label>
                    <input type="checkbox" class="toggle toggle-primary" wire:click="toggleAll" @checked( count($form->permissions) === count($allOptions))>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="table text-gray-700 font-medium text-sm">
                    <thead>
                    <tr>
                        <th class="text-left">
                            Module
                        </th>
                        @foreach($permissionsList['headers'] as $header)
                            <th class="min-w-24 text-center">
                                {{ $header }}
                            </th>
                        @endforeach
                    </tr>
                    </thead>

                    <tbody class="text-gray-900 font-semibold">
                    @foreach($permissionsList['permissions']['models'] as $model => $row)
                        <tr>
                            <td class="!py-5.5">
                                {{ Str::title($model) }}
                            </td>
                            @foreach($permissionsList['headers'] as $header)
                                <td class="!py-5.5 text-center">
                                    <input @checked($row[$header]['can']) wire:model="form.permissions" class="checkbox checkbox-sm" type="checkbox"
                                           value="{{ $row[$header]['name'] }}">
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                    @if (isset($permissionsList['permissions']['others']))
                        @foreach($permissionsList['permissions']['others'] as $model => $row)
                            <tr>
                                <td class="!py-5.5">
                                    {{ Str::title($model) }}
                                </td>
                                <td class="!py-5.5 text-center">
                                    <input @checked($row['can']) wire:model="form.permissions" class="checkbox checkbox-sm" type="checkbox"
                                           value="{{ $row['name'] }}">
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
            <x-slot:actions>
                <x-button.back link="{{ route('management.roles.index') }}"/>
                <x-button.submit/>
            </x-slot:actions>
        </x-form>
    </x-card>
</div>
