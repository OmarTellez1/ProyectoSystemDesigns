<?php

// tests/UsuarioTest.php

use PHPUnit\Framework\TestCase;

// RUTA CORREGIDA para la nueva estructura de la rama
require_once __DIR__ . '/../src/admin/modelos/Usuario.php';

class UsuarioTest extends TestCase
{
    public function testInsertarUsuario()
    {
        $usuario = new Usuario();
        $this->assertInstanceOf(Usuario::class, $usuario);
    }
}
