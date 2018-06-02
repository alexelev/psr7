<?php

use Framework\Http\Router\Exception\RequestNotMatchedException;
use Framework\Http\Router\RouteCollection;
use Framework\Http\Router\Router;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
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

$routes->get('home', '/', function (ServerRequestInterface $request) {
    $name = $request->getQueryParams()['name'] ?? 'Guest';
    return new HtmlResponse('Hello ' . $name . '!');
});

$routes->get('about', '/about', function () {
    return new HtmlResponse("I'm a simple site");
});

$routes->get('blog', '/blog', function () {
    return new JsonResponse([
        ['id' => 2, 'title' => "I'm a second post"],
        ['id' => 1, 'title' => "I'm a first post"],
    ]);
});

$routes->get('blog_show', '/blog/{id}', function (ServerRequestInterface $request) {
    $id = $request->getAttribute('id');
    if ($id > 3) {
        return new JsonResponse(['error' => 'Undefined page', 404]);
    }
    return new JsonResponse(['id' => $id, 'title' => 'Post #' . $id]);
},
    ['id' => '\d+']
);

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

