<?php

use App\Http\Controller\Blog\PublicAction;
use Framework\Http\ActionResolver;
use Framework\Http\Router\Exception\RequestNotMatchedException;
use Framework\Http\Router\RouteCollection;
use Framework\Http\Router\SimpleRouter;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response\SapiEmitter;
use App\Http\Controller;

chdir(dirname(__DIR__));
require_once 'vendor/autoload.php';

function dd($d)
{
    echo '<pre>';
    var_dump($d);
    echo '</pre>';
    die();
}

# Initialization

$routes = new RouteCollection();
$router = new SimpleRouter($routes);

$routes->get('home', '/', Controller\HomeAction::class);
$routes->get('about', '/about', Controller\AboutAction::class);
$routes->get('blog', '/blog', Controller\Blog\IndexAction::class);
$routes->get('blog_show', '/blog/{id}', Controller\Blog\ShowAction::class, ['id' => '\d+']);
$routes->get('blog_public', '/blog/{id}', new PublicAction($routerco), ['id' => '\d+']);

$resolver = new ActionResolver();

$request = ServerRequestFactory::fromGlobals();

try {
    $result = $router->match($request);
    foreach ($result->getAttributes() as $attribute => $value) {
        $request = $request->withAttribute($attribute, $value);
    }
    $action = $resolver->resolve($result->getHandler());
    $response = $action($request);
} catch (RequestNotMatchedException $e) {
    $response = new JsonResponse(['error' => 'Undefined page'], 404);
}


# Postprocessing

$response = $response->withHeader('X-Developer', 'livalex');

# Sending

$sender = new SapiEmitter();
$sender->emit($response);

