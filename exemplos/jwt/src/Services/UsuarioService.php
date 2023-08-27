<?php

namespace App\Services;
use App\Exceptions\SistemaException;
use App\Models\Usuario;
use App\Services\Interface\IUsuario;
use Symfony\Component\HttpFoundation\Response;

class UsuarioService implements IUsuario
{
    private Usuario $usuarioModel;

    public function __construct(Usuario $usuarioModel) 
    {
        $this->usuarioModel = $usuarioModel;
    }

    public function recuperarUsuario(string $login, string $senha)
    {
        $usuario = $this->usuarioModel->recuperarUsuarioPeloLogin($login);
        if (!$usuario || md5($senha) !== $usuario->senha) {
            throw new SistemaException("Usuário não localizado", Response::HTTP_UNAUTHORIZED);
        }
        return $usuario; 
    }
    public function recuperarUsuarioPeloLogin(string $login)
    {
        $usuario = $this->usuarioModel->recuperarUsuarioPeloLogin($login);
        if (!$usuario) {
            throw new SistemaException("Usuário não localizado", Response::HTTP_UNAUTHORIZED);
        }
        return $usuario; 
    }
}