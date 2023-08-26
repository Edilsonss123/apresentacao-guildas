<?php
namespace App\Conectores\Geolocalizacao;
use App\Conectores\Geolocalizacao\Interfaces\IMapaGeolocalizacao;
use App\ValueObject\Geolocalizacao;

class OpenStreetMap implements IMapaGeolocalizacao
{
    public function recuperCoordenadasEndereco(string $endereco) : Geolocalizacao
    {
        $geolocalizacao = new Geolocalizacao("Rua 1", 20, "Centro","", "Contagem", "MG", "Brasil", "39391-002", -39.9001, -180.00002);
        return $geolocalizacao;
    }
    
}
