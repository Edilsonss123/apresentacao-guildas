<?php
namespace App\Models\IRepository;

interface IArquivoCampanhaRepository 
{  
    public function campanha();
    public function recuperarArquivosCampanha(int $idCampanha);
}