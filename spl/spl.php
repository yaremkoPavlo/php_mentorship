<?php
ini_set('display_errors',1);
error_reporting (E_ALL);

include "Collection.php";

$a = new Collection();

$a[0] = "value";
$a[1] = "value2";
$a[8] = "value3";

echo $a[0], PHP_EOL;

echo $a(), PHP_EOL;

echo json_encode($a, JSON_FORCE_OBJECT), PHP_EOL;

foreach ($a as $key => $val) {
    echo $val, PHP_EOL;
}

echo count($a), PHP_EOL;
