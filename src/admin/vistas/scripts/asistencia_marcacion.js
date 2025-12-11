/*var tabla;

//funcion que se ejecuta al inicio
function init(){
$("#formulario").on("submit",function(e){
   	registrar_asistencia(e);
   })


}

//funcion limpiar
function limpiar(){
	$("#codigo_persona").val("");
	setTimeout('document.location.reload()',2000);

}

function registrar_asistencia(e){
     e.preventDefault();//no se activara la accion predeterminada 
     $("#btnGuardar").prop("disabled",true);
     var formData=new FormData($("#formulario")[0]);

     $.ajax({
     	url: "../ajax/asistencia_marcacion.php?op=registrar_asistencia",
     	type: "POST",
     	data: formData,
     	contentType: false,
     	processData: false,

     	success: function(datos){
     			$("#movimientos").html(datos);
     		//bootbox.alert(datos);
     	}
     });
     limpiar();
}





init();*/

// asistencia_marcacion.js - CON VALIDACIÓN

var tabla;
var USUARIO_CODIGO = window.USUARIO_DATA ? window.USUARIO_DATA.codigo : '';

// Función que se ejecuta al inicio
function init(){
    console.log("🔄 Iniciando sistema para:", window.USUARIO_DATA.nombre);
    console.log("Código del usuario:", USUARIO_CODIGO);
    
    $("#formulario").on("submit", function(e){
        registrar_asistencia(e);
    });
    
    // Validación en tiempo real
    $("#codigo_persona").on("input", function() {
        validarCodigoEnTiempoReal(this.value);
    });
    
    // Enfocar y limpiar
    $("#codigo_persona").focus().val('');
}


function validarCodigoEnTiempoReal(codigoIngresado) {
    var boton = $("#btnGuardar");
    
    // Asegurar que el botón sea visible siempre
    boton.css({
        'display': 'inline-block !important',
        'visibility': 'visible !important',
        'opacity': '1 !important'
    });
    
    if (!codigoIngresado) {
        boton.prop('disabled', false)
             .html('<i class="fa fa-arrow-right text-muted"></i>') // ← SOLO flecha
             .removeClass('btn-success btn-danger').addClass('btn-primary')
             .css('background-color', '#ffffffff'); // Azul Bootstrap
        return;
    }
    
    if (codigoIngresado === USUARIO_CODIGO) {
        boton.removeClass('btn-primary btn-danger').addClass('btn-success')
             .html('<i class="fa fa-check"></i> Marcar') // ← Check + "Marcar"
             .prop('disabled', false)
             .css('background-color', '#28a745'); // Verde Bootstrap
    } else {
        boton.removeClass('btn-primary btn-success').addClass('btn-danger')
             .html('<i class="fa fa-times"></i> Inválido') // ← Equis + "Inválido"
             .prop('disabled', false)
             .css('background-color', '#dc3545'); // Rojo Bootstrap
        
        // Forzar visibilidad máxima
        boton.css({
            'z-index': '9999',
            'position': 'relative'
        });
    }
    
    // Forzar repintado del botón
    boton.hide().show();
}

// Función limpiar
function limpiar(){
    $("#codigo_persona").val("");
    setTimeout(function() {
        $("#codigo_persona").focus();
        // Restaurar botón
        $("#btnGuardar").removeClass('btn-danger btn-success').addClass('btn-primary')
                       .html('<i class="fa fa-arrow-right text-muted"></i>')
                       .prop('disabled', false);
    }, 2000);
}

// Función principal para registrar asistencia
function registrar_asistencia(e){
    e.preventDefault();
    
    var codigoIngresado = $("#codigo_persona").val().trim();
    
    // 1. VALIDACIÓN EN JAVASCRIPT
    if (codigoIngresado !== USUARIO_CODIGO) {
        bootbox.alert({
            title: "<i class='fa fa-exclamation-triangle'></i> Código incorrecto",
            message: "Solo puedes marcar con tu código personal<br><strong>",
            className: 'modal-danger'
        });
        $("#codigo_persona").val('').focus();
        return;
    }
    
    // 2. Si pasa validación JS, proceder con AJAX
    $("#btnGuardar").prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i>');
    
    var formData = new FormData($("#formulario")[0]);
    
    // Añadir datos del usuario para verificación en PHP
    formData.append('usuario_id_sesion', window.USUARIO_DATA.id);
    formData.append('usuario_nombre_sesion', window.USUARIO_DATA.nombre);
    
    console.log("📤 Enviando asistencia para usuario:", window.USUARIO_DATA.nombre);
    console.log("Código enviado:", codigoIngresado);
    
    $.ajax({
        url: "../ajax/asistencia_marcacion.php?op=registrar_asistencia",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){
            $("#movimientos").html(datos);
            console.log("✅ Respuesta del servidor:", datos);
        },
        error: function(xhr, status, error) {
            console.error("❌ Error AJAX:", error);
            $("#movimientos").html(
                '<div class="alert alert-danger">' +
                '<i class="fa fa-exclamation-triangle"></i> Error: ' + error +
                '</div>'
            );
        },
        complete: function() {
            setTimeout(function() {
                $("#btnGuardar").prop("disabled", false)
                               .removeClass('btn-danger btn-success').addClass('btn-primary')
                               .html('<i class="fa fa-arrow-right text-muted"></i>');
            }, 1000);
            limpiar();
        }
    });
}

// Inicializar
$(document).ready(function() {
    init();
});