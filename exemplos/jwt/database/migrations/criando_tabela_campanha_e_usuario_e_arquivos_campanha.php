<?php
include_once __DIR__.'/../../index.php';
use App\ValueObjects\StatusCampanha;
use Illuminate\Database\Capsule\Manager as Capsule;

if (!Capsule::schema()->hasTable('campanha')) {
    Capsule::schema()->create('campanha', function ($table) {
        $table->increments('id');
        $table->string('descricao');
        $table->unsignedDecimal('valorOrcamento');
        $table->string('publicoAlvo');
        $table->enum('status', StatusCampanha::getConstants());
        $table->dateTime('dataInicial')->nullable()->default(null);
        $table->dateTime('dataFinal')->nullable()->default(null);
        $table->dateTime('created_at')->useCurrent();
        $table->softDeletes();
    });
}

if (!Capsule::schema()->hasTable('arquivo_campanha')) {
    Capsule::schema()->create('arquivo_campanha', function ($table) {
        $table->increments('id');
        $table->unsignedInteger('idCampanha');
        $table->string('descricaoArquivo');
        $table->string('nomeArquivo');
        $table->string('caminhoArquivo');
        $table->dateTime('created_at')->useCurrent();
        $table->softDeletes();
        $table->foreign('idCampanha')->references('id')->on('campanha');
    });
}


if (!Capsule::schema()->hasTable('usuario')) {
    Capsule::schema()->create('usuario', function ($table) {
        $table->increments('id');
        $table->string('nome');
        $table->string('login')->unique();
        $table->string('senha');
        $table->dateTime('created_at')->useCurrent();
        $table->softDeletes();
    });
}