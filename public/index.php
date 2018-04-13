<?php

use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response\SapiEmitter;

chdir(dirname(__DIR__));
require_once 'vendor/autoload.php';

# Initialization

$request = ServerRequestFactory::fromGlobals();

# Action

$name = $request->getQueryParams()['name'] ?? 'Guest';

$response = (new HtmlResponse('Hello ' . $name . '!'))
    ->withHeader('X-Developer', 'livalex');

# Sending

$sender = new SapiEmitter();
$sender->emit($response);

