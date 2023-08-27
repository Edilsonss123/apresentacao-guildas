<?php
namespace App\Validacao\Rules;

use Rakit\Validation\Rule;
use Illuminate\Database\Capsule\Manager as Capsule;

class ValidDateRule extends Rule
{
    protected $message = ":attribute é inválida ':value'";

    protected $fillableParams = ["campoDataMinina", "campoDataMaxima"];


    public function check($date): bool
    {
        if (!$this->validateDate($date)) {
            return false;
        }
        if (strtotime($date) < strtotime(date('Y-m-d H:i:s'))) {
            $this->message = "A :attribute não pode ser um período no passado";
            return false;
        }
        
        // getting parameters
        $campoDataMinina = $this->validation->getValue($this->parameter("campoDataMinina"));
        $campoDataMaxima = $this->validation->getValue($this->parameter("campoDataMaxima"));
        $campoDataMinina = $this->validateDate($campoDataMinina) ? $campoDataMinina: date('Y-m-d H:i:s');

        if (strtotime($date) < strtotime($campoDataMinina)) {
            $this->message = "A :attribute não pode ser inferior a '{$campoDataMinina}' informada em '{$this->parameter("campoDataMinina")}'";
            return false;
        }
        if ($this->validateDate($campoDataMaxima) && strtotime($date) > strtotime($campoDataMaxima)) {
            $this->message = "A :attribute não pode ser superior a data '{$campoDataMaxima}' informada em '{$this->parameter("campoDataMaxima")}'";
            return false;
        }

        return true;

    }
    function validateDate($date, $format = 'Y-m-d H:i:s')
    {
        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
}