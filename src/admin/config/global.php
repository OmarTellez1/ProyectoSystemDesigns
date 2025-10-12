<?php
// src/admin/config/global.php

// Requerir el autoload de Composer para poder usar las librerías
require_once __DIR__ . '/../../../vendor/autoload.php';

// Definir la ruta raíz del proyecto (subiendo tres niveles desde src/admin/config)
$rootPath = __DIR__ . '/../../..';

// Cargar el archivo .env SOLO SI EXISTE (para el desarrollo local)
if (file_exists($rootPath . '/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable($rootPath);
    $dotenv->load();
}

// Ahora, el código leerá las variables de $_ENV si el .env existe,
// o fallará de forma controlada si no están definidas.
define("DB_HOST", $_ENV['DB_HOST'] ?? null);
define("DB_NAME", $_ENV['DB_NAME'] ?? null);
define("DB_USERNAME", $_ENV['DB_USERNAME'] ?? null);
define("DB_PASSWORD", $_ENV['DB_PASSWORD'] ?? null);

define("DB_ENCODE", "utf8");
define("PRO_NOMBRE", "ITV");
