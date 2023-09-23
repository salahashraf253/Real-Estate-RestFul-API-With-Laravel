<?php

return [
    'token_name' => [
        'user' => 'user',
        'admin' => 'admin',
    ],

    'token_scope' => [
        'user' => ['read'],
        'admin' => ['create', 'update', 'delete'],
    ],
];
