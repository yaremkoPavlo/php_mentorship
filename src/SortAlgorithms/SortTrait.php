<?php

namespace App\SortAlgorithms;

trait SortTrait
{
    /**
     * @var int $itterations
     */
    private static $itterations = 0;

    public function echoItterations()
    {
        echo ('Total itterations: ' . self::$itterations . PHP_EOL);
    }
}
