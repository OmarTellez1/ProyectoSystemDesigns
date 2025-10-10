// tests/UsuarioTest.php
<?php
use PHPUnit\Framework\TestCase;

// Incluimos la clase que vamos a probar
require_once __DIR__ . '/../modelos/Usuario.php';

class UsuarioTest extends TestCase
{
    public function testInsertarUsuario()
    {
        // Creamos una instancia de la clase Usuario
        $usuario = new Usuario();

        // Verificamos que la instancia se haya creado correctamente
        $this->assertInstanceOf(Usuario::class, $usuario);

        // Aquí podrías agregar una prueba real que inserte un usuario
        // y verifique que se haya guardado en la base de datos de prueba.
        // Por ahora, esta simple verificación es suficiente para empezar.
    }
}
