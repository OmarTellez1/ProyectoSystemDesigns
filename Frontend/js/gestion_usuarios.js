$(document).ready(function () {
  listarUsuarios();

  // Mostrar modal para crear usuario
  $("#btnNuevoUsuario").on("click", function () {
    limpiarFormulario();
    $("#modalUsuarioLabel").text("Crear Nuevo Usuario");
    $("#password").prop("required", true); // La contraseña es requerida al crear
    $("#password").closest(".mb-3").show(); // Muestra el campo de contraseña
    new bootstrap.Modal(document.getElementById("modalUsuario")).show();
  });

  // Guardar usuario (crear o editar)
  $("#formularioUsuario").on("submit", function (e) {
    e.preventDefault();
    guardarUsuario();
  });

  // Evento para editar usuario usando delegación de eventos
  $("#tablaUsuarios").on("click", ".btnEditar", function () {
    const idusuario = $(this).data("idusuario");
    editarUsuario(idusuario);
  });

  // Evento para activar usuario
  $("#tablaUsuarios").on("click", ".btnActivar", function () {
    const idusuario = $(this).data("idusuario");
    cambiarEstadoUsuario(idusuario, 1);
  });

  // Evento para desactivar usuario
  $("#tablaUsuarios").on("click", ".btnDesactivar", function () {
    const idusuario = $(this).data("idusuario");
    cambiarEstadoUsuario(idusuario, 0);
  });
});

function listarUsuarios() {
  $.ajax({
    url: "../../ajax/usuario.php?op=listar",
    type: "GET",
    dataType: "json",
    success: function (data) {
      let html = "";
      if (data && data.aaData) {
        data.aaData.forEach(function (usuario) {
          // El estado viene en el índice 6
          const estado = usuario[6] == 1 ? "Activo" : "Inactivo";
          const badgeClass = usuario[6] == 1 ? "bg-success" : "bg-danger";
          const botonCambio =
            usuario[6] == 1
              ? `<button class="btn btn-warning btn-sm btnDesactivar" data-idusuario="${usuario[0]}">Desactivar</button>`
              : `<button class="btn btn-info btn-sm btnActivar" data-idusuario="${usuario[0]}">Activar</button>`;

          html += `
            <tr>
              <td>${usuario[1]}</td>
              <td>${usuario[2]}</td>
              <td>${usuario[3]}</td>
              <td>${usuario[4]}</td>
              <td><span class="badge ${badgeClass}">${estado}</span></td>
              <td>
                <button class="btn btn-primary btn-sm btnEditar" data-idusuario="${usuario[0]}">Editar</button>
                ${botonCambio}
              </td>
            </tr>
          `;
        });
      }
      // Es importante apuntar al <tbody>, no a la tabla entera
      $("#tablaUsuarios").html(html);
    },
    error: function (xhr, status, error) {
      console.error("Error al listar usuarios:", status, error);
      // Usamos una alerta de Bootstrap para un look más profesional
      $("#contenido").prepend(
        '<div class="alert alert-danger">No se pudieron cargar los usuarios. Revisa la consola para más detalles.</div>'
      );
    },
  });
}

function guardarUsuario() {
  const formData = new FormData($("#formularioUsuario")[0]);

  $.ajax({
    url: "../../ajax/usuario.php?op=guardaryeditar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (response) {
      // Usamos una alerta temporal que se puede cerrar
      alert(response); // Por ahora mantenemos el alert, pero se puede mejorar
      bootstrap.Modal.getInstance(
        document.getElementById("modalUsuario")
      ).hide();
      listarUsuarios(); // Recargamos la lista
    },
    error: function () {
      alert("Error al guardar el usuario.");
    },
  });
}

function editarUsuario(idusuario) {
  $.ajax({
    url: "../../ajax/usuario.php?op=mostrar",
    type: "POST",
    data: { idusuario },
    dataType: "json",
    success: function (data) {
      if (data) {
        limpiarFormulario();
        $("#modalUsuarioLabel").text("Editar Usuario");
        $("#idusuario").val(data.idusuario);
        $("#nombre").val(data.nombre);
        $("#apellidos").val(data.apellidos);
        $("#login").val(data.login);
        $("#email").val(data.email);
        // Ocultamos el campo de contraseña y lo hacemos no requerido
        $("#password").prop("required", false);
        $("#password").closest(".mb-3").hide();
        new bootstrap.Modal(document.getElementById("modalUsuario")).show();
      } else {
        alert("No se pudo obtener la información del usuario.");
      }
    },
    error: function () {
      alert("Error al obtener datos del usuario.");
    },
  });
}

function cambiarEstadoUsuario(idusuario, estado) {
  $.ajax({
    url: "../../ajax/usuario.php?op=cambiarestado",
    type: "POST",
    data: { idusuario, estado },
    success: function (response) {
      // Idealmente, aquí también usarías una notificación más elegante
      alert(response);
      listarUsuarios();
    },
    error: function () {
      alert("Error al cambiar el estado del usuario.");
    },
  });
}

function limpiarFormulario() {
  $("#formularioUsuario")[0].reset();
  $("#idusuario").val("");
}
