<?php

namespace App\Service\Request;

class PreparedRequestDTO
{
    /**
     * @var string
     */
    protected $method;

    /**
     * @var string
     */
    protected $uri;

    /**
     * @var array
     */
    protected $headers;

    /**
     * @var string
     */
    protected $body;

    public function __construct(string $method, string $uri, array $headers, string $body)
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->headers = $headers;
        $this->body = $body;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }
}
