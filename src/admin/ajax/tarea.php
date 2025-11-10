<?php

session_start();
require_once "../modelos/Tarea.php";

$tarea = new Tarea();

$idtarea = isset($_POST['idtarea']) ? limpiarCadena($_POST['idtarea']) : '';
$titulo = isset($_POST['titulo']) ? limpiarCadena($_POST['titulo']) : '';
$descripcion = isset($_POST['descripcion']) ? limpiarCadena($_POST['descripcion']) : '';
$fecha_vencimiento = isset($_POST['fecha_vencimiento']) ? limpiarCadena($_POST['fecha_vencimiento']) : '';
$asignados_json = isset($_POST['asignados']) ? $_POST['asignados'] : '[]';
$asignados = json_decode($asignados_json, true);

switch ($_GET['op']) {
    case 'guardaryeditar':
        // crear tarea y asignar usuarios
        $creado_por = $_SESSION['idusuario'];
        $idt = $tarea->insertar($titulo, $descripcion, $fecha_vencimiento, $creado_por);
        if ($idt) {
            if (is_array($asignados) && count($asignados) > 0) {
                $tarea->asignarUsuarios($idt, $asignados, $creado_por);
            }
            echo json_encode(['success' => true, 'message' => 'Tarea creada correctamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'No se pudo crear la tarea']);
        }
        break;

    case 'listarPorUsuario':
        $idusuario = $_SESSION['idusuario'];
        $rspta = $tarea->listarPorUsuario($idusuario);
        $data = array();
        while ($reg = $rspta->fetch_object()) {
            $estado = ($reg->completado) ? 'Completada' : 'Pendiente';
            $badge = ($reg->completado) ? '<span class="label bg-green">Completada</span>' : '<span class="label bg-yellow">Pendiente</span>';
            $vencida = '';
            if (!empty($reg->fecha_vencimiento)) {
                $hoy = date('Y-m-d');
                if ($reg->fecha_vencimiento < $hoy && !$reg->completado) {
                    $vencida = ' <small class="text-danger">(Vencida)</small>';
                }
            }

            $data[] = array(
                'asign_id' => $reg->asign_id,
                'tarea_id' => $reg->tarea_id,
                'titulo' => $reg->titulo,
                'descripcion' => $reg->descripcion,
                'fecha_creado' => $reg->fecha_creado,
                'fecha_vencimiento' => $reg->fecha_vencimiento,
                'estado' => $estado,
                'badge' => $badge,
                'vencida' => $vencida,
                'creado_por' => $reg->asignado_por_nombre . ' ' . $reg->asignado_por_apellidos,
                'departamento' => $reg->departamento
            );
        }
        echo json_encode($data);
        break;

    case 'mostrar':
        $idt = isset($_GET['id']) ? limpiarCadena($_GET['id']) : '';
        $rspta = $tarea->mostrar($idt);
        echo json_encode($rspta);
        break;

    case 'marcarCompletada':
        $idt = isset($_POST['idtarea']) ? limpiarCadena($_POST['idtarea']) : '';
        $idusuario = $_SESSION['idusuario'];
        $rspta = $tarea->marcarCompletada($idt, $idusuario);
        echo $rspta ? json_encode(['success' => true]) : json_encode(['success' => false]);
        break;
}
