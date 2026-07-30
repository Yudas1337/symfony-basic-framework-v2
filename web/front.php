<?php

require_once __DIR__.'/../vendor/autoload.php';

use Calendar\Controller\LeapYearController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing;
use Symfony\Component\Routing\Matcher\UrlMatcher;


$request = Request::createFromGlobals(); // baca incoming http request
$routes = include __DIR__.'/../src/app.php'; // import routenya

$context = new Routing\RequestContext();
$matcher = new Routing\Matcher\UrlMatcher($routes, $context); // match sama RouteCollection

$controllerResolver = new ControllerResolver(); // resolve dari bawaan yaitu _controller
$argumentResolver = new ArgumentResolver(); // parsing method

$framework = new Simplex\Framework($matcher, $controllerResolver, $argumentResolver);
$response = $framework->handle($request);

$response->send();