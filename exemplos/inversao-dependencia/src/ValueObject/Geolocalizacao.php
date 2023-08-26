<?php

namespace App\ValueObject;

class Geolocalizacao
{
    private string $logradouro;
    private string $numero;
    private string $bairro;
    private string $complemento;
    private string $cidade;
    private string $estado;
    private string $pais;
    private string $codigoPostal;
    private float $latitude;
    private float $longitude;

    public function __construct(
        string $logradouro, string $numero, string $bairro, string $complemento,
        string $cidade, string $estado, string $pais,
        string $codigoPostal, float $latitude, float $longitude
    ) {
        $this->logradouro = $logradouro;
        $this->numero = $numero;
        $this->bairro = $bairro;
        $this->complemento = $complemento;
        $this->cidade = $cidade;
        $this->estado = $estado;
        $this->pais = $pais;
        $this->codigoPostal = $codigoPostal;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function toArray() : array
    {
        return [
            "logradouro" => $this->logradouro,
            "numero" => $this->numero,
            "bairro" => $this->bairro,
            "complemento" => $this->complemento,
            "cidade" => $this->cidade,
            "estado" => $this->estado,
            "pais" => $this->pais,
            "codigoPostal" => $this->codigoPostal,
            "latitude" => $this->latitude,
            "longitude" => $this->longitude,
        ];
    }

    public function toString() 
    {
        return implode(", ", $this->toArray());
    }

    public function getLogradouro() : string
    {
        return $this->logradouro;
    }
    public function getNumero() : string
    {
        return $this->numero;
    }
    public function getBairro() : string
    {
        return $this->bairro;
    }
    public function getComplemento() : string
    {
        return $this->complemento;
    }
    public function getCidade() : string
    {
        return $this->cidade;
    }
    public function getEstado() : string
    {
        return $this->estado;
    }
    public function getPais() : string
    {
        return $this->pais;
    }
    public function getCodigoPostal() : string
    {
        return $this->codigoPostal;
    }
    public function getLatitude() : float
    {
        return $this->latitude;
    }
    public function getLongitude() : float
    {
        return $this->longitude;
    }
}