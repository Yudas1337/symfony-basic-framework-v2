<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Calendar\Controller\LeapYearController;
use User\Controller\UserController;

$routes = new RouteCollection();

// testing dari docs
$routes->add('leap_year', new Route('/is_leap_year/{year}', [
    'year' => null,
    '_controller' => [LeapYearController::class, 'index'],
]));

// user route
$user = new RouteCollection();
$user->add('viewpage', new Route('/user_page/{title}', ['title' => 'User Page', '_controller' => [UserController::class, 'userpage']], methods: ['GET']));
$user->add('user_index', new Route('/', ['_controller' => [UserController::class, 'index']], methods: ['GET']));
$user->add('user_show', new Route('/{id}', ['id' => null, '_controller' => [UserController::class, 'show']], methods: ['GET']));
$user->add('user_create', new Route('/', ['_controller' => [UserController::class, 'store']], methods: ['POST']));
$user->add('user_update', new Route('/{id}', ['id' => null, '_controller' => [UserController::class, 'update']], methods: ['PATCH']));
$user->add('user_destroy', new Route('/{id}', ['id' => null, '_controller' => [UserController::class, 'destroy']], methods: ['DELETE']));

$user->addPrefix('/user');
$user->addNamePrefix('user_');

$routes->addCollection($user);

return $routes;
