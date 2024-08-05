<?php

namespace App\Support;

use App\Models\Order;
use App\Models\Product;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;

class Spotlight
{
    public function search(Request $request)
    {
        return collect()
            ->merge($this->actions($request->search))
            ->merge($this->tasks($request->search))
            ->merge($this->users($request->search));
    }

    // Database search

    public function actions(string $search = ''): Collection
    {
        $menus = [];
        foreach (config('app.menu.main') as $menu) {

            if (isset($menu['type']) && $menu['type'] === 'separator') {
                continue;
            }

            $icon = Blade::render("<x-icon name='{$menu['icon']}' class='w-11 h-11 p-2 bg-primary/20 rounded-full' />");

            if (isset($menu['sub'])) {

                foreach ($menu['sub'] as $sub) {
                    $menus[] = [
                        'name'        => $sub['title'],
                        'description' => $sub['description'],
                        'link'        => $sub['link'],
                        'icon'        => $icon,
                    ];
                }
            } else {
                $menus[] = [
                    'name'        => $menu['title'],
                    'description' => $menu['description'],
                    'link'        => $menu['link'],
                    'icon'        => $icon,
                ];
            }
        }

        return collect($menus)
            ->filter(fn(array $item) => str($item['name'].$item['description'])->contains($search, true))
            ->take(3);
    }

    // Database search
    public
    function tasks(
        string $search = ''
    ): Collection {
        $icon = Blade::render("<x-icon name='o-tag' class='w-11 h-11 p-2 bg-yellow-50 rounded-full' />");

        return Task::query()
            ->whereAny(['title', 'code'], 'like', "%$search%")
            ->take(3)
            ->get()
            ->map(fn(Task $task) => [
                'name'        => $task->title,
                'description' => $task->description,
                'link'        => route('tasks.index'),
                'icon'        => $icon,
            ]);
    }

    // Static search, but this could be stored on database for easy management

    public
    function users(
        string $search = ''
    ): Collection {
        return User::query()
            ->where('name', 'like', "%$search%")
            ->take(3)
            ->get()
            ->map(fn(User $user) => [
                'name'        => $user->name,
                'description' => 'User',
                'link'        => route('management.users.show', $user->id),
                'avatar'      => $user->avatar,
            ]);
    }
}
