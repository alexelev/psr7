<?php

use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response\SapiEmitter;

chdir(dirname(__DIR__));
require_once 'vendor/autoload.php';

function dd ($d) {
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
    $name = $request->getQueryParams()['name'] ?? 'Guest';
    $response = new HtmlResponse('Hello ' . $name . '!');
} elseif ($path === '/about') {
    $response = new HtmlResponse("I'm a simple site");
} elseif ($path === '/blog') {
    $response = new JsonResponse([
        ['id' => 2, 'title' => "I'm a second post"],
        ['id' => 1, 'title' => "I'm a first post"],
    ]);
} elseif (preg_match('/^\/(?P<name>blog)\/(?P<id>\d+)$/i', $path, $matches)) {
    if ($matches['id'] == 1) {
        $response = new HtmlResponse("<h1>Hello!</h1><p>I'm a first post</p>");
    } elseif ($matches['id'] == 2) {
        $response = new HtmlResponse("<h1>Hello!</h1><p>I'm a second post</p>");
    } else {
        $response = new JsonResponse(['error' => 'Page is not exist']);
    }
} else {
    $response = new JsonResponse(['error' => 'Undefined page'], 404);
}

# Postprocessing

$response = $response->withHeader('X-Developer', 'livalex');

# Sending

$sender = new SapiEmitter();
$sender->emit($response);

