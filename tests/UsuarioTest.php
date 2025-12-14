<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/admin/modelos/Usuario.php';
class UsuarioTest extends TestCase
{
    public function testLaClaseUsuarioSePuedeInstanciar()
    {
        // Acción: Intentamos crear un objeto Usuario
        $usuario = new Usuario();
        // Aserción: Verificamos que $usuario sea efectivamente
        //  una instancia de la clase Usuario
        $this->assertInstanceOf(Usuario::class, $usuario);
    }
    public function testAtributosDelModelo()
    {
        $usuario = new Usuario();
        // Simulamos verificar si el objeto existe
        $this->assertIsObject($usuario, "La variable debería ser un objeto");

        // Verificamos que NO sea nulo
        $this->assertNotNull($usuario);
    }
}
