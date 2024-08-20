<?php

namespace App\Support;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;

class Spotlight
{
    public function search(Request $request): Collection
    {
        return collect()->merge($this->actions($request->search))->merge($this->users($request->search));
    }

    // Database search

    public function actions(string $search = ''): Collection
    {
        $menus = [];
        foreach (config('app.menu.main') as $menu) {

            if (isset($menu['type']) && $menu['type'] === 'separator') {
                continue;
            }

            $icon = Blade::render(sprintf('<x-icon name=\'%s\' class=\'w-11 h-11 p-2 bg-primary/20 rounded-full\' />', $menu['icon']));

            if (isset($menu['sub'])) {

                foreach ($menu['sub'] as $sub) {
                    $menus[] = [
                        'name' => $sub['title'],
                        'description' => $sub['description'],
                        'link' => $sub['link'],
                        'icon' => $icon,
                    ];
                }
            } else {
                $menus[] = [
                    'name' => $menu['title'],
                    'description' => $menu['description'],
                    'link' => $menu['link'],
                    'icon' => $icon,
                ];
            }
        }

        return collect($menus)->filter(fn (array $item) => str($item['name'].$item['description'])->contains($search, true))->take(3);
    }

    public function users(string $search = ''): Collection
    {
        return User::query()->where('name', 'like', sprintf('%%%s%%', $search))->take(3)->get()->map(fn (User $user): array => [
            'name' => $user->name,
            'description' => 'User',
            'link' => route('management.users.show', $user->id),
            'avatar' => $user->avatar,
        ]);
    }
}
