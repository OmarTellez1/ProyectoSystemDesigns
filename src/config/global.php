<?php
// src/config/global.php

// Ruta corregida para subir dos niveles y encontrar la carpeta vendor
require_once __DIR__ . '/../../vendor/autoload.php';

// Ruta corregida para subir dos niveles y encontrar el archivo .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv->load();

define("DB_HOST", $_ENV['DB_HOST']);
define("DB_NAME", $_ENV['DB_NAME']);
define("DB_USERNAME", $_ENV['DB_USERNAME']);
define("DB_PASSWORD", $_ENV['DB_PASSWORD']);

define("DB_ENCODE", "utf8");
define("PRO_NOMBRE", "Proyecto System Designs");
