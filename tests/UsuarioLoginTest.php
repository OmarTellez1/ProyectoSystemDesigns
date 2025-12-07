<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/admin/modelos/Usuario.php';
require_once __DIR__ . '/../src/admin/config/global.php';

class UsuarioLoginTest extends TestCase
{
    protected function setUp(): void
    {
        global $conexion;
        if (!isset($conexion) || $conexion === null) {
            $conexion = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
            if (mysqli_connect_errno()) {
                $this->fail("Fallo conexión BD: " . mysqli_connect_error());
            }
            $conexion->query('SET NAMES "' . DB_ENCODE . '"');
        }
    }
    // Caso de Uso: Login - Escenario Exitoso
    public function testVerificarCredencialesCorrectasDevuelveDatos()
    {
        // 1. Preparación
        $usuario = new Usuario();
        $loginCorrecto = 'admin';
        $claveCorrecta = hash('sha256', 'admin');

        // 2. Ejecución (Llamamos al método del backend)
        $resultado = $usuario->verificar($loginCorrecto, $claveCorrecta);

        // 3. Verificación
        // a) Que no sea null (la consulta corrió)
        $this->assertNotNull($resultado, "La consulta falló.");

        // b) Que haya encontrado al menos 1 fila (num_rows > 0)
        // Esto confirma que el usuario y clave coinciden en la BD
        $this->assertGreaterThan(
            0,
            $resultado->num_rows,
            "No se encontró el usuario 'admin' con esa contraseña."
        );
    }
    // Caso de Uso: Login - Escenario Fallido
    public function testVerificarCredencialesIncorrectasDevuelveVacio()
    {
        $usuario = new Usuario();
        $login = 'admin';
        $claveErronea = 'clave_super_falsa_123';
        $resultado = $usuario->verificar($login, $claveErronea);

        $this->assertEquals(
            0,
            $resultado->num_rows,
            "El sistema aceptó una contraseña incorrecta (Grave)."
        );
    }
}
