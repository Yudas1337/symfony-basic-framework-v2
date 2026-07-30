<?php

use Core\Framework;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\EventListener\ErrorListener;
use Symfony\Component\HttpKernel\EventListener\ResponseListener;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use User\Listener\UserCreatedListener;

$container = new ContainerBuilder();

$container->set('routes', $routes);
$container->set('dispatcher', $dispatcher);

$container->register('context', RequestContext::class);
$container->register('matcher', UrlMatcher::class)
    ->setArguments([new Reference('routes'), new Reference('context')]);
$container->register('request_stack', RequestStack::class);
$container->register('controller_resolver', ControllerResolver::class);
$container->register('argument_resolver', ArgumentResolver::class);

$container->register('listener.router', RouterListener::class)
    ->setArguments([new Reference('matcher'), new Reference('request_stack')]);
$container->register('listener.response', ResponseListener::class)
    ->setArguments(['UTF-8']);
$container->register('listener.error', ErrorListener::class)
    ->setArguments([function (FlattenException $exception): Response {
        if (404 === $exception->getStatusCode()) {
            return new Response('Not Found', 404);
        }

        return new Response('An error occurred', 500);
    }]);

$container->get('dispatcher')->addSubscriber($container->get('listener.router'));
$container->get('dispatcher')->addSubscriber($container->get('listener.response'));
$container->get('dispatcher')->addSubscriber($container->get('listener.error'));
$container->get('dispatcher')->addSubscriber(new UserCreatedListener());

$container->register('framework', Framework::class)
    ->setArguments([
        new Reference('dispatcher'),
        new Reference('controller_resolver'),
        new Reference('request_stack'),
        new Reference('argument_resolver'),
    ]);

return $container;
