<?php

require_once 'bootstrap.php';

use Doctrine\ORM\Tools\Console\ConsoleRunner;

return ConsoleRunner::createHelperSet(App\Container::get('entityManager'));