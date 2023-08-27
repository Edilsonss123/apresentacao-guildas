<?php

use App\Models\IRepository\IArquivoCampanhaRepository;
use App\Models\ArquivoCampanha;
use App\Models\IRepository\IUsuarioRepository;
use App\Models\Usuario;
use App\Models\IRepository\ICampanhaRepository;
use App\Models\Campanha;
use function DI\create;
use function \DI\get;

return [
    // Bind an interface to an implementation
    IArquivoCampanhaRepository::class => get(ArquivoCampanha::class),
    ICampanhaRepository::class => get(Campanha::class),
    IUsuarioRepository::class => get(Usuario::class),

];