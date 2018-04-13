<?php

use Framework\Http\RequestFactory;

chdir(dirname(__DIR__));
require_once 'vendor/autoload.php';

# Initialization

$request = RequestFactory::fromGlobals();

# Action


$name = $request->getQueryParams()['name'] ?? 'Guest';

header('X-Developer: livalex');
echo "Hello, " . $name . "!" . PHP_EOL;

