<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;

require_once __DIR__ . '/bootstrap/app.php';

$container = include __DIR__ . '/bootstrap/container.php';
$em = $container->get('em');

return ConsoleRunner::createHelperSet($em);