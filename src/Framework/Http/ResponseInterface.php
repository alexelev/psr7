<?php

namespace Framework\Http;

interface ResponseInterface
{
    public function getBody();

    /**
     * @return int
     */
    public function getStatusCode(): int;

    /**
     * @return array
     */
    public function getHeaders(): array;

    /**
     * @param $header
     * @return bool
     */
    public function hasHeader($header): bool;

    /**
     * @param $header
     * @return static
     */
    public function getHeader($header);

    /**
     * @param $header
     * @param $value
     * @return static
     */
    public function withHeader($header, $value);

    public function getReasonPhrase();

    /**
     * @param        $code
     * @param string $reasonPhrase
     * @return static
     */
    public function withStatus($code, $reasonPhrase = '');

    /**
     * @param $body
     * @return static
     */
    public function withBody($body);
}