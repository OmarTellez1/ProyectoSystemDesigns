// ...existing code...
function verificarSesionYcargarDatos() {
  // ...existing code...
}

function cargarMenuYContenido(tipoUsuario) {
  console.log("Cargando UI para el rol:", tipoUsuario);

  if (tipoUsuario === "Administrador") {
    $("#menu").html(`
        <li class="nav-item"><a class="nav-link" href="#" data-vista="gestion_usuarios">Gestionar Usuarios</a></li>
        <li class="nav-item"><a class="nav-link" href="#" data-vista="gestion_roles">Gestionar Roles</a></li>
        <li class="nav-item"><a class="nav-link" href="#" data-vista="reporte_general">Reporte General</a></li>
    `);
    $("#contenido").html(
      "<h2>Panel de Administración</h2><p>Seleccione una opción del menú para comenzar.</p>"
    );
  } else {
    // ...existing code...
  }

  // AÑADIR ESTE NUEVO EVENT LISTENER
  // Se encarga de escuchar los clics en los enlaces del menú que acabamos de crear
  $("#menu").on("click", "a", function (e) {
    e.preventDefault();
    const vista = $(this).data("vista"); // Obtiene el valor de 'data-vista'
    if (vista) {
      cargarVista(vista);
    }
  });
}

// AÑADIR ESTA NUEVA FUNCIÓN
// Carga el contenido de un archivo HTML parcial en el div #contenido
function cargarVista(nombreVista) {
  $("#contenido").load(
    `parciales/${nombreVista}.html`,
    function (response, status, xhr) {
      if (status == "error") {
        console.error("Error al cargar la vista:", xhr.status, xhr.statusText);
        $("#contenido").html(
          `<div class="alert alert-danger">Error: No se pudo cargar la vista <strong>${nombreVista}.html</strong>.</div>`
        );
      }
    }
  );
}

function cerrarSesion() {
  // ...existing code...
}
