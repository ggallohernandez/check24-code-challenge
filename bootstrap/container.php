<?php

$container = new \Small\DI\Container();

$em = include __DIR__.'/doctrine.php';
$twig = include __DIR__.'/twig.php';
$env = function($key, $default = null) { $val = getenv($key); $val = !empty($val) ? $val : $default; return $val;}
$maxResults = $env('APP_MAX_RESULTS', 30);

$container->set(\Psr\Container\ContainerInterface::class, $container);
$container->set(\Doctrine\ORM\Mapping\Entity::class, $em);
$container->set(\Twig\Environment::class, $twig);
$container->set('em', $em);
$container->set('twig', $twig);
$container->set('env', $env);
$container->set('maxResults', $maxResults);

return $container;
