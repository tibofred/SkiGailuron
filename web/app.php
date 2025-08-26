<?php

use Symfony\Component\HttpFoundation\Request;

// --- Autoloader & Kernel ---
require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/../app/AppKernel.php';


// Autorise la surcharge de méthode HTTP via _method
Request::enableHttpMethodParameterOverride();

// --- Kernel prod ---
$kernel = new AppKernel('prod', false);

// Requête/réponse
$request  = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);

