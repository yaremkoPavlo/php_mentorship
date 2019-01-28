<?php
/**
 * Created by PhpStorm.
 * User: Pavlo_Yaremko
 * Date: 11/22/2018
 * Time: 11:19 PM
 */

final class Singeltone
{
    private static $instance = null;
    private function __construct()
    {
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    public static function instance()
    {
        if (self::$instance === null) {
            self::$instance = new Singeltone;
        }
        return self::$instance;
    }
}