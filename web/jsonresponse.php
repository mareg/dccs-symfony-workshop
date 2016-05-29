<?php

require __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

$request = Request::createFromGlobals();

$respone = new JsonResponse(['code' => 200, 'message' => 'OK']);

$respone->prepare($request);
$respone->send();