<?php

use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response\SapiEmitter;

chdir(dirname(__DIR__));
require_once 'vendor/autoload.php';

function dd ($d)
{
    echo '<pre>';
    var_dump($d);
    echo '</pre>';
    die();
}

# Initialization

$request = ServerRequestFactory::fromGlobals();

$path = $request->getUri()->getPath();

# Action

if ($path === '/') {

    $action = function (ServerRequestInterface $request) {
        $name = $request->getQueryParams()['name'] ?? 'Guest';

        return new HtmlResponse('Hello ' . $name . '!');
    };


} elseif ($path === '/about') {

    $action = function () {
        return new HtmlResponse("I'm a simple site");
    };

} elseif ($path === '/blog') {

    $action = function () {
        return new JsonResponse([
            ['id' => 2, 'title' => "I'm a second post"],
            ['id' => 1, 'title' => "I'm a first post"],
        ]);
    };

} elseif (preg_match('/^\/(?P<name>blog)\/(?P<id>\d+)$/i', $path, $matches)) {

    $request = $request->withAttribute('id', $matches['id']);

    $action = function (ServerRequestInterface $request) {
        $id = $request->getAttribute('id');
        if ($id > 0 && $id <= 2) {
            return new HtmlResponse("<h1>Hello!</h1><p>I'm a post with <code>id</code> = {$id}</p>");
        }
        return new JsonResponse(['error' => 'Page is not exist'], 404);
    };

} else {

    $action = function () {
        return new JsonResponse(['error' => 'Undefined page'], 404);
    };

}

if ($action) {
    $response = $action($request);
} else {
    $response = new JsonResponse(['error' => 'Undefined page'], 404);
}

# Postprocessing

$response = $response->withHeader('X-Developer', 'livalex');

# Sending

$sender = new SapiEmitter();
$sender->emit($response);

