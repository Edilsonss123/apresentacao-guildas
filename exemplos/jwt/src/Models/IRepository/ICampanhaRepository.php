<?php
namespace App\Models\IRepository;

interface ICampanhaRepository 
{  
    public function arquivoCampanha();
    public function recuperarCampanhas();
    public function recuperarCampanhaPeloId($id);
}