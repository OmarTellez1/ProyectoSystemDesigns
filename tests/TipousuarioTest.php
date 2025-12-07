<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/admin/modelos/Tipousuario.php';
require_once __DIR__ . '/../src/admin/config/global.php';

class TipousuarioTest extends TestCase
{
    protected $conexion;
    protected function setUp(): void
    {
        global $conexion;

        if (!isset($conexion) || $conexion === null) {
            $conexion = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
            $conexion->query('SET NAMES "' . DB_ENCODE . '"');
        }
        $this->conexion = $conexion;
    }
    public function testAdminPuedeCrearYVerificarRol()
    {
        // 1. PREPARACIÓN (Arrange)
        $tipoUsuarioModelo = new Tipousuario();
        // Usamos un nombre aleatorio para evitar conflictos si corres el test muchas veces
        $nombreRolTest = "Rol_QA_Auto_" . rand(1000, 9999);
        $descripcionTest = "Rol generado por prueba unitaria";

        // 2. ACCIÓN (Act) - Intentamos insertar
        $resultadoInsertar = $tipoUsuarioModelo->insertar($nombreRolTest, $descripcionTest, 1);

        // 3. VALIDACIÓN (Assert)
        // A) Verificar que el modelo diga "True" (Éxito)
        $this->assertTrue($resultadoInsertar, "El método insertar() falló al crear el rol.");

        // B) Verificar que el dato REALMENTE existe en la BD (Doble chequeo)
        // Hacemos una consulta manual para buscar ese nombre específico
        $sqlVerificacion = "SELECT * FROM tipousuario WHERE nombre = '$nombreRolTest'";
        $query = $this->conexion->query($sqlVerificacion);
        $datosRecuperados = $query->fetch_assoc();

        $this->assertNotNull($datosRecuperados, "El rol no se encontró en la BD después de insertarlo.");
        $this->assertEquals($nombreRolTest, $datosRecuperados['nombre'], "El nombre guardado no coincide.");

        // 4. LIMPIEZA (Teardown)
        // Borramos el rol creado para no ensuciar la base de datos
        if ($datosRecuperados) {
            $idCreado = $datosRecuperados['idtipousuario'];
            $this->conexion->query("DELETE FROM tipousuario WHERE idtipousuario = '$idCreado'");
        }
    }
}
