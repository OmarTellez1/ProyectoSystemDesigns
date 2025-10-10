<?php

// Requerir el autoload de Composer para poder usar la librería
require_once __DIR__ . '/../vendor/autoload.php';

// Cargar las variables de entorno del archivo .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Ahora, tu código original funciona perfectamente, leyendo las variables
// que Dotenv acaba de cargar.
define("DB_HOST", $_ENV['DB_HOST']);
define("DB_NAME", $_ENV['DB_NAME']);
define("DB_USERNAME", $_ENV['DB_USERNAME']);
define("DB_PASSWORD", $_ENV['DB_PASSWORD']);

define("DB_ENCODE", "utf8");
define("PRO_NOMBRE", "Proyecto System Designs");
