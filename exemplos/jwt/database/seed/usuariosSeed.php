<?php
include_once __DIR__.'/../../index.php';

use Illuminate\Database\Capsule\Manager as Capsule;
$db = Capsule::schema()->getConnection();

$db->table("usuario")->truncate();
for ($i=1; $i <= 5; $i++) { 
    $senha = "123456{$i}";
    $db->table("usuario")->insert([
        "nome"          => "Teste {$i}",
        "login"         => "user-teste@{$i}",
        "senha"         => md5($senha)
    ]);
}