<?php

namespace App\Services;
use App\Services\Interface\IArquivoCampanha;
use App\Models\IRepository\IArquivoCampanhaRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ArquivoCampanhaService implements IArquivoCampanha
{
    private IArquivoCampanhaRepository $arquivoCampanhaModel;

    public function __construct(IArquivoCampanhaRepository $arquivoCampanhaModel) 
    {
        $this->arquivoCampanhaModel = $arquivoCampanhaModel;
    }
    
    public function salvarArquivosCampanha(int $idCampanha, array $arquivosCampanha)
    {
        foreach ($arquivosCampanha as $arquivo) {
            $this->salvarArquivoCampanha($idCampanha, $arquivo);
        }
    }

    public function salvarArquivoCampanha(int $idCampanha, UploadedFile $arquivo) 
    {
        $nomeArquivo = "arquivo-".uniqid($idCampanha)."." . $arquivo->getClientOriginalExtension();
        $caminhoArquivo = $_ENV["PATH_LOCAL_ARQUIVOS"]."campanha";

        $campanha = $this->arquivoCampanhaModel->create([
            "idCampanha" => $idCampanha,
            "descricaoArquivo" => $arquivo->getClientOriginalName(),
            "nomeArquivo" => $nomeArquivo,
            "caminhoArquivo" => $caminhoArquivo
        ]);
        
        $arquivo->move($caminhoArquivo, $nomeArquivo);

        return (object)$campanha->toArray();
    }

    function deletarArquivosCampanha(int $idCampanha)
    {
        $arquivosCampanha = $this->arquivoCampanhaModel->recuperarArquivosCampanha($idCampanha);
        foreach ($arquivosCampanha as $arquivo) {
            $this->deletarArquivo($arquivo);
        }
    }

    private function deletarArquivo(IArquivoCampanhaRepository $arquivo)
    {
        $caminhoArquivoCompleto = "{$arquivo->caminhoArquivo}/{$arquivo->nomeArquivo}";
        if(file_exists($caminhoArquivoCompleto)) {
            unlink($caminhoArquivoCompleto);
        }
        $arquivo->delete();
    }
    
}