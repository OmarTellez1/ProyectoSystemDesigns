<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require_once "../src/modelos/Usuario.php";
$usuario = new Usuario();

switch ($_GET["op"]) {
case 'verificar':
    $logina = $_POST['logina'];
    $clavea = $_POST['clavea'];
    $clavehash = hash("SHA256", $clavea);
    $rspta = $usuario->verificar($logina, $clavehash);
    $fetch = $rspta ? $rspta->fetch_object() : false;
    if ($fetch) {
        $_SESSION['idusuario'] = $fetch->idusuario;
        $_SESSION['nombre'] = $fetch->nombre;
        $_SESSION['login'] = $fetch->login;
        $_SESSION['idtipousuario'] = $fetch->idtipousuario;
        $_SESSION['tipousuario'] = $fetch->tipousuario;
    }
    echo json_encode($fetch);
    break;
case 'guardaryeditar':
    $idusuario = $_POST["idusuario"];
    $nombre = $_POST["nombre"];
    $apellidos = $_POST["apellidos"];
    $login = $_POST["login"];
    $email = $_POST["email"];
    $password = isset($_POST["password"]) ? $_POST["password"] : "";
    $idtipousuario = 1; // Puedes ajustar esto si tienes roles en el formulario
    $iddepartamento = 1; // Puedes ajustar esto si tienes departamentos

    // Obtenemos el ID del usuario que está realizando la acción desde la sesión
    $usuariocreador_id = isset($_SESSION['idusuario']) ? $_SESSION['idusuario'] : 0;

    if (empty($idusuario)) {
        // Crear usuario nuevo
        $clavehash = hash("SHA256", $password);
        // Pasamos el ID del usuario creador. El último parámetro (código_persona) lo dejamos vacío por ahora.
        $rspta = $usuario->insertar($nombre, $apellidos, $login, $iddepartamento, $idtipousuario, $email, $clavehash, "", $usuariocreador_id, "");
        echo $rspta ? "Usuario registrado correctamente" : "No se pudo registrar el usuario";
    } else {
        // Editar usuario existente (sin cambiar contraseña)
        $rspta = $usuario->editar($idusuario, $nombre, $apellidos, $login, $iddepartamento, $idtipousuario, $email, "", $usuariocreador_id, "");
        echo $rspta ? "Usuario actualizado correctamente" : "No se pudo actualizar el usuario";
    }
    break;

case 'listar':
    $rspta = $usuario->listar();
    $data = array();
    while ($reg = $rspta->fetch_object()) {
        $data[] = array(
            "0" => $reg->idusuario,
            "1" => $reg->nombre,
            "2" => $reg->apellidos,
            "3" => $reg->login,
            "4" => $reg->email,
            "5" => $reg->tipousuario,
            "6" => $reg->estado
        );
    }
    $results = array(
        "sEcho" => 1,
        "iTotalRecords" => count($data),
        "iTotalDisplayRecords" => count($data),
        "aaData" => $data
    );
    echo json_encode($results);
    break;

    // Puedes agregar más casos según lo que necesite tu frontend
}
?>