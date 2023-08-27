<?php

namespace App\Services;
use App\Models\Usuario;
use App\Services\Interface\IJwtService;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtService implements IJwtService
{
    public function gerarToken(Usuario $usuario)
    {
        $key = $_ENV["JWT_CHAVE"];
        $tempoDuracaoToken = $_ENV["JWT_DURACAO_TOKEN_EM_SEGUNDOS"];
        $time = time();

        $payload = [
            'iss' => 'http://www.localhost:5020',
            'aud' => 'http://www.localhost:5020',
            'iat' => $time,
            'exp' => $time + $tempoDuracaoToken,
            'login' => $usuario->login
        ];
        $jwtToken = JWT::encode($payload, $key, 'HS256');

        $tempoDuracaoRefreshToken = $_ENV["JWT_DURACAO_REFRESH_TOKEN_EM_SEGUNDOS"];
        $key =  $_ENV["JWT_CHAVE_REFRESH"];
        $payload["exp"] =  $time + $tempoDuracaoRefreshToken;

        $refreshJwtToken = JWT::encode($payload, $key, 'HS256');
        return [
           "token" => $jwtToken,
           "refreshToken" => $refreshJwtToken,
        ]; 
    }

    public function validarToken(string $jwtToken, bool $tokenRefresh = false) 
    {
        $key = ($tokenRefresh ? $_ENV["JWT_DURACAO_REFRESH_TOKEN_EM_SEGUNDOS"] : $_ENV["JWT_CHAVE"]);
        $payloadDecode = JWT::decode($jwtToken, new Key($key, 'HS256'));
        return $payloadDecode;
    }
}