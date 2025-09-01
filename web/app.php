<?php
use Symfony\Component\HttpFoundation\Request;

$loader = require __DIR__.'/../app/autoload.php';

/* include_once __DIR__.'/../var/bootstrap.php.cache'; */

// Déclarer les proxies de confiance
Request::setTrustedProxies(
    ['127.0.0.1', $_SERVER['REMOTE_ADDR'] ?? 'REMOTE_ADDR'],
    Request::HEADER_X_FORWARDED_ALL
);

// (Optionnel, pour éviter le header "Forwarded" pas toujours fiable)
Request::setTrustedHeaderName(Request::HEADER_FORWARDED, null);

// Créer la requête
$request = Request::createFromGlobals();

// ⚠️ Indiquer à Symfony qu’on est en HTTPS si le proxy le dit
if ($request->headers->get('X-Forwarded-Proto') === 'https') {
    $request->server->set('HTTPS', 'on');
}

// Kernel
$kernel = new AppKernel('prod', false);
//$kernel = new AppCache($kernel);

// Traiter la requête
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
