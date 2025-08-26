<?php

use Symfony\Component\HttpFoundation\Request;

require __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../app/AppKernel.php';

$kernel = new AppKernel('prod', false);

// Boot the kernel so the container is available
$kernel->boot();

$request   = Request::createFromGlobals();
$container = $kernel->getContainer();
$router    = $container->get('router');

// Match the current request to a route
$matcher     = $router->getMatcher();
$parameters  = $matcher->matchRequest($request);
$routeName   = $parameters['_route'];
$route       = $router->getRouteCollection()->get($routeName);

header('Content-Type: text/plain');
print_r([
    'uri'         => $request->getRequestUri(),
    'method'      => $request->getMethod(),
    'route_name'  => $routeName,
    'parameters'  => $parameters,
    'path'        => $route->getPath(),
    'defaults'    => $route->getDefaults(),
    'requirements'=> $route->getRequirements(),
    'methods'     => $route->getMethods(),
    'schemes'     => $route->getSchemes(),
    'host'        => $route->getHost(),
]);

// ⚠️ Skip normal flow while debugging
// $response = $kernel->handle($request);
// $response->send();
// $kernel->terminate($request, $response);
