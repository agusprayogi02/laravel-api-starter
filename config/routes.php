<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Preloads
    |--------------------------------------------------------------------------
    | String of class name that instance of \Dentro\Yalr\Contracts\Bindable
    | Preloads will always been called even when laravel routes has been cached.
    | It is the best place to put Rate Limiter and route binding related code.
    */

    'preloads' => [
        App\Http\Routes\RouteModelBinding::class,
        App\Http\Routes\RouteRateLimiter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Router group settings
    |--------------------------------------------------------------------------
    | Groups are used to organize and group your routes. Basically the same
    | group that used in common laravel route.
    |
    | 'group_name' => [
    |     // laravel group route options can contains 'middleware', 'prefix',
    |     // 'as', 'domain', 'namespace', 'where'
    | ]
    */

    'groups' => [
        'web' => [
            'middleware' => 'web',
            'prefix' => '',
        ],

        /** API for authentication */
        'auth' => [
            'middleware' => 'api',
            'prefix' => 'api/auth',
            'as' => 'auth'
        ],

        /** API used in all routes */
        'api' => [
            'middleware' => 'api',
            'prefix' => 'api',
            'as' => 'api'
        ],

        /** API to used in app */
        'api-internal' => [
            'middleware' => ['api', 'auth:sanctum'],
            'prefix' => 'api/internal',
            'as' => 'api.internal'
        ],

        /** API for external */
        'api-external' => [
            'middleware' => 'api',
            'prefix' => 'api/external',
            'as' => 'api.external'
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Routes
    |--------------------------------------------------------------------------
    | Below is where our route is loaded, it read `groups` section above.
    | keys in this array are the name of route group and values are string
    | class name either instance of \Dentro\Yalr\Contracts\Bindable or
    | controller that use attribute that inherit \Dentro\Yalr\RouteAttribute
    */

//    'web' => [
//        /** @inject web * */
//        App\Http\Routes\DefaultRoute::class,
//    ],
    'auth' => [
        /** @inject auth * */
        App\Http\Controllers\Api\Internal\Auth\AuthController::class,
        App\Http\Controllers\Api\Internal\Auth\RegisterController::class
    ],
    'api' => [
        /** @inject api * */
    ],
    'api-internal' => [
        /** @inject api-internal * */
        App\Http\Controllers\Api\Internal\General\AboutUsController::class,
        App\Http\Controllers\Api\Internal\General\ContactMeController::class,
        App\Http\Controllers\Api\Internal\Management\RoleController::class,
        App\Http\Controllers\Api\Internal\Management\UserController::class,
        App\Http\Controllers\Api\Internal\Management\MenuController::class,
        App\Http\Controllers\Api\Internal\User\ProfileController::class,
        App\Http\Controllers\Api\Internal\User\UserController::class,
        App\Http\Controllers\Api\Internal\Geo\GeoController::class,
    ],
    'api-external' => [
        /** @inject api-external * */
    ],
];
