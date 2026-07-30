<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/template.php';

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Core\Framework;
use User\Listener\UserCreatedListener;


$request = Request::createFromGlobals(); // baca incoming http request

$dispatcher = new EventDispatcher();
$routes = include __DIR__ . '/../src/route.php'; // import routenya

$context = new RequestContext();
$matcher = new UrlMatcher($routes, $context); // match sama RouteCollection

$dispatcher->addSubscriber(new UserCreatedListener()); // init dispatcher

$controllerResolver = new ControllerResolver(); // resolve dari bawaan yaitu _controller
$argumentResolver = new ArgumentResolver(); // parsing method

$framework = new Framework($matcher, $controllerResolver, $argumentResolver);
$response = $framework->handle($request);

$response->send();
