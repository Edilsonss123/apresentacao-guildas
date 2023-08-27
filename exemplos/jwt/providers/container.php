<?php
/**
 * The bootstrap file creates and returns the container.
 */

use DI\ContainerBuilder;

$containerBuilder = new ContainerBuilder;
$containerBuilder->addDefinitions(__DIR__ . '/services.php');
$containerBuilder->addDefinitions(__DIR__ . '/middleware.php');
$containerBuilder->addDefinitions(__DIR__ . '/controllers.php');
$containerBuilder->addDefinitions(__DIR__ . '/repository.php');

$containerProvider = $containerBuilder->build();
return $containerProvider;