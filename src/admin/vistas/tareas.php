<?php
//activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
    header("Location: login.html");
} else {
    require 'header.php';
    ?>
    <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="row">
        <div class="col-md-12">
      <div class="box">
<div class="box-header with-border">
  <h1 class="box-title">Crear Tareas</h1>
  <div class="box-tools pull-right">
  </div>
</div>
<!--box-header-->
<!--centro-->
<div class="panel-body" id="formularioregistros">
  <form action="" name="formulario_tarea" id="formulario_tarea" method="POST" class="form-horizontal">
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="titulo">Título (*):</label>
      <input class="form-control" type="text" name="titulo" id="titulo" maxlength="50" placeholder="Título de la tarea" required>
    </div>
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="descripcion">Descripción (*):</label>
      <input class="form-control" type="text" name="descripcion" id="descripcion" maxlength="50" placeholder="Breve descripción" required>
    </div>
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="fecha_vencimiento">Fecha límite:</label>
      <input class="form-control" type="date" name="fecha_vencimiento" id="fecha_vencimiento" placeholder="YYYY-MM-DD">
    </div>

    <div class="form-group col-lg-4 col-md-4 col-xs-12">
      <label for="filtro_departamento">Filtrar por Departamento:</label>
      <select id="filtro_departamento" class="form-control select-picker"></select>
    </div>

    <div class="form-group col-lg-4 col-md-4 col-xs-12">
      <label for="select_usuario">Usuarios:</label>
      <div class="input-group">
        <select id="select_usuario" class="form-control"></select>
        <span class="input-group-btn">
          <button class="btn btn-primary" id="btn_add_usuario" type="button">Añadir</button>
        </span>
      </div>
    </div>

    <div class="form-group col-lg-12 col-md-12 col-xs-12">
      <label>Asignados:</label>
      <div id="lista_asignados" style="min-height:40px;border:1px solid #ddd;padding:8px;border-radius:4px;"></div>
    </div>

    <div class="form-group col-lg-12 col-md-12 col-xs-12">
      <button class="btn btn-primary" type="submit" id="btnGuardar_tarea"><i class="fa fa-save"></i>  Guardar</button>
      <button class="btn btn-danger" onclick="window.location='escritorio.php'" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
    </div>
  </form>
</div>

<!--fin centro-->
      </div>

      </div>
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
    <?php

    require 'footer.php';
    ?>
 <script src="scripts/tareas.js"></script>
    <?php
}

ob_end_flush();
?>
