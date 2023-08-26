<?php

namespace App\Controllers;
use App\Services\EnderecoService;
class EnderecoController
{
    private EnderecoService $enderecoService; 
    public function __construct() {
        $this->enderecoService = new EnderecoService;
    }
    
    public function obterCoordenadasEndereco(string $endereco) : array
    {
        $geolocalizacao = $this->enderecoService->obterCoordenadasEndereco($endereco);

        return $geolocalizacao;
    }
}