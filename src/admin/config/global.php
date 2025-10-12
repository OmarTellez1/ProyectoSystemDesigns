<?php
/*//ip de la pc servidor base de datos
define("DB_HOST", "localhost");

// nombre de la base de datos
define("DB_NAME", "control_asistencia");


//nombre de usuario de base de datos
define("DB_USERNAME", "root");
//define("DB_USERNAME", "u222417_admin");

//conraseña del usuario de base de datos
define("DB_PASSWORD", "");
//define("DB_PASSWORD", "Enero2020Admin");

//codificacion de caracteres
define("DB_ENCODE", "utf8");

//nombre del proyecto
define("PRO_NOMBRE", "CompartiendoCodigos");*/
 

// src/config/global.php

// Requerir el autoload de Composer
require_once __DIR__ . '/../../../vendor/autoload.php'; 

// Definir la ruta raíz del proyecto
$rootPath = __DIR__ . '/../../../..';


// Cargar el archivo .env SOLO SI EXISTE (para el desarrollo local)
if (file_exists($rootPath . '/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable($rootPath);
    $dotenv->load();
}

function env(string $key, $default = null) {
    if (isset($_ENV[$key])) {
        return $_ENV[$key];
    }
    $value = getenv($key);
    return $value !== false ? $value : $default;
}
// El resto de tu código funciona igual. En local leerá las variables del .env
// y en el pipeline leerá las variables definidas en phpunit.xml
define("DB_HOST", $_ENV['DB_HOST']);
define("DB_NAME", $_ENV['DB_NAME']);
define("DB_USERNAME", $_ENV['DB_USERNAME']);
define("DB_PASSWORD", $_ENV['DB_PASSWORD']);

define("DB_ENCODE", "utf8");
define("PRO_NOMBRE", "Proyecto System Designs");


?>
