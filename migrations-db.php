<?php

require __DIR__ . '/bootstrap.php';

return [
    'dbname' => $_ENV['DB_NAME'],
    'user' => 'root',
    'password' => $_ENV['DB_ROOT_PASSWORD'],
    'host' => $_ENV['DB_HOST'],
    'driver' => 'pdo_mysql',
];
