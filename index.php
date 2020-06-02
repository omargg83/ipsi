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

	<link rel="stylesheet" href="librerias15/load/css-loader.css">
</head>

	<body style='background-image: url(fondo/fondo5.jpg)'>

		<div  id='header'>

		</div>

		<div id='menu'>

		</div>



	<div class="modal animated fadeInDown" tabindex="-1" role="dialog" id="myModal">
		<div class="modal-dialog" role="document" id='modal_dispo'>
			<div class="modal-content" id='modal_form'>

			</div>
		</div>
	</div>
	<div class="loader loader-default is-active" id='cargando' data-text="Cargando">
	</div>

</body>
	<!--   Core JS Files   -->
	<script src="librerias15/jquery-3.4.1.min.js" type="text/javascript"></script>

	<!--   url   -->
	<script src="librerias15/jquery/jquery-ui.js"></script>
	<link rel="stylesheet" type="text/css" href="librerias15/jquery/jquery-ui.min.css" />

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
	<link rel="stylesheet" href="librerias15/fontawesome-free-5.12.1-web/css/all.css">
	<script src="librerias15/popper.js"></script>
	<script src="librerias15/tooltip.js"></script>

	<!--   Propios   -->
	<script src="sagycv4.js"></script>
	<link rel="stylesheet" type="text/css" href="librerias15/modulos.css"/>

	<!--   Boostrap   -->
	<link rel="stylesheet" href="librerias15/css/bootstrap.min.css">
	<script src="librerias15/js/bootstrap.js"></script>

	<!--   Pass   -->
	<script src="librerias15/jQuery-MD5-master/jquery.md5.js"></script>


</html>
