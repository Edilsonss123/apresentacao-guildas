<?php
namespace App\Validacao;
use App\Validacao\Interface\ICampanhaValidacao;
use App\ValueObjects\StatusCampanha;

class CampanhaValidacao extends AbstractValidacao implements ICampanhaValidacao
{
    protected function getCamposValidacao() : array
    {
        $statusCampanha = implode(",", StatusCampanha::getConstants());
        $id = isset($this->dataValidacao["id"]) ? $this->dataValidacao["id"]: null;

        return [
            "descricao"             => "required|unique:campanha,descricao" . ($id ? ",id != {$id}": ""),
            "valorOrcamento"        => "required|numeric|min:0",
            "publicoAlvo"           => "required",
            "dataInicial"           => "required|date:Y-m-d H:m:s|validDate:null,dataFinal",
            "dataFinal"             => "required|date:Y-m-d H:m:s|validDate:dataInicial,null",
            "status"                => "required|in:{$statusCampanha}",
            "arquivoCampanha"       => 'required_without:arquivoCampanha.*|validUploadFile',
            "arquivoCampanha.*"     => 'required_without:arquivoCampanha|validUploadFile',
        ];
    }
}