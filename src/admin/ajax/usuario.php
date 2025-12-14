<?php
session_start();

// 1. Incluimos los modelos y la configuración de Cloudinary
require_once "../modelos/Usuario.php";
require_once "../config/cloudinary.php"; // Cargamos tus credenciales

// Importamos la clase de Cloudinary para subir archivos
use Cloudinary\Api\Upload\UploadApi;

$usuario = new Usuario();

$idusuarioc = isset($_POST["idusuarioc"]) ? limpiarCadena($_POST["idusuarioc"]) : "";
$clavec = isset($_POST["clavec"]) ? limpiarCadena($_POST["clavec"]) : "";
$idusuario = isset($_POST["idusuario"]) ? limpiarCadena($_POST["idusuario"]) : "";
$nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "";
$apellidos = isset($_POST["apellidos"]) ? limpiarCadena($_POST["apellidos"]) : "";
$login = isset($_POST["login"]) ? limpiarCadena($_POST["login"]) : "";
$iddepartamento = isset($_POST["iddepartamento"]) ? limpiarCadena($_POST["iddepartamento"]) : "";
$idtipousuario = isset($_POST["idtipousuario"]) ? limpiarCadena($_POST["idtipousuario"]) : "";
$email = isset($_POST["email"]) ? limpiarCadena($_POST["email"]) : "";
$codigo_persona = isset($_POST["codigo_persona"]) ? limpiarCadena($_POST["codigo_persona"]) : "";
$password = isset($_POST["clave"]) ? limpiarCadena($_POST["clave"]) : "";
$imagen = isset($_POST["imagen"]) ? limpiarCadena($_POST["imagen"]) : "";
$usuariocreado = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "";
$idmensaje = isset($_POST["idmensaje"]) ? limpiarCadena($_POST["idmensaje"]) : "";


