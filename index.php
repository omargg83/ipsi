<?php
	session_start();
	require_once("control_db.php");

?>
<!DOCTYPE HTML>
<html lang="es">
<head>
	<title>IPSI </title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<meta http-equiv="Expires" content="0">
	<meta http-equiv="Last-Modified" content="0">
	<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
	<meta http-equiv="Pragma" content="no-cache">

	<link rel="stylesheet" type="text/css" href="style.css"/>
	<link rel="stylesheet" href="librerias15/load/css-loader.css">
</head>

	<body>

		<div class="wrapper" id='escritorio'>
      <!-- Sidebar  -->
      <nav id="sidebar">
      </nav>
      <!-- Page Content  -->
      <div id="content">
          <nav class="navbar navbar-expand-lg navbar-light bg-light">
              <div class="container-fluid">

                  <button type="button" id="sidebarCollapse" class="btn btn-info">
                      <i class="fas fa-align-left"></i>
                      <span>Menu</span>
                  </button>

                  <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                      <i class="fas fa-align-justify"></i>
                  </button>

                  <div class="collapse navbar-collapse" id="navbarSupportedContent">
                      <ul class="nav navbar-nav ml-auto">
                          <li class="nav-item active">
                              <a class="nav-link" href="#">Page</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" href="#">Page</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" href="#">Page</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" href="#" onclick='salir()'><i class="fas fa-sign-out-alt"></i>Salir</a>
                          </li>
                      </ul>
                  </div>
              </div>
          </nav>

					<div id='contenido'>
					</div>
      </div>
		</div>

		<div class="loader loader-default is-active" id='cargando' data-text="Cargando"></div>

		<div class="modal animated fadeInDown" tabindex="-1" role="dialog" id="myModal">
			<div class="modal-dialog" role="document" id='modal_dispo'>
				<div class="modal-content" id='modal_form'>

				</div>
			</div>
		</div>

</body>
	<!--   Core JS Files   -->
	<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>

	<!--   url   -->
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />

	<!-- Animation library for notifications   -->
  <link href="librerias15/animate.css" rel="stylesheet"/>

	<!-- WYSWYG   -->
	<link href="librerias15/summernote8.12/summernote-lite.css" rel="stylesheet" type="text/css">
  <script src="librerias15/summernote8.12/summernote-lite.js"></script>
	<script src="librerias15/summernote8.12/lang/summernote-es-ES.js"></script>

	<!--   Alertas   -->
	<script src="librerias15/swal/dist/sweetalert2.min.js"></script>
	<link rel="stylesheet" href="librerias15/swal/dist/sweetalert2.min.css">

	<!--   para imprimir   -->
	<script src="librerias15/VentanaCentrada.js" type="text/javascript"></script>

	<!--   Cuadros de confirmación y dialogo   -->
	<link rel="stylesheet" href="librerias15/jqueryconfirm/css/jquery-confirm.css">
	<script src="librerias15/jqueryconfirm/js/jquery-confirm.js"></script>

	<!--   iconos   -->
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
	<script src="librerias15/popper.js"></script>
	<script src="librerias15/tooltip.js"></script>

	<!--   Boostrap   -->
	<link rel="stylesheet" href="librerias15/css/bootstrap.min.css">
	<script src="librerias15/js/bootstrap.js"></script>

	<!--   Pass   -->
	<script src="librerias15/jQuery-MD5-master/jquery.md5.js"></script>

	<!--   Tablas  -->
	<script type="text/javascript" src="librerias15/DataTables/datatables.js"></script>
	<script type="text/javascript" src="librerias15/DataTables/DataTables-1.10.18/js/dataTables.bootstrap4.min.js"></script>
	<script type="text/javascript" src="librerias15/DataTables/DataTables-1.10.18/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" src="librerias15/DataTables/DataTables-1.10.18/js/buttons.flash.min.js"></script>
	<script type="text/javascript" src="librerias15/DataTables/DataTables-1.10.18/js/jszip.min.js"></script>
	<script type="text/javascript" src="librerias15/DataTables/DataTables-1.10.18/js/pdfmake.min.js"></script>
	<script type="text/javascript" src="librerias15/DataTables/DataTables-1.10.18/js/vfs_fonts.js"></script>
	<script type="text/javascript" src="librerias15/DataTables/DataTables-1.10.18/js/buttons.html5.min.js"></script>
	<script type="text/javascript" src="librerias15/DataTables/DataTables-1.10.18/js/buttons.print.min.js"></script>

	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css"/>

	<!--   Propios   -->
	<script src="sagycv4.js"></script>
	<link href="https://fonts.googleapis.com/css2?family=Baloo+Paaji+2&display=swap" rel="stylesheet">

</html>
