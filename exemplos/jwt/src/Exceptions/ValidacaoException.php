<?php
namespace App\Exceptions;
use Exception;
use Throwable;
use Symfony\Component\HttpFoundation\Response;

class ValidacaoException extends Exception
{
    private $camposInvalidos = [];
    public function __construct($message, array $camposInvalidos, $code = Response::HTTP_BAD_REQUEST, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
        $this->camposInvalidos = $camposInvalidos;
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

    function getCamposInvalidos() : array
    {
        return $this->camposInvalidos;    
    }
}