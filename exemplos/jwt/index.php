<?php

require_once __DIR__.'/vendor/autoload.php';

//Funcoes auxiliadoras
require_once __DIR__.'/src/Helper/Funcoes.php';

//.ENV
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

//ORM
$capsule = new Illuminate\Database\Capsule\Manager;
$capsule->addConnection([
    'driver' => 'mysql',
    'host' => $_ENV['DB_HOST'],
    'port' => $_ENV['DB_PORT'],
    'database' => $_ENV['DB_DATABASE'],
    'username' => $_ENV['DB_USERNAME'],
    'password' => $_ENV['DB_PASSWORD'],
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

//Injenção dependencia
$containerProvider = require_once __DIR__.'/providers/container.php';

//ROUTE
$router = require_once __DIR__.'/router/api.php';