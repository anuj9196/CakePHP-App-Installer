<?php
/**
 * @var \Cake\Routing\RouteBuilder $routes
 */

use Cake\Routing\RouteBuilder;
use Cake\Routing\Route\DashedRoute;

$routes->plugin(
    'CakePHPAppInstaller',
    ['path' => '/installer'],
    static function (RouteBuilder $routes) {
        $routes->connect('/', ['controller' => 'Install', 'action' => 'index']);
        $routes->fallbacks(DashedRoute::class);
    }
);
