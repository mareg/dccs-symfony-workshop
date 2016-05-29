<?php

require __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

$request = Request::createFromGlobals();

$respone = new RedirectResponse('/request.php?name=Bilbo');

$respone->prepare($request);
$respone->send();