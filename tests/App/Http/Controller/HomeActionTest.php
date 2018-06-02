<?php

namespace Tests\App\Http\Controller;

use App\Http\Controller\HomeAction;
use PHPUnit\Framework\TestCase;
use Zend\Diactoros\ServerRequest;

class HomeActionTest extends TestCase
{
    public function testGuest()
    {
        $action = new HomeAction();
        $request = new ServerRequest();
        $response = $action($request);

        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals('Hello, Guest!', $response->getBody()->getContents());
    }

    public function testLivalex()
    {
        $action = new HomeAction();
        $request = (new ServerRequest())
            ->withQueryParams(['name' => 'Livalex']);
        $response = $action($request);

        self::assertEquals('Hello, Livalex!', $response->getBody()->getContents());
    }
}
