<?php

namespace App\Http\Routes;

use App\Http\Controllers\DefaultController;
use Dentro\Yalr\BaseRoute;

class DefaultRoute extends BaseRoute
{
    protected string $prefix = '';

    protected string $name = '';
    /**
     * Register routes handled by this class.
     *
     * @return void
     */
    public function register(): void
    {
        $this->router->get($this->prefix, [
            'as' => $this->name,
            'uses' => $this->uses('index')
        ]);
    }

    /**
     * Controller used by this route.
     *
     * @return string
     */
    public function controller(): string
    {
        return DefaultController::class;
    }
}
