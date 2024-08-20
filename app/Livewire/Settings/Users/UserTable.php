<?php

namespace App\Livewire\Settings\Users;

use App\Actions\User\DeleteUserAction;
use App\Core\Concerns\Tableable;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Blade;
use Livewire\Attributes\Title;
use Mary\View\Components\Avatar;
use Mary\View\Components\Badge;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\Rule;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

#[Title('List Users')]
final class UserTable extends Tableable
{
    public bool $authorize = true;

    public function boot(): void
    {
        config(['livewire-powergrid.filter' => 'drawer']);
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
                        ->add('id')
                        ->add('avatar', fn($user) => Blade::renderComponent((new Avatar($user->avatar_url))->withAttributes(['class' => '!w-10'])))
                        ->add('name')
                        ->add('email')
                        ->add('roles', fn($user) => $user->roles->map(fn($role) => Blade::renderComponent((new Badge($role->description))->withAttributes(['class' => 'badge-primary'])))->implode(' '))
                        ->add('is_active', fn($user): string => $user->active ? __('Yes') : __('No'));
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id'),
            Column::make('Avatar', 'avatar'),
            Column::make('Name', 'name')->sortable()->searchable(),
            Column::make('Email', 'email')->sortable()->searchable(),
            Column::make('Active', 'is_active'),
            Column::make('Roles', 'roles'),
            Column::action('Action')->fixedOnResponsive(),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::number('id'),
            Filter::inputText('name')->operators(['contains']),
            Filter::boolean('is_active', 'active')
                  ->label('Yes', 'No'),
            Filter::multiSelect('roles')
                  ->dataSource(Role::all())
                  ->optionValue('id')
                  ->optionLabel('description')
                  ->builder(fn(Builder $query, array $value) => $query->whereHas('roles', function (Builder $query) use ($value): void {
                      $query->whereIn('role_id', $value);
                  })),
        ];
    }

    public function datasource(): Builder
    {
        return User::query()->with('roles');
    }

    public function relationSearch(): array
    {
        return [
            'roles' => [
                'name',
                'description',
            ],
        ];
    }

    public function delete(User $user, DeleteUserAction $action): void
    {
        $action->handle($user);
        $this->success(__('form.deleted'));
    }

    public function actions(User $row): array
    {
        return [
            Button::make('show')->bladeComponent('button.view', ['link' => route('management.users.show', $row)]),
            Button::add('delete')->id()->render(fn($row) => Blade::render(
                <<<HTML
<x-button.delete wire:click="delete('$row->id')" />
HTML
            )),
            Button::add('impersonate')->bladeComponent(
                'button',
                [
                    'icon'    => 'o-user',
                    'class'   => 'btn btn-sm btn-circle bg-purple-100 hover:bg-purple-300 text-purple-600 hover:text-purple-100',
                    'tooltip' => 'Impersonate',
                    'link'    => route('impersonate', $row),
                ]
            )->can(allowed: $row->canBeImpersonated()),
        ];
    }

    public function actionRules(): array
    {
        return [
            Rule::rows()->when(fn($user): bool => $user->active === false)->setAttribute('class', '!text-red-500'),
        ];
    }

    public function getModel(): string
    {
        return User::class;
    }
}
