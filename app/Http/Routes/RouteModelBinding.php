<?php

namespace App\Http\Routes;

use Dentro\Yalr\Contracts\Bindable;
use Illuminate\Routing\Router;

class RouteModelBinding implements Bindable
{
    public function __construct(protected Router $router)
    {
    }

    public function bind(): void
    {
        //example
        //$this->router->bind('user_hash', fn ($value) => \App\Models\User::byHashOrFail($value));
    }
}
