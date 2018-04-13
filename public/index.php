<?php

use Framework\Http\Request;

chdir(dirname(__DIR__));
require_once 'vendor/autoload.php';

# Initialization

$request = new Request();

# Action


$name = $request->getQueryParams()['name'] ?? 'Guest';

header('X-Developer: livalex');
echo "Hello, " . $name . "!" . PHP_EOL;

