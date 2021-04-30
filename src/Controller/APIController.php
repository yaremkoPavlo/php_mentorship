<?php

namespace App\Controller;

use App\Service\SimpleClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class APIController extends AbstractController
{
    /**
     * @var SimpleClient
     */
    private $client;

    public function __construct()
    {
        parent::__construct();

        $this->client = $this->container->get('client');
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     */
    public function indexAction(Request $request): Response
    {
        //Random image
        $randomImage = $this->client->getRandomImage();

        if (!$randomImage->withStatus($this->client::HTTP_NOT_FOUND)) {
            $result = new JsonResponse(
                $randomImage->getBody(),
                $this->client::HTTP_OK,
            );
        } else {
            $result = $this->errorAction($request);
        }

        return $result;
    }

    public function imageAction(Request $request, string $id): Response
    {
        $image = $this->client->getImage($id);

        if (!$image->withStatus($this->client::HTTP_NOT_FOUND)) {
            $result = new JsonResponse(
                $image->getBody(),
                $this->client::HTTP_OK,
            );
        } else {
            $result = $this->errorAction($request);
        }

        return $result;
    }

    public function breedsAction(Request $request): Response
    {
        $breeds = $this->client->getBreeds();

        if (!$breeds->withStatus($this->client::HTTP_NOT_FOUND)) {
            $result = new JsonResponse(
                $breeds->getBody(),
                $this->client::HTTP_OK,
            );
        } else {
            $result = $this->errorAction($request);
        }

        return $result;
    }

    public function errorAction(Request $request): Response
    {
        return new JsonResponse(
            ['error' => 'Can\'t find result for this route'],
            $this->client::HTTP_NOT_FOUND
        );
    }
}