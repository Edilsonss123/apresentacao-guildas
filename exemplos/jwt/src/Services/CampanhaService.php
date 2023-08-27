<?php

namespace App\Services;
use App\Exceptions\SistemaException;
use App\Services\Interface\IArquivoCampanha;
use App\Models\IRepository\ICampanhaRepository;
use App\Services\Interface\ICampanha;

class CampanhaService implements ICampanha
{
    private ICampanhaRepository $campanhaModel;
    private IArquivoCampanha $arquivoCampanhaService;

    public function __construct(IArquivoCampanha $arquivoCampanha, ICampanhaRepository $campanhaModel) 
    {
        $this->campanhaModel = $campanhaModel;
        $this->arquivoCampanhaService = $arquivoCampanha;
    }

    public function recuperarCampanhas()
    {
        $campanhas =  $this->campanhaModel->recuperarCampanhas();
        return $campanhas;
    }

    public function recuperarCampanhaPeloId(int $id)
    {
        $campanhas =  $this->campanhaModel->recuperarCampanhaPeloId($id);
        return $campanhas;
    }

    public function novaCampanha(array $dadosCampanha)
    {
        $campanha = $this->campanhaModel->create([
            "descricao" => $dadosCampanha["descricao"],
            "valorOrcamento" => $dadosCampanha["valorOrcamento"],
            "publicoAlvo" => $dadosCampanha["publicoAlvo"],
            "status" => $dadosCampanha["status"],
            "dataInicial" => $dadosCampanha["dataInicial"],
            "dataFinal" => $dadosCampanha["dataInicial"],
        ]);
        $this->salvarArquivo($campanha->id, $dadosCampanha["arquivoCampanha"]);

        return (object)$campanha->toArray();
    }

    public function atualizarCampanha(int $id, array $dadosCampanha)
    {
        $campanha = $this->campanhaModel->recuperarCampanhaPeloId($id);

        if (!$campanha) {
            throw new SistemaException("Campanha não localizada");
        }

        $campanha->update([
            "descricao" => $dadosCampanha["descricao"],
            "valorOrcamento" => $dadosCampanha["valorOrcamento"],
            "publicoAlvo" => $dadosCampanha["publicoAlvo"],
            "status" => $dadosCampanha["status"],
            "dataInicial" => $dadosCampanha["dataInicial"],
            "dataFinal" => $dadosCampanha["dataInicial"],
        ]);
        $this->salvarArquivo($campanha->id, $dadosCampanha["arquivoCampanha"]);

        $campanha->refresh();
        return (object)$campanha->toArray();
    }
    private function salvarArquivo(int $idCampanha, $arquivoCampanha)
    {
        $this->arquivoCampanhaService->deletarArquivosCampanha($idCampanha);

        if ($arquivoCampanha instanceof \Symfony\Component\HttpFoundation\File\UploadedFile) {
            $this->arquivoCampanhaService->salvarArquivoCampanha($idCampanha, $arquivoCampanha);
            return;
        }

        $this->arquivoCampanhaService->salvarArquivosCampanha($idCampanha, $arquivoCampanha);
    }

    public function deletarCampanha(int $id)
    {
        $campanha = $this->campanhaModel->recuperarCampanhaPeloId($id);
        if (!$campanha) {
            throw new SistemaException("Campanha não localizada");
        }
        return $campanha->delete();
    }
}