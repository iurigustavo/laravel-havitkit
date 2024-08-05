<?php

return [
    /**
     * Default is empty.
     *    prefix => ''
     *              <x-button />
     *              <x-card />
     *
     * Renaming all components:
     *    prefix => 'mary-'
     *               <x-mary-button />
     *               <x-mary-card />
     *
     * Make sure to clear view cache after renaming
     *    php artisan view:clear
     *
     */
    'prefix'     => '',

    /**
     * Components settings
     */
    'components' => [
        'spotlight' => [
            'class' => 'App\Support\Spotlight',
        ],
    ],

    'default' => [
        'card' => [
            'class'    => 'bg-base-100 rounded-lg p-5',
            'shadow'   => 'shadow-sm',
            'progress' => 'progress progress-primary w-full h-0.5 dark:h-1',
        ],
    ],
];

