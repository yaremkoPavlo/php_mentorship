<?php

use App\SortAlgorithms\BubbleSort;
use App\SortAlgorithms\QuickSort;

require 'utils.php';
require 'vendor/autoload.php';

$testArray1 = [2, 99, 4, 18, 6, 8, 5, -3, 17, -5];
$testArray2 = [-2, 4, 6, 8, 9, 13, 15, 17, 25, 26];
$testArray3 = [1, 1, 1, 1, 1, 1, 1, 1, 1, 1];

$q = new QuickSort();
$b = new BubbleSort;

echo('QuickSort:' . PHP_EOL);

echoArray($q->sort($testArray1));
$q->echoItterations();

echoArray($q->sort($testArray2));
$q->echoItterations();

echoArray($q->sort($testArray3));
$q->echoItterations();

echo('BubbleSort:' . PHP_EOL);

echoArray($b->sort($testArray1));
$b->echoItterations();

echoArray($b->sort($testArray2));
$b->echoItterations();

echoArray($b->sort($testArray3));
$b->echoItterations();