<?php

namespace App\Http\Controller\Blog;

use Framework\Http\Router\SimpleRouter;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\Response\RedirectResponse;

class PublicAction
{
    private $router;

    public function __construct(SimpleRouter $router)
    {
        $this->router = $router;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        $id = $request->getAttribute('id');

        if ($id > 3) {
            return new JsonResponse(['error' => 'Undefined page'], 404);
        }

        return new RedirectResponse($this->router->generate('blog_show', ['id' => $id]));
    }
}