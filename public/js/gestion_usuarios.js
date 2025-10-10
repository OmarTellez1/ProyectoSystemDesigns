$(document).ready(function () {
  listarUsuarios();

  // 1. Mostrar el modal al hacer clic en "Crear Nuevo Usuario"
  $("#btnNuevoUsuario").on("click", function () {
    limpiarFormulario();
    $("#modalUsuarioLabel").text("Crear Nuevo Usuario");
    // Habilitar el campo de contraseña
    $("#password").prop("required", true);
    new bootstrap.Modal(document.getElementById("modalUsuario")).show();
  });

  // 2. Guardar el usuario al enviar el formulario del modal
  $("#formularioUsuario").on("submit", function (e) {
    e.preventDefault(); // Evitar recarga de página
    guardarUsuario();
  });
});

function listarUsuarios() {
  // ... (El código que ya tenías para listar usuarios va aquí, sin cambios)
  $.ajax({
    url: "../../ajax/usuario.php?op=listar",
    type: "GET",
    dataType: "json",
    success: function (data) {
      $("#tablaUsuarios").html("");
      if (data && data.aaData) {
        $.each(data.aaData, function (i, usuario) {
          const fila = `
                        <tr>
                            <td>${usuario[1]}</td>
                            <td>${usuario[2]}</td>
                            <td>${usuario[3]}</td>
                            <td>${usuario[4]}</td>
                            <td>${
                              usuario[6] == 1
                                ? '<span class="badge bg-success">Activo</span>'
                                : '<span class="badge bg-danger">Inactivo</span>'
                            }</td>
                            <td>
                                <button class="btn btn-warning btn-sm btnEditar" data-idusuario="${
                                  usuario[0]
                                }">Editar</button>
                                ${
                                  usuario[6] == 1
                                    ? `<button class="btn btn-danger btn-sm btnDesactivar" data-idusuario="${usuario[0]}">Desactivar</button>`
                                    : `<button class="btn btn-info btn-sm btnActivar" data-idusuario="${usuario[0]}">Activar</button>`
                                }
                            </td>
                        </tr>
                    `;
          $("#tablaUsuarios").append(fila);
        });
      } else {
        $("#tablaUsuarios").html(
          '<tr><td colspan="6" class="text-center">No se encontraron usuarios.</td></tr>'
        );
      }
    },
    error: function (xhr, status, error) {
      console.error("Error al listar usuarios:", status, error);
      $("#tablaUsuarios").html(
        '<tr><td colspan="6" class="text-center">Error al cargar los datos.</td></tr>'
      );
    },
  });
}

// 3. Nueva función para guardar
function guardarUsuario() {
  const formData = new FormData($("#formularioUsuario")[0]);

  $.ajax({
    // El backend debe tener un endpoint para guardar/editar.
    url: "../../ajax/usuario.php?op=guardaryeditar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (response) {
      // Asumimos que el backend devuelve un texto simple o un JSON
      alert(response); // Mostramos la respuesta del servidor
      bootstrap.Modal.getInstance(
        document.getElementById("modalUsuario")
      ).hide();
      listarUsuarios(); // Recargamos la tabla para ver el nuevo usuario
    },
    error: function () {
      alert("Error: No se pudo guardar el usuario.");
    },
  });
}

// 4. Nueva función para limpiar el formulario
function limpiarFormulario() {
  $("#formularioUsuario")[0].reset();
  $("#idusuario").val("");
}
