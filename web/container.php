<?php

require __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$container = new ContainerBuilder();

$loader = new YamlFileLoader(
    $container,
    new FileLocator(__DIR__ . '/../app/config')
);
$loader->load('services.yml');

$twig = $container->get('twig.renderer');

$calc = $container->get('mareg.calculator');

$data = [
    'title' => 'Hello!',
    'operations' => [
        'add' => ['arguments' => [5, 10], 'result' => $calc->add(5, 10)],
        'sub' => ['arguments' => [10, 5], 'result' => $calc->sub(10, 5)],
    ]
];

$content = $twig->render('page.html.twig', $data);

$request = Request::createFromGlobals();
$response = new Response();
$response->setContent($content);
$response->prepare($request);
$response->send();
