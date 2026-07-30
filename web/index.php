<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/template.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Core\Framework;


$request = Request::createFromGlobals(); // baca incoming http request
$routes = include __DIR__ . '/../src/route.php'; // import routenya

$context = new RequestContext();
$matcher = new UrlMatcher($routes, $context); // match sama RouteCollection

$controllerResolver = new ControllerResolver(); // resolve dari bawaan yaitu _controller
$argumentResolver = new ArgumentResolver(); // parsing method

$framework = new Framework($matcher, $controllerResolver, $argumentResolver);
$response = $framework->handle($request);

$response->send();
