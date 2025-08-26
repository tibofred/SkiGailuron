<?php

use Symfony\Component\HttpFoundation\Request;

// --- Autoloader & Kernel ---
require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/../app/AppKernel.php';

// --- Proxies/Hosts de confiance (Kinsta via Nginx/Load Balancer) ---
// Permet à Symfony de lire correctement X-Forwarded-Proto/Host/Port
// et d'éviter les boucles HTTP<->HTTPS / locale<->locale.
Request::setTrustedProxies(
    ['0.0.0.0/0'], // en container, on peut faire confiance à tout (ou liste IP LB Kinsta si connue)
    Request::HEADER_X_FORWARDED_ALL
);

// restreins l’host attendu (ajoute tes domaines si besoin)
Request::setTrustedHosts([
    '^skigailuron-75pio\.kinsta\.app$',
    // '^www\.ton-domaine\.com$',
    // '^ton-domaine\.com$',
]);

// Autorise la surcharge de méthode HTTP via _method
Request::enableHttpMethodParameterOverride();

// --- Kernel prod ---
$kernel = new AppKernel('prod', false);

// Requête/réponse
$request  = Request::createFromGlobals();


print_r($request->attributes->get('_route'));exit();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);

