<?php

namespace App\Services\Interface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface IArquivoCampanha 
{
    public function salvarArquivosCampanha(int $idCampanha, array $arquivosCampanha);
    public function salvarArquivoCampanha(int $idCampanha, UploadedFile $arquivo);
    function deletarArquivosCampanha(int $idCampanha);    
}