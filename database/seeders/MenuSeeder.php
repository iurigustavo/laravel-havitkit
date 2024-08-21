<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $navigation = new Menu;
        $navigation->name = 'Navigation';
        $navigation->handle = 'navigation';
        $navigation->items = [
            'ec470d3c-b581-4832-b88e-02d9244ec3a4' => [
                'label' => 'Dashboard',
                'description' => '',
                'type' => 'internal',
                'url' => '/',
                'permissions' => [
                ],
                'children' => [
                ],
                'icon' => 'heroicon-o-chart-pie',
            ],
            '9fe8beb3-f0db-44c8-bf2d-29a895076711' => [
                'label' => 'Separator',
                'description' => '',
                'type' => 'separator',
                'url' => '',
                'permissions' => [
                ],
                'children' => [
                ],
            ],
            '4280f55b-d3ed-45ee-867b-f5173915be35' => [
                'label' => 'Settings',
                'description' => '',
                'type' => '',
                'url' => '',
                'roles' => [
                ],
                'permissions' => [
                ],
                'children' => [
                    'dc44ddaa-7143-4e99-8f15-baaa45e55582' => [
                        'label' => 'Users',
                        'description' => 'Manage users',
                        'type' => 'internal',
                        'url' => '/management/users',
                        'roles' => [
                        ],
                        'permissions' => [
                            0 => 1,
                            1 => 24,
                        ],
                        'children' => [
                        ],
                    ],
                    'bf75bf01-d559-408e-b376-db0db82b2f6b' => [
                        'label' => 'Roles',
                        'description' => 'Manage Roles',
                        'type' => 'internal',
                        'url' => '/management/roles',
                        'roles' => [
                        ],
                        'permissions' => [
                            0 => 1,
                            1 => 10,
                        ],
                        'children' => [
                        ],
                    ],
                    '600dea78-4d76-4656-ac06-c67d10a0ffa6' => [
                        'label' => 'Permissions',
                        'description' => 'Manage Permissions',
                        'type' => 'internal',
                        'url' => '/management/permissions',
                        'permissions' => [
                            0 => 3,
                            1 => 1,
                        ],
                        'children' => [
                        ],
                    ],
                    '2f07edbe-09be-4fe3-bfef-c822a14e889e' => [
                        'label' => 'Menus',
                        'description' => 'Manage Menus',
                        'type' => 'internal',
                        'url' => '/management/menus',
                        'permissions' => [
                            0 => 1,
                            1 => 48,
                        ],
                        'children' => [
                        ],
                    ],
                    'b7bb23d8-cec8-499d-9577-82f9988d379e' => [
                        'label' => 'Activity Log',
                        'description' => 'Show activity logs events',
                        'type' => 'internal',
                        'url' => '/management/activity-log',
                        'permissions' => [
                            0 => 1,
                        ],
                        'children' => [
                        ],
                    ],
                ],
                'icon' => 'heroicon-o-wrench-screwdriver',
            ],
        ];
        $navigation->save();
    }
}
