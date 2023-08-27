<?php

namespace App\Services\Interface;
use App\Models\Usuario;

interface IJwtService 
{
    public function gerarToken(Usuario $usuario);
    public function validarToken(string $jwtToken, bool $tokenRefresh = false);
}