<?php

use Framework\Http\Router\Exception\RequestNotMatchedException;
use Framework\Http\Router\RouteCollection;
use Framework\Http\Router\Router;
use Http\Controller\AboutAction;
use Http\Controller\Blog\IndexAction;
use Http\Controller\Blog\ShowAction;
use Http\Controller\HomeAction;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response\SapiEmitter;

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
$routes->get('home', '/', new HomeAction());
$routes->get('about', '/about', new AboutAction());
$routes->get('blog', '/blog', new IndexAction());
$routes->get('blog_show', '/blog/{id}', new ShowAction(), ['id' => '\d+']);

$router = new Router($routes);
$request = ServerRequestFactory::fromGlobals();

try {
    $result = $router->match($request);
    foreach ($result->getAttributes() as $attribute => $value) {
        $request = $request->withAttribute($attribute, $value);
    }
    $action = $result->getHandler();
    $response = $action($request);
} catch (RequestNotMatchedException $e) {
    $response = new JsonResponse(['error' => 'Undefined page'], 404);
}


# Postprocessing

$response = $response->withHeader('X-Developer', 'livalex');

# Sending

$sender = new SapiEmitter();
$sender->emit($response);

