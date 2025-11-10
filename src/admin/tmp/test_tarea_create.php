<?php
require __DIR__ . '/../config/Conexion.php';
require __DIR__ . '/../modelos/Tarea.php';

echo "Iniciando prueba de creación de tarea...\n";
$t = new Tarea();
$id = $t->insertar('Prueba script', 'Tarea creada por script PHP', date('Y-m-d', strtotime('+7 days')), 1);
echo "Tarea creada ID: "; var_export($id); echo "\n";
if ($id) {
    $t->asignarUsuarios($id, [15], 1);
    echo "Asignada al usuario 15\n";
    $r = ejecutarConsulta("SELECT * FROM tarea_usuarios WHERE tarea_id=" . $id);
    while ($row = $r->fetch_assoc()) {
        var_export($row);
        echo "\n";
    }
} else {
    echo "No se pudo crear la tarea\n";
}
