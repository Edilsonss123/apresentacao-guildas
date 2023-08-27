<?php
include_once __DIR__.'/../../index.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use App\ValueObjects\StatusCampanha;

$status = StatusCampanha::getConstants();
sort($status);

$db = Capsule::schema()->getConnection();
$db->statement("SET FOREIGN_KEY_CHECKS = 0");
$db->table("campanha")->truncate();
$campanhaInativas = 0;
for ($i=1; $i <= 10; $i++) { 
    $campanha = [
        "descricao"         => "Campanha {$i}",
        "valorOrcamento"    => rand(0, rand(100, 900)),
        "publicoAlvo"       => "Grupo {$i}",
        "status"            => $status[rand(0,4)],
        "dataInicial"       => date("Y-m-d H:m:s", time() - rand(10, 1000)),
        "dataFinal"         => date("Y-m-d H:m:s", time() + rand(50, 150)),
    ];
    if ($campanhaInativas < 3 &&  $i%2 == 0) {
        $campanha["deleted_at"] = date("Y-m-d H:m:s", time() + rand(20, 40));
        $campanhaInativas++;
    }
    $db->table("campanha")->insert($campanha);
}
$db->statement("SET FOREIGN_KEY_CHECKS = 1");

