<?php

namespace M809745357\MiniProgram;

use Illuminate\Contracts\Routing\Registrar as Router;

class RouteRegistrar
{
    /**
     * The router implementation.
     *
     * @var \Illuminate\Contracts\Routing\Registrar
     */
    protected $router;

    /**
     * Create a new route registrar instance.
     *
     * @param  \Illuminate\Contracts\Routing\Registrar  $router
     * @return void
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Register routes for MiniProgram.
     *
     * @return void
     */
    public function all()
    {
        $this->forUser();
    }

    /**
     * Register the routes needed for user.
     *
     * @return void
     */
    public function forUser()
    {
        $this->router->group(['middleware' => 'api'], function ($router) {
            $router->post('/register', [
                'uses' => 'UserController@register'
            ]);

            $router->put('/user', [
                'uses' => 'UserController@update',
                'middleware' => 'auth:api'
            ]);
        });
    }
}
