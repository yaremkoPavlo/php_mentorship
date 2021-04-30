<?php


namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ErrorAPIController extends AbstractController
{
    public function indexAction(Request $request): Response
    {
        return new JsonResponse(['error' => 'Can\'t find result for this route'], $this->client::HTTP_NOT_FOUND);
    }

    public function errorAction(Request $request): Response
    {
        return new JsonResponse(['error' => 'The error occurrence'], $this->client::HTTP_ERROR);
    }
}