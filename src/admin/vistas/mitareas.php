<?php
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
    header("Location: login.html");
} else {
    require 'header.php';
    ?>
    <div class="content-wrapper">
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h1 class="box-title">Mis Tareas</h1>
            </div>
            <div class="box-body">
              <div class="row" id="contenedor_tareas">
                <!-- tarjetas de tareas se insertan aquí -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
    <?php
    require 'footer.php';
    ?>
<script src="scripts/mitareas.js"></script>
    <?php
}
ob_end_flush();
?>
