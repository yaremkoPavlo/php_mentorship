<?php

ini_set('display_errors', 1);
session_start();

require_once 'vendor/autoload.php';

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$isDevMode = true;
$paths = array(__DIR__ . "/src/Entity");
$dbParams = require_once 'dbparams.php';

$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode, null, null, false);
$entityManager = EntityManager::create($dbParams, $config);

App\Container::set('entityManager', $entityManager);

// Simple authorization, just login input
if (!isset($_SESSION['logged_user']) && isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] !== '/login.php') {
    header('Location: /login.php');
}
