<?php
namespace App\Validacao;

use App\Exceptions\ValidacaoException;
use App\Validacao\Interface\IValidacao;
use App\Validacao\Rules\ValidDateRule;
use App\Validacao\Rules\ValidUploadFileRule;
use Rakit\Validation\Validator;
use Symfony\Component\HttpFoundation\Response;
use App\Validacao\Rules\UniqueRule;

abstract class AbstractValidacao implements IValidacao
{
    protected $validator;
    protected $dataValidacao = [];
    public function __construct() 
    {
        $this->validator = new Validator;
        $this->validator->addValidator("unique", new UniqueRule);
        $this->validator->addValidator("validDate", new ValidDateRule);
        $this->validator->addValidator("validUploadFile", new ValidUploadFileRule);
        
        $this->validator->setTranslations([
            'and' => 'e',
            'or' => 'ou'
        ]);
    }
    protected abstract function  getCamposValidacao() : array;
    protected function  getMensagensValidacao() : array
    {
        return [
            "required" => "O :attribute é obrigatório",
            "required_without" => "O :attribute é obrigatório",
	        "date" => "O :attribute não tem formato de data válido 'Y-m-d H:m:s'",
	        "in" => "O :attribute permite apenas :allowed_values",
	        "numeric" => "O :attribute deve ser numérico",
	        "min" => "O valor mínimo para :attribute é 0",
        ];
    }
    
    public function validar($dadosRequisicao) 
    {
        $this->dataValidacao = $dadosRequisicao;
        $validation = $this->validator->validate($dadosRequisicao, $this->getCamposValidacao(), $this->getMensagensValidacao());
        if ($validation->fails()) {
            $errors = $validation->errors()->firstOfAll();
            throw new ValidacaoException("Dados inválidos", $errors, Response::HTTP_BAD_REQUEST);
        }
    }
}