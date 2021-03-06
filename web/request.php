<?php

require __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$request = Request::createFromGlobals();

$response = new Response();

$response->setContent(
    sprintf ("<h1>Hello %s!</h1>", $request->query->get('name', 'Joe'))
);

$response->prepare($request);
$response->send();
