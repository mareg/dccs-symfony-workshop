<?php

require __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Router;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\HttpFoundation\Request;

$request = Request::createFromGlobals();

$locator = new FileLocator([__DIR__ . '/../app/config']);

$requestContext = new RequestContext();
$requestContext->fromRequest($request);

$router = new Router(
    new YamlFileLoader($locator),
    'routing.yml',
    [],
    $requestContext
);

dump(
    $router->match(
        $request->getPathInfo()
    )
);
