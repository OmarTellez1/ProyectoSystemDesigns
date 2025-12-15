<?php
if (strlen(session_id()) < 1) {
  session_start();
}

// --- INTEGRACIÓN CLOUDINARY (Lógica inteligente) ---
// Obtenemos la imagen de la sesión
$imgRaw = isset($_SESSION['imagen']) ? $_SESSION['imagen'] : 'default.jpg';
$srcImagen = "";

// Verificamos si es una URL de internet (Cloudinary) o un archivo local
if (strpos($imgRaw, 'http') === false) {
  // No tiene http, asumimos que es local (Legacy)
  $srcImagen = "../files/usuarios/" . $imgRaw;
} else {
  // Si tiene http, es de Cloudinary, usamos el link directo
  $srcImagen = $imgRaw;
}
// ---------------------------------------------------
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Primero Tu</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="../public/css/bootstrap.min.css">
  <link rel="stylesheet" href="../public/css/font-awesome.css">
  <link rel="stylesheet" href="../public/css/AdminLTE.min.css">

  <link rel="stylesheet" href="../public/css/blue.css">
  <link rel="stylesheet" href="../public/css/_all-skins.min.css">
  <link rel="apple-touch-icon" href="../public/apple-touch-icon.png">
  <link rel="shortcut icon" href="../public/favicon.ico">

  <link rel="stylesheet" type="text/css" href="../public/datatables/jquery.dataTables.min.css">
  <link href="../public/datatables/buttons.dataTables.min.css" rel="stylesheet" />
  <link href="../public/datatables/responsive.dataTables.min.css" rel="stylesheet" />

  <link rel="stylesheet" type="text/css" href="../public/css/bootstrap-select.min.css">

</head>

<body class="hold-transition skin-blue sidebar-mini">
  <div id="fb-root"></div>

  <div class="fb-customerchat" attribution=setup_tool page_id="280144326139427" theme_color="#0084ff"
    logged_in_greeting="Hola! deseas compartir algún sistema o descargar ?"
    logged_out_greeting="Hola! deseas compartir algún sistema o descargar ?">
  </div>


  <header class="main-header">
    <a href="escritorio.php" class="logo">
      <span class="logo-mini"><b>primero</b> Tu</span>
      <span class="logo-lg"><b>Primero</b> Tu</span>
    </a>
    <nav class="navbar navbar-static-top">
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Navegación</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo $srcImagen; ?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $_SESSION['nombre']; ?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="user-header">
                <img src="<?php echo $srcImagen; ?>" class="img-circle" alt="User Image">

                <p>
                  <?php echo $_SESSION['nombre'] . ' ' . $_SESSION['departamento']; ?>
                  <small>Desarrollo de sistemas informáticos</small>
                </p>
              </li>
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Perfil</a>
                </div>
                <div class="pull-right">
                  <a href="../../admin" class="btn btn-default btn-flat">Salir</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <aside class="main-sidebar">
    <section class="sidebar">
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo $srcImagen; ?>" class="img-circle" style="width: 50px; height: 50px;" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $_SESSION['nombre']; ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <ul class="sidebar-menu tree" data-widget="tree">
        <li class="header">MENÚ DE NAVEGACIÓN</li>


        <li><a href="escritorio.php"><i class="fa fa-dashboard"></i> <span>Escritorio</span></a></li>
        <li><a href="mitareas.php"><i class="fa fa-tasks"></i> <span>Mis Tareas</span></a></li>






        <?php if ($_SESSION['tipousuario'] == 'Administrador') {
          ?>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-tasks"></i> <span>Tareas</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="tareas.php"><i class="fa fa-circle-o"></i> Crear Tareas</a></li>
            </ul>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-folder"></i> <span>Acceso</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="usuario.php"><i class="fa fa-circle-o"></i> Usuarios</a></li>
              <li><a href="tipousuario.php"><i class="fa fa-circle-o"></i> Tipo Usuario</a></li>
            </ul>
          </li>

          <li class="treeview">
            <a href="#">
              <i class="fa fa-folder"></i> <span>Departamento</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="departamento.php"><i class="fa fa-circle-o"></i> Departamento</a></li>
            </ul>
          </li>

          <li class="treeview">
            <a href="#">
              <i class="fa fa-folder"></i> <span>Asistencias</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="asistencia.php"><i class="fa fa-circle-o"></i> Asistencia</a></li>
              <li><a href="rptasistencia.php"><i class="fa fa-circle-o"></i> Reportes</a></li>

            </ul>
          </li>
        <?php } ?>
        <?php if ($_SESSION['tipousuario'] != 'Administrador') {
          ?>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-folder"></i> <span>Marcación</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="marcacion.php"><i class="fa fa-circle-o"></i>Entrada/Salida</a></li>
            </ul>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-folder"></i> <span>Mis Asistencias</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="asistenciau.php"><i class="fa fa-circle-o"></i> Asistencia</a></li>
              <li><a href="rptasistenciau.php"><i class="fa fa-circle-o"></i> Reportes</a></li>

            </ul>
          </li>
        <?php } ?>

      </ul>
      </li>
      <?php ?>

      </ul>
    </section>
  </aside>