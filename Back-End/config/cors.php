<?php
return [
    'paths' => ['api/*'], // Permite todas as rotas que começam com 'api/'
    'allowed_methods' => ['*'], // Permite todos os métodos HTTP
    'allowed_origins' => ['*'], // Adicione sua URL do frontend
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'], // Permite todos os cabeçalhos
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,
];