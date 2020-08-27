<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>IPSI - Admin</title>
        <link href="style.css" rel="stylesheet" />

        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="../librerias15/load/css-loader.css">
        <link rel="stylesheet" href="../librerias15/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
        <link rel="stylesheet" href="../librerias15/swal/dist/sweetalert2.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.5.5/dist/css/uikit.min.css" />
		  <!-- Custom fonts for this template-->
		  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
		  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

		  <!-- Custom styles for this template-->
		  <link href="css/sb-admin-2.min.css" rel="stylesheet">
			<link href="ipsi.css" rel="stylesheet">

    </head>
    <body class="sb-nav-fixed">

			<div class="container">
				<form is="f-submit" id="form_cliente" db="a_pacientes/db_" fun="guardar_cliente" >
					<input type="hidden" name="idpaciente" id="idpaciente" value="0">
					<div class='card'>
						<div class='card-header'>
							Registrar
						</div>
						<div class='card-body'>

							<div class='form-group' id='imagen_div'>
								<img src='' class='img-thumbnail' width='100px'>
							</div>


							<div class='row'>
								<div class="col-3">
									<label>Nombre:</label>
										<input type="text" class="form-control form-control-sm" name="nombre" id="nombre" value="" placeholder="Nombre" maxlength="100" required >
								</div>

								<div class="col-3">
									<label>Apellido Paterno:</label>
										<input type="text" class="form-control form-control-sm" name="apellidop" id="apellidop" value="" placeholder="Apellido Paterno" maxlength="50" required>
								</div>

								<div class="col-3">
									<label>Apellido materno:</label>
										<input type="text" class="form-control form-control-sm" name="apellidom" id="apellidom" value="" placeholder="Apellido materno" maxlength="50">
								</div>

								<div class="col-3">
									<label>Correo:</label>
										<input type="text" class="form-control form-control-sm" name="correo" id="correo" value="" placeholder="Correo" maxlength="100" required>
								</div>
							</div>
							<div class='row'>
                <div class="col-3">
									<label>Fecha nacimiento:</label>
										<input type="date" class="form-control form-control-sm" name="fnacimiento" id="fnacimiento" value=""  maxlength="20">
								</div>

								<div class="col-3">
									<label>Edad:</label>
										<input type="text" class="form-control form-control-sm" name="edad" id="edad" value="" placeholder="Edad"  maxlength="20">
								</div>

								<div class='col-sm-3'>
									<label for='nombre'>Sexo</label>
									<select name='sexo' id='sexo' class='form-control form-control-sm'>
										<option value='masculino'>Masculino</option>
										<option value='femenino'>Femenino</option>
									</select>
								</div>

								<div class="col-3">
									<label>Peso:</label>
										<input type="text" class="form-control form-control-sm" name="peso" id="peso" value="" placeholder="Peso" maxlength="20">
								</div>
								<div class="col-3">
									<label>Altura:</label>
										<input type="text" class="form-control form-control-sm" name="altura" id="altura" value="" placeholder="Altura" maxlength="20">
								</div>

								<div class="col-8">
									<label>Dirección:</label>
										<input type="text" class="form-control form-control-sm" name="direccion" id="direccion" value="" placeholder="Dirección" maxlength="255">
								</div>

								<div class="col-4">
									<label>Teléfono:</label>
										<input type="text" class="form-control form-control-sm" name="telefono" id="telefono" value="" maxlength="20" placeholder="Teléfono">
								</div>

								<div class="col-3">
									<label>Hermanos:</label>
									<input type="text" class="form-control form-control-sm" name="hermanos" id="hermanos" value="" placeholder="Numero de hermanos"  maxlength="20">
								</div>
								<div class="col-3">
									<label>Facebook:</label>
									<input type="text" class="form-control form-control-sm" name="facebook" id="facebook" value="" placeholder="Facebook"  maxlength="200">
								</div>
                <div class="col-3">
									<label>Nivel máximo de estudios:</label>
									<input type="text" class="form-control form-control-sm" name="estudios" id="estudios" value="" placeholder="Nivel máximo de estudios"  maxlength="100">
								</div>
                <div class="col-3">
									<label>Nombre del lugar de trabajo o escuela:</label>
									<input type="text" class="form-control form-control-sm" name="trabajo" id="trabajo" value="" placeholder="Nombre del lugar de trabajo o escuela"  maxlength="100">
								</div>
                <div class="col-3">
									<label>Nombre del puesto o Número de grado actual:</label>
									<input type="text" class="form-control form-control-sm" name="puesto" id="puesto" value="" placeholder="Nombre del puesto o Número de grado actual"  maxlength="100">
								</div>
                <div class="col-3">
									<label>Como te enteraste de IPSI:</label>
									<input type="text" class="form-control form-control-sm" name="ipsi" id="ipsi" value="" placeholder="Como te enteraste de IPSI"  maxlength="100">
								</div>
							</div>

							<div class='row'>
                <div class="col-3">
									<label>Nombre de contacto:</label>
									<input type="text" class="form-control form-control-sm" name="contacto" id="contacto" value="" placeholder="Nombre de contacto"  maxlength="150">
								</div>
                <div class="col-3">
									<label>Parentesco:</label>
									<input type="text" class="form-control form-control-sm" name="parentesco" id="parentesco" value="" placeholder="Parentesco"  maxlength="150">
								</div>
                <div class="col-3">
									<label>Telefono:</label>
									<input type="text" class="form-control form-control-sm" name="telparentesco" id="telparentesco" value="" placeholder="Telefono"  maxlength="150">
								</div>

              </div>

							<div class='row'>
								<div class="col-6">
									<label>Contraseña:</label>
									<input type="text" class="form-control form-control-sm" name="pass" id="pass" value="" maxlength="20" placeholder="Contraseña" required>
								</div>
								<div class="col-6">
									<label>Confirmar Contraseña:</label>
									<input type="text" class="form-control form-control-sm" name="pass2" id="pass2" value="" maxlength="20" placeholder="Contraseña" required>
								</div>
							</div>
						</div>
						<div class='card-footer'>
							<div class="row">
								<div class="col-sm-12">
									<button class="btn btn-warning btn-sm" type="submit">Guardar</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
      <div class="loader loader-default is-active" id='cargando_div' data-text="Cargando"></div>

			<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
			<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
			<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>

			<link rel="stylesheet" href="../librerias15/jqueryconfirm/css/jquery-confirm.css">
			<script src="../librerias15/jqueryconfirm/js/jquery-confirm.js"></script>

			<!-- Animation library for notifications   -->
			<link href="../librerias15/animate.css" rel="stylesheet"/>

			<!-- WYSWYG   -->
			<link href="../librerias15/summernote8.12/summernote-lite.css" rel="stylesheet" type="text/css">
			<script src="../librerias15/summernote8.12/summernote-lite.js"></script>
			<script src="../librerias15/summernote8.12/lang/summernote-es-ES.js"></script>

			<!--   Alertas   -->
			<script src="../librerias15/swal/dist/sweetalert2.min.js"></script>

			<!--   para imprimir   -->
			<script src="../librerias15/VentanaCentrada.js" type="text/javascript"></script>

			<!--   iconos   -->
			<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

			<!--   Boostrap   -->
			<link href="https://fonts.googleapis.com/css2?family=Baloo+Paaji+2&display=swap" rel="stylesheet">

			<script src="https://cdn.jsdelivr.net/npm/uikit@3.5.5/dist/js/uikit.min.js"></script>
			<script src="https://cdn.jsdelivr.net/npm/uikit@3.5.5/dist/js/uikit-icons.min.js"></script>

			<script src="../librerias15/js/bootstrap.js"></script>

			<!--   Propios   -->
			<script src="../sagyc.js"></script>
</body>
