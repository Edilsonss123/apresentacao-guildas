<?php

namespace App\Conectores\Geolocalizacao\Interfaces;
use App\ValueObject\Geolocalizacao;

interface IMapaGeolocalizacao
{
    public function recuperCoordenadasEndereco(string $endereco) : Geolocalizacao;
}