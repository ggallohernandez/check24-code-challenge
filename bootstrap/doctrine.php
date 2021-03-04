<?php

// Create a simple "default" Doctrine ORM configuration for Annotations
$appEnv = getenv('APP_ENV'); $appEnv = !empty($appEnv) ? $appEnv : 'dev';
$isDevMode = $appEnv === 'dev';
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;
$config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
    array(__DIR__."/../src/Blog/Entity"),
    $isDevMode,
    $proxyDir,
    $cache,
    $useSimpleAnnotationReader
);

$dbName = getenv('APP_DB_NAME');  $dbName = !empty($dbName) ? $dbName : 'localdb';
$dbUser = getenv('APP_DB_USER');  $dbUser = !empty($dbUser) ? $dbUser : 'root';
$dbPass = getenv('APP_DB_PASS');  $dbPass = !empty($dbPass) ? $dbPass : 'root';
$dbHost = getenv('APP_DB_HOST');  $dbHost = !empty($dbHost) ? $dbHost : 'database';
$dbDriver = getenv('APP_DB_DRIVER');  $dbDriver = !empty($dbDriver) ? $dbDriver : 'pdo_mysql';

// database configuration parameters
$conn = array(
    'dbname' => $dbName,
    'user' => $dbUser,
    'password' => $dbPass,
    'host' => $dbHost,
    'driver' => $dbDriver,
);

// obtaining the entity manager
return \Doctrine\ORM\EntityManager::create($conn, $config);
