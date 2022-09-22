<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::plugin(
    'CakePHPAppInstaller',
    ['path' => '/installer'],
    function (RouteBuilder $routes) {
        $routes->connect('/', ['controller' => 'Install', 'action' => 'index']);
        $routes->fallbacks(DashedRoute::class);
    }
);
