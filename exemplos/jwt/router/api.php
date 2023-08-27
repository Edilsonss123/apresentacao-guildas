<?php 

use App\Middlewares\JwtMiddleware;
use App\Response\ResponseJson;
use Router\CustomRouter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$router = new CustomRouter([
    'paths' => [
        'controllers' => 'src/Controllers',
        'middlewares' => 'src/Middlewares',
    ],
    'namespaces' => [
        'controllers' => 'App\Controllers',
        'middlewares' => 'App\Middlewares',
    ],
]);


$router->group('api', function($router) {
    $router->group('autenticacao', function($router) {
        $router->group('token', function($router) {
            $router->post('', 'JwtController@gerarToken');
            $router->post('atualizar', 'JwtController@atualizarToken');
        });
    });
    $router->group('', function($router) {
        $router->group('campanha', function($router) {
            
            $router->get('', 'CampanhaController@recuperarCampanhas');
            $router->get(':id', 'CampanhaController@recuperarCampanhaPeloId');
            $router->post('', 'CampanhaController@novaCampanha');
            $router->post(':id', 'CampanhaController@atualizarCampanha');
            $router->delete(':id', 'CampanhaController@deletarCampanha');
        });
    }, ['before' => JwtMiddleware::class]);
});

$router->notFound(function(Request $request, Response $response) {
    return (new ResponseJson)->json([
        "message" => "A rota solicitada não existe!",
    ], Response::HTTP_NOT_FOUND);
});

$router->error(function(Request $request, Response $response, $e) {
    return (new ResponseJson)->json([
        "message" => "Não foi possível processar a requisição",
    ], Response::HTTP_INTERNAL_SERVER_ERROR);
});

$router->run();
