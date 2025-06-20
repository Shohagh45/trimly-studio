<?php
require_once __DIR__ . '/vendor/autoload.php';

use Middleware\AuthMiddleware;

header('Content-Type: application/json');
print_r(AuthMiddleware::requireAuth());
