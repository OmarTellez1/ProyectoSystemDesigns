<?php
// src/config/global.php

// Requerir el autoload de Composer
require_once __DIR__ . '/../../vendor/autoload.php';

// Definir la ruta raíz del proyecto
$rootPath = __DIR__ . '/../..';

// Cargar el archivo .env SOLO SI EXISTE (para el desarrollo local)
if (file_exists($rootPath . '/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable($rootPath);
    $dotenv->load();
}

// El resto de tu código funciona igual. En local leerá las variables del .env
// y en el pipeline leerá las variables definidas en phpunit.xml
define("DB_HOST", $_ENV['DB_HOST']);
define("DB_NAME", $_ENV['DB_NAME']);
define("DB_USERNAME", $_ENV['DB_USERNAME']);
define("DB_PASSWORD", $_ENV['DB_PASSWORD']);

define("DB_ENCODE", "utf8");
define("PRO_NOMBRE", "Proyecto System Designs");
