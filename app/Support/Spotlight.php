<?php

namespace App\Support;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

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
        $handle = 'navigation';
        $items = Cache::remember('menu-'.$handle, '1 day', static fn () => Menu::where('handle', $handle)->first()->items);
        foreach ($items as $menu) {
            if (isset($menu['type']) && $menu['type'] === 'separator') {
                continue;
            }

            if (! empty($menu['children'])) {
                foreach ($menu['children'] as $sub) {
                    $icon = ! empty($sub['icon']) ? Blade::render(
                        sprintf('<x-icon name=\'%s\' class=\'w-11 h-11 p-2 bg-primary/20 rounded-full\' />', Str::replaceFirst('-', '.', $sub['icon'])),
                    ) : null;
                    $menus[] = [
                        'name' => $sub['label'],
                        'description' => $sub['description'],
                        'link' => $sub['url'],
                        'icon' => $icon,
                    ];
                }
            } else {
                $icon = ! empty($menu['icon']) !== null ? Blade::render(
                    sprintf('<x-icon name=\'%s\' class=\'w-11 h-11 p-2 bg-primary/20 rounded-full\' />', Str::replaceFirst('-', '.', $menu['icon'])),
                ) : null;
                $menus[] = [
                    'name' => $menu['label'],
                    'description' => $menu['description'],
                    'link' => $menu['url'],
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
            'avatar' => $user->avatar_url,
        ]);
    }
}
