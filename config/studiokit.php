<?php

return [
    'name' => env('APP_NAME', 'StudioKit'),
    'plans' => [
        'free' => [
            'label' => 'StudioKit Free',
            'price' => 0,
            'kit_limit' => 1,
        ],
        'starter' => [
            'label' => 'StudioKit Starter',
            'price' => 9,
            'kit_limit' => 3,
        ],
        'pro' => [
            'label' => 'StudioKit Pro',
            'price' => 29,
            'kit_limit' => null,
        ],
        'agency' => [
            'label' => 'StudioKit Agency',
            'price' => 99,
            'kit_limit' => null,
        ],
        'enterprise' => [
            'label' => 'StudioKit Enterprise',
            'price' => null,
            'kit_limit' => null,
        ],
    ],
];
