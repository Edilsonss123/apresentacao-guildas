<?php

namespace App\Services\Interface;

interface ICampanha 
{
    public function recuperarCampanhas();
    public function recuperarCampanhaPeloId(int $id);
    public function novaCampanha(array $dadosCampanha);
    public function atualizarCampanha(int $id, array $dadosCampanha);
    public function deletarCampanha(int $id);
}