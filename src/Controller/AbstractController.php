<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractController
{
    /**
     * @var \App\Container|null
     */
    protected $container;

    public function __construct() {
        $this->container = \App\Container::create();
    }

    abstract public function indexAction(Request $request): Response;

    abstract public function errorAction(Request $request): Response;
}