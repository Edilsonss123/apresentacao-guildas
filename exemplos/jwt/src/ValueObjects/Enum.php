<?php 

namespace App\ValueObjects;


/**
 *    class PrioridadePrestador extends Enum
 *    {
 *          const Maxima = 1;
 *          const Alta = 2;
 *          const Neutra = 3;
 *          const Baixa = 4;
 *          const MuitoBaixa = 5;
 *    }
 *
 *  Exemplo de uso
 *
 *     $maxima = PrioridadePrestador::Maxima                      // (int) 1
 *     PrioridadePrestador::isValidName('Maxima')                 // (bool) true
 *     PrioridadePrestador::isValidName('maxima', $strict = true) // (bool) false
 *     PrioridadePrestador::isValidValue(1)                       // (bool) true
 *     PrioridadePrestador::fromString('Maxima')                  // (int) 1
 *     PrioridadePrestador::toString(PrioridadePrestador::Maxima) // (string) "Maxima"
 *     PrioridadePrestador::toString(2)                           // (string) "Alta"
 **/

abstract class Enum
{
    private static $constCacheArray = NULL;

    public static function getConstants()
    {
        if (self::$constCacheArray == NULL) {
            self::$constCacheArray = [];
        }
        $calledClass = get_called_class();
        if (!array_key_exists($calledClass, self::$constCacheArray)) {
            $reflect = new \ReflectionClass($calledClass);
            self::$constCacheArray[$calledClass] = $reflect->getConstants();
        }
        return self::$constCacheArray[$calledClass];
    }

    public static function getNames()
    {
        return array_keys(self::getConstants());
    }

    public static function getValues()
    {
        return array_values(self::getConstants());
    }

    public static function isValidName($name, $strict = false)
    {
        $constants = self::getConstants();

        if ($strict) {
            return array_key_exists($name, $constants);
        }

        $keys = array_map('strtolower', array_keys($constants));
        return in_array(strtolower($name), $keys);
    }

    public static function isValidValue($value, $strict = true)
    {
        $values = array_values(self::getConstants());
        return in_array($value, $values, $strict);
    }

    public static function fromString($name)
    {
        if (self::isValidName($name, $strict = true)) {
            $constants = self::getConstants();
            return $constants[$name];
        }

        return false;
    }

    public static function toString($value)
    {
        if (self::isValidValue($value, $strict = true)) {
            return array_search($value, self::getConstants());
        }

        return false;
    }
}