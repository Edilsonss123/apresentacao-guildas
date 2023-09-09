<?php

/* 
use DI\ContainerBuilder;
use function DI\create;
use function \DI\get;

$containerBuilder = new ContainerBuilder;
$containerBuilder->addDefinitions([
    IExemplo::class => create(ExemploService::class)->construct(...),
]);

$containerProvider = $containerBuilder->build();

return $containerProvider; 

//Injenção dependencia
$containerProvider = require_once __DIR__.'/providers/container.php';

https://php-di.org/doc/getting-started.html
*/