<?php

require_once __DIR__ . '/../config/Conexion.php';

class Tarea
{
    public function __construct()
    {
    }

    public function insertar($titulo, $descripcion, $fecha_vencimiento, $creado_por)
    {
        date_default_timezone_set('America/Mexico_City');
        $fecha_creado = date('Y-m-d H:i:s');
        $sql = "INSERT INTO tareas (titulo, descripcion, fecha_creado, fecha_vencimiento, creado_por, estado) VALUES ('" . $titulo . "','" . $descripcion . "','" . $fecha_creado . "','" . $fecha_vencimiento . "','" . $creado_por . "',0)";
        return ejecutarConsulta_retornarID($sql);
    }

    public function asignarUsuarios($idtarea, $usuarios, $asignado_por)
    {
        // $usuarios is expected to be an array of idusuario
        foreach ($usuarios as $idusuario) {
            $idusuario = limpiarCadena($idusuario);
            $sql = "INSERT INTO tarea_usuarios (tarea_id, idusuario, asignado_por, asignado_en, completado) VALUES ('" . $idtarea . "','" . $idusuario . "','" . $asignado_por . "',NOW(),0)";
            ejecutarConsulta($sql);
        }
        return true;
    }

    public function listarPorUsuario($idusuario)
    {
        $sql = "SELECT tu.id as asign_id, t.id as tarea_id, t.titulo, t.descripcion, t.fecha_creado, t.fecha_vencimiento, t.creado_por, tu.completado, tu.fecha_completado, d.nombre as departamento, u.nombre as asignado_por_nombre, u.apellidos as asignado_por_apellidos FROM tarea_usuarios tu INNER JOIN tareas t ON tu.tarea_id=t.id LEFT JOIN usuarios u ON t.creado_por=u.idusuario LEFT JOIN departamento d ON u.iddepartamento=d.iddepartamento WHERE tu.idusuario='" . $idusuario . "' ORDER BY t.fecha_vencimiento IS NULL ASC, t.fecha_vencimiento ASC";
        return ejecutarConsulta($sql);
    }

    public function mostrar($idtarea)
    {
        $sql = "SELECT t.id, t.titulo, t.descripcion, t.fecha_creado, t.fecha_vencimiento, t.creado_por, t.estado, u.nombre as creado_por_nombre, u.apellidos as creado_por_apellidos FROM tareas t LEFT JOIN usuarios u ON t.creado_por=u.idusuario WHERE t.id='" . $idtarea . "'";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function marcarCompletada($idtarea, $idusuario)
    {
        $sql = "UPDATE tarea_usuarios SET completado=1, fecha_completado=NOW() WHERE tarea_id='" . $idtarea . "' AND idusuario='" . $idusuario . "'";
        return ejecutarConsulta($sql);
    }
}
