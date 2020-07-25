<?php
	require_once("control_db.php");
	if(!isset($_SESSION['idusuario']) and strlen($_SESSION['idusuario'])==0){
		header("location: login/");
	}
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

	<link rel="stylesheet" href="librerias15/load/css-loader.css">
	<link rel="stylesheet" type="text/css" href="style.css"/>
	<link rel="stylesheet" href="librerias15/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
	<link rel="stylesheet" href="librerias15/swal/dist/sweetalert2.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.5.5/dist/css/uikit.min.css" />
</head>

	<body>

		<div class="wrapper" id='escritorio'>

      <nav id="sidebar">
				<?php

					include ("dash/menu.php");

				 ?>
      </nav>

      <div id="content">
				<?php

					include ("dash/header.php");

				 ?>
				 <div id='contenido'>

				 </div>
      </div>
		</div>

		<div class="loader loader-default is-active" id='cargando_div' data-text="Cargando"></div>

		<div class="modal animated fadeInDown" tabindex="-1" role="dialog" id="myModal">
			<div class="modal-dialog" role="document" id='modal_dispo'>
				<div class="modal-content" id='modal_form'>

				</div>
			</div>
		</div>



	<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>
	<script src="librerias15/js/bootstrap.js"></script>

	<link rel="stylesheet" href="librerias15/jqueryconfirm/css/jquery-confirm.css">
	<script src="librerias15/jqueryconfirm/js/jquery-confirm.js"></script>

	<!-- Animation library for notifications   -->
  <link href="librerias15/animate.css" rel="stylesheet"/>

	<!-- WYSWYG   -->
	<link href="librerias15/summernote8.12/summernote-lite.css" rel="stylesheet" type="text/css">
  <script src="librerias15/summernote8.12/summernote-lite.js"></script>
	<script src="librerias15/summernote8.12/lang/summernote-es-ES.js"></script>

	<!--   Alertas   -->
	<script src="librerias15/swal/dist/sweetalert2.min.js"></script>

	<!--   para imprimir   -->
	<script src="librerias15/VentanaCentrada.js" type="text/javascript"></script>



	<!--   iconos   -->
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
	<script src="librerias15/popper.js"></script>
	<script src="librerias15/tooltip.js"></script>

	<!--   Boostrap   -->



	<!--   Propios   -->
	<script src="sagycv4.js"></script>
	<script src="ipsi.js"></script>
	<link href="https://fonts.googleapis.com/css2?family=Baloo+Paaji+2&display=swap" rel="stylesheet">

	<script src="https://cdn.jsdelivr.net/npm/uikit@3.5.5/dist/js/uikit.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/uikit@3.5.5/dist/js/uikit-icons.min.js"></script>
</body>
</html>
