<?php 

use App\Controllers\EnderecoController;
use Buki\Router\Router;
use Router\CustomRouter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$router = new Router([
    'paths' => [
        'controllers' => 'src/Controllers'
    ],
    'namespaces' => [
        'controllers' => 'App\Controllers'
    ],
]);


$router->group("", function($router) {
    $router->get("teste", function() {
        echo "teste";
    });
    $router->group("endereco", function($router) {
        $router->get("coordenadas/:all", [EnderecoController::class, "obterCoordenadasEndereco"]);
    });
});

$router->notFound(function(Request $request, Response $response) {
    return $response->setContent("A rota solicitada não existe!");
});

$router->error(function(Request $request, Response $response, $e) {
    return $response->setContent("Não foi possível processar a requisição");
});

$router->run();
