<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require __DIR__ . '/../vendor/autoload.php';

$loader = new \Twig_Loader_Filesystem(
    __DIR__ . '/../app/Resources/views'
);

$twig = new \Twig_Environment($loader, []);

$content = $twig->render('page.html.twig', ['title' => 'Hello!']);

$request = Request::createFromGlobals();

$response = new Response();
$response->setContent($content);
$response->prepare($request);
$response->send();