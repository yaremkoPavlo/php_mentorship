<?php

namespace App;

use App\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Router is a simple implementation of FrontController. All Controllers public methods should return \Symfony\Component\HttpFoundation\Response.
 * The main \App\Router::dispatch() method return Symfony\Component\HttpFoundation\Response as a result of each Controllers call
 * @package App
 */
class Router
{
    /**
     * @var array
     */
    private $routes;
    /**
     * @var Request
     */
    private $request;

    public function __construct()
    {
        $this->routes = require_once __DIR__ . '/routes.php';
        $this->request = Request::createFromGlobals();
    }

    /**
     * @param string|null $requestedUrl
     * @return Response
     */
    public function dispatch(?string $requestedUrl = null): Response
    {
        $request = Request::createFromGlobals();

        if ($requestedUrl === null) {
            // ignore query params
            $uri = \explode('?', $request->server->get('REQUEST_URI'))[0];
            $requestedUrl = \urldecode(\rtrim($uri, '/'));
        }

        if (isset($this->routes[$requestedUrl])) {
            list($controllerName, $actionName, $params) = $this->splitControllerParams($this->routes[$requestedUrl]);
        } else {
            $controllerName = '';
            $actionName = '';
            $params = [];
            foreach ($this->routes as $route => $uri) {
                // route => 'api/images/{%id%}'; $uri => 'APIController/imageAction/$1'

                if (strpos($route, '{%id%}') !== false) {
                    $route = str_replace('{%id%}', '(.+)', $route);
                }

                if (preg_match('#^' . $route . '$#', $requestedUrl)) {
                    // replace $\d+ patterns params, to sent part of url to Controller as a parameter
                    if (strpos($uri, '$') !== false && strpos($route, '(') !== false) {
                        $uri = preg_replace('#^' . $route . '$#', $uri, $requestedUrl);
                    }
                    list($controllerName, $actionName, $params) = $this->splitControllerParams($uri);
                    break;
                }
            }
        }

        return $this->callControllerAction($controllerName, $actionName, $params)->send();
    }

    /**
     * @param string $subject
     * @return array
     */
    private function splitControllerParams(string $subject): array
    {
        $params = [];
        $arr = preg_split('/\//', $subject, -1, PREG_SPLIT_NO_EMPTY);
        $controllerName = 'App\\Controllers\\' . ucfirst(array_shift($arr)) . 'Controller';
        $actionName = array_shift($arr) ?? '';

        if ($arr !== false) {
            $params = $arr;
        }

        return [$controllerName, $actionName, $params];
    }

    /**
     * @param string $controllerName
     * @param string $actionName
     * @param $params
     * @return Response
     */
    private function callControllerAction(string $controllerName, string $actionName, $params): Response
    {
        if (class_exists($controllerName)) {
            $cc = new $controllerName();
        } else {
            // throw new \InvalidArgumentException('Can\'t find controller for this route');
            $cc = new Controller\ErrorController();

            $actionName = 'indexAction';
        }

        try {
            if (!method_exists($cc, $actionName)) {
                throw new \BadMethodCallException('Can\'t find action in controller for this route');
            }
        } catch (\BadMethodCallException $exception) {
            // TODO: add error logging
            $cc = new Controller\ErrorController();
            $actionName = 'errorAction';
        }

        return call_user_func([$cc, $actionName], $this->request, $params);
    }
}