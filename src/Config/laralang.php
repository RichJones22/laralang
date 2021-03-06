<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default settings for laralang
    |--------------------------------------------------------------------------
    */
    'default'   => [
        'autosave'       => true,
        'debug'          => false,
        'routes'         => true,
        'prefix'         => 'laralang',
        'password'       => 'laralangAdmin',
        'translator'     => 'mymemory',
        'from_lang'      => 'en',
        'to_lang'        => 'app_locale',
        'middleware'     => Premise\Laralang\Middleware\LaralangMiddleware::class,
    ],
];
