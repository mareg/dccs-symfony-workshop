<?php

require __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

$routes = new RouteCollection();
$routes->add('hello', new Route('/hello/{name}', [
    'name' => 'Marek',
    '_controller' => function (Request $request) {
        return new Response(sprintf("Hello %s", $request->get('name')));
    }
]));

$request = Request::createFromGlobals();

$matcher = new UrlMatcher($routes, new RequestContext());

$dispatcher = new EventDispatcher();
$dispatcher->addSubscriber(new RouterListener($matcher, new RequestStack()));

$dispatcher->addListener(
    KernelEvents::EXCEPTION,
    function(GetResponseForExceptionEvent $event) {

        $exception = $event->getException();

        if ($exception instanceof HttpExceptionInterface) {
            $event->setResponse(new JsonResponse(
                [
                    'code' => $exception->getCode() ?: 500,
                    'message' => $exception->getMessage()
                ]
            ));
        }
});

$resolver = new ControllerResolver();

$kernel = new HttpKernel($dispatcher, $resolver);

try {
    $response = $kernel->handle($request);
} catch (\Exception $e) {
    $response = new Response('Exception: ' . $e->getMessage());
}

$response->send();
$kernel->terminate($request, $response);
