<?php

namespace App\Service;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

/**
 * @final
 */
class SimpleClient extends AbstractService
{
    public const API_KEY = '880c600e-cd74-4803-a9d0-bdbab85e78c9';
    // @TODO: add more methods
    public const GET = 'GET';
    public const POST = 'POST';
    // @TODO: add more response code
    public const HTTP_OK = 200;
    public const HTTP_NOT_FOUND = 404;
    public const HTTP_ERROR = 500;

    /**
     * @var Client
     */
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.thecatapi.com/v1/',
        ]);
    }

    /**
     * @param array $options
     * @return ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getBreeds($options = []): ResponseInterface
    {
        $preparedRequest = $this->prepare(self::GET, 'breads', $options);

        return $this->send($preparedRequest);
    }

    /**
     * @param string $id
     * @param array $options
     * @return ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getImage(string $id, $options = []): ResponseInterface
    {
        $preparedRequest = $this->prepare(self::GET, sprintf('images/%s', $id), $options);

        return $this->send($preparedRequest);
    }

    /**
     * @param array $options
     * @return ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getRandomImage($options = []): ResponseInterface
    {
        $preparedRequest = $this->prepare(self::GET, 'images/search', $options);

        return $this->send($preparedRequest);
    }

    public function createVote(string $imageId, bool $vote, $options = [])
    {
        $options = array_merge($options, [
            'body' => [
                'image_id' => $imageId,
                'value' => (int)$vote,
            ],
        ]);

        $preparedRequest = $this->prepare(self::POST, 'votes', $options);

        return $this->send($preparedRequest);
    }

    public function getVote()
    {

    }

    /**
     * @param Request\PreparedRequestDTO $preparedRequest
     * @return ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function send(Request\PreparedRequestDTO $preparedRequest): ResponseInterface
    {
        return $this->client->request(
            $preparedRequest->getMethod(),
            $preparedRequest->getUri(),
            [
                'headers' => $this->getDefaultHeaders($preparedRequest->getHeaders()),
            ]
        );
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $options
     * @return Request\PreparedRequestDTO
     */
    protected function prepare(string $method, string $uri, array $options): Request\PreparedRequestDTO
    {
        // This method was created to avoid duplication the same logic for checking if it was injected header or body
        // into Guzzle client, in each of public method
        $customHeaders = [];
        $body = '';

        if (\array_key_exists('headers', $options)) {
            $customHeaders = array_merge($customHeaders, $options['headers']);
        }

        if (\array_key_exists('body', $options)) {
            $body = $options['body'];
        }

        return new Request\PreparedRequestDTO(
            self::GET,
            'breads',
            $this->getDefaultHeaders($customHeaders),
            $body
        );
    }

    /**
     * @param array $customHeaders
     * @return array
     */
    protected function getDefaultHeaders(array $customHeaders = []): array
    {
        return \array_merge(
            $customHeaders,
            [
                'x-api-key' => self::API_KEY,
            ]
        );
    }
}
