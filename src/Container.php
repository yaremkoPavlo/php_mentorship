<?php

namespace App;

use App\Service\AbstractService;
use Psr\Container\ContainerInterface;

/**
 * @final
 */
class Container implements ContainerInterface
{
    /**
     * @var array<string,AbstractService>
     */
    private static $container = [];

    /**
     * @var Container|null
     */
    private static $instance;

    private function __construct()
    {
    }

    /**
     * @return Container
     */
    public static function create()
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * @param string $id
     * @return AbstractService
     * @throws \Exception
     */
    public function get(string $id): AbstractService
    {
        if (!$this->has($id)) {
            throw new \Exception("Can't find service '$id' in container. Please inject it first");
        }

        return static::$container[$id];
    }

    /**
     * @param string $name
     * @param AbstractService $service
     * @throws \Exception
     */
    public function set(string $name, AbstractService $service)
    {
        if ($this->has($name)) {
            throw new \Exception("Service '$name' already injected. Please use different name.");
        }

        static::$container[$name] = $service;
    }

    /**
     * @param string $id
     * @return bool
     */
    public function has(string $id)
    {
        return \array_key_exists($id, static::$container);
    }
}
