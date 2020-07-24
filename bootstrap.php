<?php

define('BASE_DIR', realpath(__DIR__));

require_once BASE_DIR . '/vendor/autoload.php';

Dotenv\Dotenv::createImmutable(BASE_DIR, $env_file ?? '.env')->load();