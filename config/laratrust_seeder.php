<?php

return [
    'role_structure' => [
        'super_admin' => [
            'users' => 'c,r,u,d',
            'admins' => 'c,r,u,d',
            'categories' => 'c,r,u,d',
            'subcategories' => 'c,r,u,d',
            'advertisements' => 'c,r,u,d',
            'selections' => 'c,r,u,d',
            'questions' => 'c,r,u,d',
            'orders' => 'c,r,u,d',

        ],
        'admin'=>[

        ],
        'user'=>[

        ],
    ],
    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
