<?php

use App\Services\CampanhaService;
use App\Services\Interface\IArquivoCampanha;
use App\Services\JwtService;
use App\Services\Interface\IJwtService;
use App\Validacao\UsuarioValidacao;
use App\Validacao\Interface\IUsuarioValidacao;
use App\Models\Usuario;
use App\Services\UsuarioService;
use App\Services\Interface\IUsuario;
use App\Validacao\CampanhaValidacao;
use App\Validacao\Interface\ICampanhaValidacao;
use App\Services\ArquivoCampanhaService;
use App\Services\Interface\ICampanha;
use function DI\create;
use function \DI\get;

return [
    // Bind an interface to an implementation
    IArquivoCampanha::class => get(ArquivoCampanhaService::class),
    ICampanha::class => get(CampanhaService::class),
    IJwtService::class => get(JwtService::class),
    IUsuario::class => get(UsuarioService::class),
    
    ICampanhaValidacao::class => get(CampanhaValidacao::class),
    IUsuarioValidacao::class => get(UsuarioValidacao::class),

];