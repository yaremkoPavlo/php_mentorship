<?php

namespace App;

use \Exception;

class Container
{
    /**
     * @var array<string,mixed>
     */
    private static $container = [];

    /**
     * @param string $name
     * @return mixed
     * @throws Exception
     */
    public static function get(string $name)
    {
        if (!array_key_exists($name, static::$container)) {
            throw new Exception("Can't find service '$name' in container. Please inject it first");
        }

        return static::$container[$name];
    }

    /**
     * @param string $name
     * @param mixed $service
     * @throws Exception
     */
    public static function set(string $name, $service)
    {
        if (array_key_exists($name, static::$container)) {
            throw new Exception("Service '$name' already injected. Please use different name.");
        }

        static::$container[$name] = $service;
    }
}