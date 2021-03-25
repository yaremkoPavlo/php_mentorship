<?php
ini_set('display_errors', 1);

require_once 'vendor/autoload.php';
require_once 'Container.php';

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$isDevMode = true;
$paths = [__DIR__ . "/src/DBBase"];
$dbParams = require_once 'dbparams.php';

$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
$entityManager = EntityManager::create($dbParams, $config);

Container::set('entityManager', $entityManager);