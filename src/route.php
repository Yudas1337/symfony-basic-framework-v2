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
$user->add('view', new Route('/user_view/{title}', ['title' => 'User Page', '_controller' => [new UserController($dispatcher), 'userpage']], methods: ['GET']));
$user->add('index', new Route('/', ['_controller' => [UserController::class, 'index']],  methods: ['GET']));
$user->add('store', new Route('/', ['_controller' => [new UserController($dispatcher, $validator), 'store']],  methods: ['POST']));
$user->add('show', new Route('/{id}', ['_controller' => [UserController::class, 'show']],  methods: ['GET']));
$user->add('update', new Route('/{id}', ['_controller' => [UserController::class, 'update']],  methods: ['PATCH']));
$user->add('destroy', new Route('/{id}', ['_controller' => [UserController::class, 'destroy']],  methods: ['DELETE']));

$user->addPrefix('/user');
$user->addNamePrefix('user_');

$routes->addCollection($user);

return $routes;
