<?php

namespace Http\Controller\Blog;


use Zend\Diactoros\Response\JsonResponse;

class IndexAction
{
    public function __invoke(): JsonResponse
    {
        return new JsonResponse([
            ['id' => 2, 'title' => "I'm a second post"],
            ['id' => 1, 'title' => "I'm a first post"],
        ]);
    }
}