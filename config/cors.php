<?php

// config/cors.php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie', '/user-count', '/post-count', '/pending-users', '/users'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['http://localhost:3000'],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,
];
