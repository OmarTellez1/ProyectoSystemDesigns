// Se ejecuta cuando el documento HTML ha sido completamente cargado
$(document).ready(function () {
  // Escucha el evento 'submit' del formulario con id 'frmAcceso'
  $("#frmAcceso").on("submit", function (e) {
    // Previene la acción por defecto del formulario, que es recargar la página
    e.preventDefault();

    // Obtiene los valores de los campos del formulario
    var logina = $("#logina").val();
    var clavea = $("#clavea").val();

    // Realiza una petición AJAX al backend
    $.ajax({
      // La URL del archivo PHP que procesará la petición.
      // Asumimos que existirá un archivo 'usuario.php' en una carpeta 'ajax' en la raíz del proyecto.
      url: "../../ajax/usuario.php?op=verificar",
      type: "POST", // Método de envío
      dataType: "json", // Esperamos una respuesta en formato JSON del servidor
      data: {
        logina: logina, // Enviamos el usuario
        clavea: clavea, // Enviamos la contraseña
      },
      success: function (data) {
        // Esta función se ejecuta si la petición AJAX tiene éxito

        if (data) {
          // Si el servidor devuelve datos (lo que significa que el login fue correcto)
          // Redirigimos al usuario a la página principal del sistema.
          // Crearemos esta página 'dashboard.html' en el siguiente paso.
          $(location).attr("href", "dashboard.html");
        } else {
          // Si el servidor devuelve 'false' o 'null', las credenciales son incorrectas.
          // Mostramos una alerta. Más adelante podemos mejorar esto con un mensaje de Bootstrap.
          alert("Usuario o Contraseña incorrectos.");
        }
      },
      error: function (xhr, status, error) {
        // Esta función se ejecuta si hay un error en la comunicación con el servidor
        console.error("Error en la petición AJAX:", status, error);
        alert(
          "Ocurrió un error al conectar con el servidor. Revisa la consola para más detalles."
        );
      },
    });
  });
});