switch ($_GET["op"]) {
    case 'guardaryeditar':
        // Lógica de Subida de Imagen a Cloudinary
        if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name'])) {
            $imagen = $_POST["imagenactual"];
        } else {
            // Validamos que sea una imagen
            $type = $_FILES['imagen']['type'];
            if ($type == "image/jpg" || $type == "image/jpeg" || $type == "image/png") {
                try {
                    // SUBIDA A CLOUDINARY
                    // Tomamos el archivo temporal
                    $archivo_temporal = $_FILES["imagen"]["tmp_name"];

                    // Lo subimos a la nube
                    $resultado = (new UploadApi())->upload($archivo_temporal, [
                        'folder' => 'usuarios_sistema' // Carpeta dentro de Cloudinary (opcional)
                    ]);

                    // Guardamos la URL segura (https) en la variable $imagen
                    $imagen = $resultado['secure_url'];

                } catch (Exception $e) {
                    // Si falla la subida a la nube, podrías manejar el error aquí
                    // Por ahora dejaremos que siga el flujo, pero la imagen quedará vacía o con error
                    $imagen = "";
                }
            }
        }

        //Hash SHA256 para la contraseña
        $clavehash = hash("SHA256", $password);

        if (empty($idusuario)) {
            $idusuario = $_SESSION["idusuario"];
            $rspta = $usuario->insertar($nombre, $apellidos, $login, $iddepartamento, $idtipousuario, $email, $clavehash, $imagen, $usuariocreado, $codigo_persona);
            echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar todos los datos del usuario";
        } else {
            $rspta = $usuario->editar($idusuario, $nombre, $apellidos, $login, $iddepartamento, $idtipousuario, $email, $imagen, $usuariocreado, $codigo_persona);
            echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
        }
        break;


    case 'desactivar':
        $rspta = $usuario->desactivar($idusuario);
        echo $rspta ? "Datos desactivados correctamente" : "No se pudo desactivar los datos";
        break;

    case 'activar':
        $rspta = $usuario->activar($idusuario);
        echo $rspta ? "Datos activados correctamente" : "No se pudo activar los datos";
        break;

    case 'mostrar':
        $rspta = $usuario->mostrar($idusuario);
        echo json_encode($rspta);
        break;

    case 'editar_clave':
        $clavehash = hash("SHA256", $clavec);
        $rspta = $usuario->editar_clave($idusuarioc, $clavehash);
        echo $rspta ? "Password actualizado correctamente" : "No se pudo actualizar el password";
        break;

    case 'mostrar_clave':
        $rspta = $usuario->mostrar_clave($idusuario);
        echo json_encode($rspta);
        break;

    case 'listar':
        $rspta = $usuario->listar();
        $data = array();

        while ($reg = $rspta->fetch_object()) {

            // LOGICA HIBRIDA PARA MOSTRAR IMAGENES
            // Si la imagen contiene "http", es de Cloudinary. Si no, es local antigua.
            $imgSrc = "";
            if (empty($reg->imagen)) {
                $imgSrc = "../files/usuarios/default.jpg"; // Imagen por defecto si no tiene
            } elseif (strpos($reg->imagen, 'http') !== false) {
                // Es una URL de Cloudinary
                $imgSrc = $reg->imagen;
            } else {
                // Es un archivo local viejo
                $imgSrc = "../files/usuarios/" . $reg->imagen;
            }

            $data[] = array(
                "0" => ($reg->estado) ?
                    '<button class="btn btn-warning btn-xs" onclick="mostrar(' . $reg->idusuario . ')"><i class="fa fa-pencil"></i></button>' . ' ' . '<button class="btn btn-info btn-xs" onclick="mostrar_clave(' . $reg->idusuario . ')"><i class="fa fa-key"></i></button>' . ' ' . '<button class="btn btn-danger btn-xs" onclick="desactivar(' . $reg->idusuario . ')"><i class="fa fa-close"></i></button>' :
                    '<button class="btn btn-warning btn-xs" onclick="mostrar(' . $reg->idusuario . ')"><i class="fa fa-pencil"></i></button>' . ' ' . '<button class="btn btn-info btn-xs" onclick="mostrar_clave(' . $reg->idusuario . ')"><i class="fa fa-key"></i></button>' . ' ' . '<button class="btn btn-primary btn-xs" onclick="activar(' . $reg->idusuario . ')"><i class="fa fa-check"></i></button>',
                "1" => $reg->nombre,
                "2" => $reg->apellidos,
                "3" => $reg->login,
                "4" => $reg->email,
                // AQUI USAMOS LA NUEVA VARIABLE $imgSrc
                "5" => "<img src='" . $imgSrc . "' height='50px' width='50px'>",
                "6" => $reg->fechacreado,
                "7" => ($reg->estado) ? '<span class="label bg-green">Activado</span>' : '<span class="label bg-red">Desactivado</span>'
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


    case 'verificar':
        $logina = $_POST['logina'];
        $clavea = $_POST['clavea'];
        $clavehash = hash("SHA256", $clavea);
        $rspta = $usuario->verificar($logina, $clavehash);
        $fetch = $rspta->fetch_object();

        if (isset($fetch)) {
            $_SESSION['idusuario'] = $fetch->idusuario;
            $id = $fetch->idusuario;
            $_SESSION['nombre'] = $fetch->nombre;
            $_SESSION['codigo_persona'] = $fetch->codigo_persona;

            // IMPORTANTE: La imagen en sesión ahora podría ser una URL completa
            $_SESSION['imagen'] = $fetch->imagen;

            $_SESSION['login'] = $fetch->login;
            $_SESSION['tipousuario'] = $fetch->tipousuario;
            $_SESSION['departamento'] = $fetch->iddepartamento;

            require "../config/Conexion.php";
            $sql = "UPDATE usuarios SET iteracion='1' WHERE idusuario='$id'";
            ejecutarConsulta($sql);
        }
        echo json_encode($fetch);
        break;

    case 'salir':
        require_once __DIR__ . "/../config/Conexion.php";
        if (isset($_SESSION['idusuario'])) {
            $id = $_SESSION['idusuario'];
            $sql = "UPDATE usuarios SET iteracion='0' WHERE idusuario='$id'";
            ejecutarConsulta($sql);
        }
        session_unset();
        session_destroy();
        header("Location: ../index.php");
        break;

    case 'selectUsuarios':
        require "../config/Conexion.php";
        $sql = "SELECT idusuario, nombre, apellidos, iddepartamento FROM usuarios WHERE estado='1'";
        $rspta = ejecutarConsulta($sql);
        $usuarios = array();
        while ($reg = $rspta->fetch_object()) {
            $usuarios[] = array(
                'idusuario' => $reg->idusuario,
                'nombre' => $reg->nombre,
                'apellidos' => $reg->apellidos,
                'iddepartamento' => $reg->iddepartamento
            );
        }
        echo json_encode($usuarios);
        break;
}
?>