<?php

namespace Framework\Http;


class Request
{
    public function getQueryParams(): array
    {
        return $_GET;
    }

    public function getCookies(): array
    {
        return $_COOKIE;
    }

    public function getSessionData(): array
    {
        return $_SESSION;
    }

    public function getServerData(): array
    {
        return $_SERVER;
    }

    public function getParsedBody(): ?array
    {
        return $_POST ?: null;
    }

    public function getBody()
    {
        return file_get_contents('php://input');
    }
}