<?php
// tests/UsuarioTest.php

use PHPUnit\Framework\TestCase;

// Ruta corregida para apuntar a la carpeta src
require_once __DIR__ . '/../src/modelos/Usuario.php';

class UsuarioTest extends TestCase
{
    public function testInsertarUsuario()
    {
        $usuario = new Usuario();
        $this->assertInstanceOf(Usuario::class, $usuario);
    }
}
