<?php
namespace App\Exceptions;
use Exception;
use Throwable;
use Symfony\Component\HttpFoundation\Response;

class SistemaException extends Exception
{
    public function __construct($message, $code = Response::HTTP_BAD_REQUEST, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}