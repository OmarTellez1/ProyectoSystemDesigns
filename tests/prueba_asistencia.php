<?php
// --- CONFIGURACIÓN DEL ENTORNO DE PRUEBA ---

// __DIR__ es la carpeta donde está ESTE archivo (tests)
// Le decimos: "Sube un nivel (..) y entra a src/modelos"
$ruta_modelos = __DIR__ . '/../src/modelos';

// Verificamos si la carpeta existe antes de intentar entrar (para evitar errores feos)
if (!is_dir($ruta_modelos)) {
    die("❌ ERROR DE RUTA: No encuentro la carpeta de modelos.\nBuscaba en: $ruta_modelos");
}

// Entramos a la carpeta de modelos
chdir($ruta_modelos);

// Incluimos el archivo
require_once "Asistencia.php";

// --- INICIO DE LA PRUEBA ---

echo "\n=============================================\n";
echo "   🛠️  INICIANDO PRUEBA DE ASISTENCIA \n";
echo "=============================================\n\n";

$asistencia = new Asistencia();

// --- CASO DE PRUEBA: Registrar una Entrada ---
echo "▶️  Test 1: Intentando registrar entrada...\n";

$codigo_prueba = "TEST_USER_999"; 
$tipo_prueba = "Entrada";

try {
    $resultado = $asistencia->registrar_entrada($codigo_prueba, $tipo_prueba);

    if ($resultado) {
        echo "✅  ÉXITO: El registro se guardó correctamente en la BD.\n";
    } else {
        echo "❌  FALLO: La función devolvió false. Revisa tu conexión.\n";
    }

} catch (Exception $e) {
    echo "⛔  EXCEPCIÓN: " . $e->getMessage() . "\n";
}

echo "\n=============================================\n";
echo "   FIN DE LA PRUEBA \n";
echo "=============================================\n";
?>