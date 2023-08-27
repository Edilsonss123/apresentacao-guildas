<?php
namespace App\Models\IRepository;

interface IUsuarioRepository 
{  
    public function recuperarUsuarioPeloLogin($login);
}