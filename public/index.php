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
} else {
    $response = new JsonResponse(['error' => 'Undefined page'], 404);
}

# Postprocessing

$response = $response->withHeader('X-Developer', 'livalex');

# Sending

$sender = new SapiEmitter();
$sender->emit($response);

