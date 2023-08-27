<?php

namespace App\Services\Interface;

interface IUsuario 
{
    public function recuperarUsuario(string $login, string $senha);
    public function recuperarUsuarioPeloLogin(string $login);
}