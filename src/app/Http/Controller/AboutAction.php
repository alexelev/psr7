<?php

namespace Http\Controller;

use Zend\Diactoros\Response\HtmlResponse;

class AboutAction
{
    public function __invoke(): HtmlResponse
    {
        return new HtmlResponse("I'm a simple site");
    }
}