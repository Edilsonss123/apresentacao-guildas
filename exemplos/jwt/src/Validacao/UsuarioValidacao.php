<?php
namespace App\Validacao;
use App\Validacao\Interface\IUsuarioValidacao;

class UsuarioValidacao extends AbstractValidacao implements IUsuarioValidacao
{
    protected function getCamposValidacao() : array
    {
        return [
            'login'             => 'required',
            'senha'             => 'required'
        ];
    }
}