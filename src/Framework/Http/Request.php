<?php

namespace Framework\Http;


class Request
{

    private $queryParams;
    private $parsedBody;

    public function __construct(array $queryParams = [], $parsedBody = null)
    {
        $this->queryParams = $queryParams;
        $this->parsedBody = $parsedBody;
    }

    public function getQueryParams(): array
    {
        return $this->queryParams;
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
        return $this->parsedBody;
    }

    public function getBody()
    {
        return file_get_contents('php://input');
    }

    public function withQueryParams(array $query): Request
    {
        $new = clone $this;
        $new->queryParams = $query;
        return $new;
    }

    public function withParsedBody($data): Request
    {
        $new = clone $this;
        $new->parsedBody = $data;
        return $new;
    }
}