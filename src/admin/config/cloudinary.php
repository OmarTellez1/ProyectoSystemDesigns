<?php
// src/admin/config/cloudinary.php

require_once __DIR__ . '/../../../vendor/autoload.php';

use Cloudinary\Configuration\Configuration;
use Dotenv\Dotenv;

// 1. Cargar variables de entorno del archivo .env (Si estamos en local)
// Buscamos 3 carpetas atrás para llegar a la raíz donde está el .env
try {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../../../');
    $dotenv->safeLoad();
} catch (Exception $e) {
    // Si falla (por ejemplo en producción real a veces no hay .env físico), no detenemos el script
}

// 2. Configurar Cloudinary usando las variables de entorno ($_ENV)
Configuration::instance([
    'cloud' => [
        'cloud_name' => $_ENV['CLOUDINARY_CLOUD_NAME'] ?? getenv('CLOUDINARY_CLOUD_NAME'),
        'api_key' => $_ENV['CLOUDINARY_API_KEY'] ?? getenv('CLOUDINARY_API_KEY'),
        'api_secret' => $_ENV['CLOUDINARY_API_SECRET'] ?? getenv('CLOUDINARY_API_SECRET')
    ],
    'url' => [
        'secure' => true
    ]
]);
?>