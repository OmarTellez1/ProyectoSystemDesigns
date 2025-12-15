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

require 'header.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marcación de Asistencia</title>
    <!-- Enlace al archivo CSS separado -->
    <link rel="stylesheet" href="../public/css/marcacion.css">
</head>
<body>

<!-- Contenedor principal centrado -->
<div class="main-container">
    <div class="lockscreen-wrapper">
        
        <!-- Contenedor para mensajes -->
        <div id="movimientos">
        </div>

        <!-- Logo y título -->
        <div class="text-center mb-4">
            <div class="lockscreen-logo">
                <h3><b>Marcación Asistencia</b></h3>
                <p class="text-muted">Primero Tu</p>
            </div>
            <div class="lockscreen-name">CONTROL PERSONAL</div>
        </div>
        
        <!-- Formulario de marcación -->
        <div class="lockscreen-item">
            <div class="row align-items-center">
                <!-- Imagen del usuario -->
                <div class="col-3 text-center">
                    <div class="lockscreen-image">
                        <img src="../files/usuarios/<?php echo htmlspecialchars($_SESSION['imagen']); ?>" 
                             alt="Foto de <?php echo htmlspecialchars($usuario_nombre); ?>"
                             onerror="this.src='../files/usuarios/default.png'">
                    </div>
                </div>
                
                <!-- Formulario -->
                <div class="col-9">
                    <form action="" class="lockscreen-credentials" id="formulario" method="POST">
                        <!-- Campo oculto con ID del usuario -->
                        <input type="hidden" name="usuario_id" id="usuario_id" value="<?php echo $usuario_id; ?>">
                        
                        <div class="input-group">
                            <input type="password" class="form-control" 
                                   name="codigo_persona" id="codigo_persona" 
                                   placeholder="Ingresa tu código" 
                                   autofocus
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
        
        <!-- Mensaje de ayuda -->
        <div class="text-center mt-4">
            <small class="text-muted">
                <i class="fa fa-info-circle"></i> Solo puedes marcar con tu código personal
            </small>
        </div>

        <!-- Información adicional -->
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

<!-- Scripts -->
<script src="../public/js/bootstrap.min.js"></script>
<script src="../public/js/bootbox.min.js"></script>

<!-- Variables PHP a JavaScript -->
<script>
// Pasar datos PHP a JavaScript
window.USUARIO_DATA = {
    id: "<?php echo $usuario_id; ?>",
    nombre: "<?php echo addslashes($usuario_nombre); ?>",
    codigo: "<?php echo $usuario_codigo; ?>",
    departamento: "<?php echo $_SESSION['departamento']; ?>"
};

// Actualizar hora en tiempo real
function actualizarHora() {
    const ahora = new Date();
    const fechaHora = ahora.toLocaleDateString('es-ES') + ' ' + ahora.toLocaleTimeString('es-ES');
    document.getElementById('fecha-hora').textContent = fechaHora;
}

// Actualizar cada segundo
setInterval(actualizarHora, 1000);
</script>

<!-- Cargar asistencia_marcacion.js -->
<script src="./scripts/asistencia_marcacion.js"></script>

</body>
</html>
<?php
ob_end_flush();
?>