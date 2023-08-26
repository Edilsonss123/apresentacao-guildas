<?php
namespace App\Services;

use App\Conectores\Geolocalizacao\OpenStreetMap;

class EnderecoService 
{
    private OpenStreetMap $openStreetMap; 
    public function __construct() 
    {
        $this->openStreetMap = new OpenStreetMap;
    }
    
    public function obterCoordenadasEndereco(string $endereco) : array
    {
        $geolocalizacao = $this->openStreetMap->recuperCoordenadasEndereco($endereco);

        return [
            "latitude" => $geolocalizacao->getLatitude(),
            "longitude" => $geolocalizacao->getLongitude(),
        ];
    }
}