<?php

return [
    'main' => [
        [
            'title' => 'Dashboard',
            'description' => 'Go to dashboard',
            'icon' => 'o-chart-pie',
            'link' => '/',
        ],
        [
            'type' => 'separator',
        ],
        [
            'title' => 'Settings',
            'icon' => 'o-wrench-screwdriver',
            'sub' => [
                [
                    'title' => 'Users',
                    'link' => '/management/users',
                    'description' => 'Manage users',
                    'permission' => 'viewAny Task',
                ],
                [
                    'title' => 'Roles',
                    'link' => '/management/roles',
                    'description' => 'Manage Roles',
                    'permission' => 'management',
                ],
                [
                    'title' => 'Permissions',
                    'link' => '/management/permissions',
                    'description' => 'Manage Permissions',
                    'permission' => 'management',
                ],
                [
                    'title' => 'Activity Log',
                    'link' => '/management/activity-log',
                    'description' => 'Show activity logs events',
                    'permission' => 'management',
                ],
            ],
        ],
    ],
];
