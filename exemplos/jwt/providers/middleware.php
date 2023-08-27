<?php

use App\Middlewares\JwtMiddleware;

use function DI\create;
use function \DI\get;

return [
    // Bind an interface to an implementation
    JwtMiddleware::class => create(JwtMiddleware::class),
];