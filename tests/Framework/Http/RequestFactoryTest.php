<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 14.04.2018
 * Time: 00:38
 */

namespace Tests\Framework\Http;

use Framework\Http\Request;
use Framework\Http\RequestFactory;

class RequestFactoryTest extends \PHPUnit\Framework\TestCase
{
    public function testFromGlobals()
    {
        $data = [
            'name' => 'Alex',
            'age' => 20
        ];

        $_GET = $d = [
            'test' => 'value'
        ];


        self::assertEquals((new Request($data, [])), RequestFactory::fromGlobals($data));
        self::assertEquals((new Request($d, [])), RequestFactory::fromGlobals());

        $_POST = $p = [
            'post' => 11,
        ];

        self::assertEquals((new Request($d, $p)), RequestFactory::fromGlobals());
    }
}
