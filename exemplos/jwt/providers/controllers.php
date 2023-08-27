<?php

use App\Controllers\CampanhaController;
use App\Services\Interface\ICampanha;
use App\Services\Interface\IJwtService;
use App\Validacao\Interface\IUsuarioValidacao;
use App\Services\Interface\IUsuario;
use App\Controllers\JwtController;
use App\Validacao\Interface\ICampanhaValidacao;
use Illuminate\Database\Capsule\Manager as Capsule;

use function DI\create;
use function \DI\get;

return [
    // Bind an interface to an implementation
    CampanhaController::class => create(CampanhaController::class)->constructor(
        Capsule::schema()->getConnection(),
        get(ICampanha::class), get(ICampanhaValidacao::class)
    ),
    JwtController::class => create(JwtController::class)->constructor(
        get(IUsuario::class), get(IUsuarioValidacao::class), get(IJwtService::class)
    )
];