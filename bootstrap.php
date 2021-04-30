<?php
ini_set('display_errors', 1);

require_once 'vendor/autoload.php';
require_once 'utils.php';

use App\Container;

Container::set('client', new \App\Service\SimpleClient());

(new App\Router())->dispatch();
