<?php

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../templates');
$twig = new \Twig\Environment($loader, [
    'cache' => __DIR__ . '/../bootstrap/cache/twig',
]);

return new \Twig\Environment($loader);