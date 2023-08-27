<?php
namespace App\Validacao\Rules;

use Rakit\Validation\Rule;
use Illuminate\Database\Capsule\Manager as Capsule;

class UniqueRule extends Rule
{
    protected $message = "Já possui uma :attribute cadastrada com o valor ':value'";

    protected $fillableParams = ["table", "column", "where"];


    public function check($value): bool
    {
        // make sure required parameters exists
        $this->requireParameters(["table", "column"]);

        // getting parameters
        $column = $this->parameter("column");
        $table = $this->parameter("table");
        $where = $this->parameter("where");
        // do query
        $total = Capsule::schema()->getConnection()
        ->table($table)
        ->where($column, trim($value))
        ->whereNull("deleted_at")
        ->when($where, function($q) use ($where) {
            $q->whereRaw($where);
        })
        ->count();
        // true for valid, false for invalid
        return intval($total) === 0;
    }
}