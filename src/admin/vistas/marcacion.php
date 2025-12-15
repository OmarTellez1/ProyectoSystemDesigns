<?php
session_start();
if (!isset($_SESSION['nombre'])) {
    header("Location: login.html");
    exit();
}

// Obtener datos del usuario logueado
$usuario_id = $_SESSION['idusuario'];
$usuario_nombre = $_SESSION['nombre'];
$usuario_codigo = isset($_SESSION['codigo_persona']) ? $_SESSION['codigo_persona'] : '';

// --- CONFIGURACIÓN DE IMAGEN ---
// 1. PEGA AQUÍ LA URL DE TU IMAGEN DEFAULT DE CLOUDINARY
$defaultCloudinary = "https://res.cloudinary.com/dyetttues/image/upload/v1765690661/default_r0qfcl.jpg";

$imgRaw = isset($_SESSION['imagen']) ? $_SESSION['imagen'] : '';
$srcImagen = "";

// 2. Lógica inteligente
if (strpos($imgRaw, 'http') !== false) {
    // Es una URL de Cloudinary válida
    $srcImagen = $imgRaw;
} elseif ($imgRaw == 'default.jpg' || $imgRaw == 'default.png' || empty($imgRaw)) {
    // Si la sesión dice "default" o está vacía, usamos la nube directo
    $srcImagen = $defaultCloudinary;
} else {
    // Es un nombre de archivo viejo (legacy). 
    // Intentamos ruta local, pero si falla, el HTML se encargará.
    $srcImagen = "../files/usuarios/" . $imgRaw;
}
// --------------------------------

require 'header.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marcación de Asistencia</title>
    <link rel="stylesheet" href="../public/css/marcacion.css">
</head>

<body>

    <div class="main-container">
        <div class="lockscreen-wrapper">

            <div id="movimientos"></div>

            <div class="text-center mb-4">
                <div class="lockscreen-logo">
                    <h3><b>Marcación Asistencia</b></h3>
                    <p class="text-muted">Primero Tu</p>
                </div>
                <div class="lockscreen-name">CONTROL PERSONAL</div>
            </div>

            <div class="lockscreen-item">
                <div class="row align-items-center">
                    <div class="col-3 text-center">
                        <div class="lockscreen-image">
                            <img src="<?php echo htmlspecialchars($srcImagen); ?>"
                                alt="Foto de <?php echo htmlspecialchars($usuario_nombre); ?>"
                                onerror="this.onerror=null;this.src='<?php echo $defaultCloudinary; ?>';">
                        </div>
                    </div>

                    <div class="col-9">
                        <form action="" class="lockscreen-credentials" id="formulario" method="POST">
                            <input type="hidden" name="usuario_id" id="usuario_id" value="<?php echo $usuario_id; ?>">

                            <div class="input-group">
                                <input type="password" class="form-control" name="codigo_persona" id="codigo_persona"
                                    placeholder="Ingresa tu código" autofocus
                                    data-codigo-correcto="<?php echo htmlspecialchars($usuario_codigo); ?>">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary" id="btnGuardar">
                                        <i class="fa fa-arrow-right"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <small class="text-muted">
                    <i class="fa fa-info-circle"></i> Solo puedes marcar con tu código personal
                </small>
            </div>

            <div class="text-center mt-3">
                <small class="text-muted" id="fecha-hora">
                    <?php echo date('d/m/Y H:i:s'); ?>
                </small>
            </div>

        </div>
    </div>

    <?php
    require 'footer.php';
    ?>

    <script src="../public/js/bootstrap.min.js"></script>
    <script src="../public/js/bootbox.min.js"></script>

    <script>
        window.USUARIO_DATA = {
            id: "<?php echo $usuario_id; ?>",
            nombre: "<?php echo addslashes($usuario_nombre); ?>",
            codigo: "<?php echo $usuario_codigo; ?>",
            departamento: "<?php echo $_SESSION['departamento']; ?>"
        };

        function actualizarHora() {
            const ahora = new Date();
            const fechaHora = ahora.toLocaleDateString('es-ES') + ' ' + ahora.toLocaleTimeString('es-ES');
            document.getElementById('fecha-hora').textContent = fechaHora;
        }

        setInterval(actualizarHora, 1000);
    </script>

    <script src="./scripts/asistencia_marcacion.js"></script>

</body>

</html>
<?php
ob_end_flush();
?>