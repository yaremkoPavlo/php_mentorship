<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ErrorController extends AbstractController
{
    public function indexAction(Request $request): Response
    {
        return new Response('Can\'t find result for this route', $this->client::HTTP_NOT_FOUND);
    }

    public function errorAction(Request $request): Response
    {
        return new Response('The error occurrence', $this->client::HTTP_ERROR);
    }
}