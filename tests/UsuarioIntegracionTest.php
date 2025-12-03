<?php

use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../src/admin/modelos/Usuario.php';
require_once __DIR__ . '/../src/admin/config/global.php';
class UsuarioIntegracionTest extends TestCase
{
    protected function setUp(): void
    {
        global $conexion;

        // Si la conexión se perdió (es null) o se cerró, la creamos de nuevo manualmemte.
        if (!isset($conexion) || $conexion === null) {
            $conexion = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

            // Verificamos errores (opcional pero recomendado)
            if (mysqli_connect_errno()) {
                $this->fail("Fallo al reconectar BD en setUp: " . mysqli_connect_error());
            }

            // Ajustamos la codificación
            $conexion->query('SET NAMES "' . DB_ENCODE . '"');
        }
    }
    public function testLaBaseDeDatosRespondeYListaUsuarios()
    {
        $usuario = new Usuario();
        $resultado = $usuario->listar();

        $this->assertNotNull($resultado, "Error: El método listar() devolvió null.");
        $this->assertInstanceOf(mysqli_result::class, $resultado, "Error: Objeto inválido.");
    }
}