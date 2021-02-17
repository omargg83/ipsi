<?php
	require_once("db_.php");
	if(!isset($_SESSION['idusuario']) or strlen($_SESSION['idusuario'])==0){
		header("location: login/");
	}
?>
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

		<link rel="stylesheet" href="librerias15/load/css-loader.css">
		<link rel="stylesheet" href="librerias15/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
		<link rel="stylesheet" href="librerias15/swal/dist/sweetalert2.min.css">

		<!-- Custom fonts for this template-->
		<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

		<!-- Custom styles for this template-->
		<link href="css/sb-admin-2.min.css" rel="stylesheet">
		<link href="ipsi.css" rel="stylesheet">
	</head>
	<body class="sb-nav-fixed">

		<div id="layoutSidenav">
			<div id="layoutSidenav_nav">
				<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
				<div class="sb-sidenav-menu">
					<div class="nav">
					<div class="sb-sidenav-menu-heading">
						<div style="width: 36%;display: inline-block;">
							<img style="vertical-align: bottom;border-radius: 10px; max-width: 50px;" src="<?php echo $_SESSION['foto']; ?>">
						</div>
						<div style="padding-left: 5px;width: 46%;display: inline-block;color:#fff;">  <strong><?php echo $_SESSION['nombrec']; ?> </strong>
							<br>
							<?php echo $_SESSION['tipo_user']; ?>
						</div>
					</div>

					<?php
						if($_SESSION['nivel']==666){
							$sql="SELECT * from terapias_per left outer join terapias on terapias.id=terapias_per.idterapia where terapias_per.idpaciente=".$_SESSION['idusuario'];
							$sth_te = $db->dbh->query($sql);

							foreach($sth_te->fetchAll(PDO::FETCH_OBJ) as $terapia){
								echo "<a class='nav-link collapsed' href='#' data-toggle='collapse' data-target='#d".$terapia->id."' aria-expanded='false' aria-controls='demo1'>";
									echo "<div class='sb-nav-link-icon'><i class='fas fa-columns'></i></div>";
									echo $terapia->nombre;
									echo "<div class='sb-sidenav-collapse-arrow'><i class='fas fa-angle-down'></i></div>";
								echo "</a>";

								$sql="SELECT * from track_per
								left outer join track on track.id=track_per.idtrack where track_per.idpaciente=".$_SESSION['idusuario']." and track.idterapia=$terapia->id order by track.inicial desc";

								$sth = $db->dbh->query($sql);
								echo "<div class='collapse' id='d".$terapia->id."' aria-labelledby='headingOne' data-parent='#sidenavAccordion'>";
								foreach($sth->fetchAll(PDO::FETCH_OBJ) as $track){
									echo "<nav class='sb-sidenav-menu-nested nav'>";
										if($track->inicial){
											$sql="select * from grupo_actividad_pre left outer join grupo_actividad on grupo_actividad.idgrupo=grupo_actividad_pre.idgrupo where grupo_actividad.idtrack='$track->id' and grupo_actividad_pre.idpaciente='".$_SESSION['idusuario']."'";
											$gro = $db->dbh->query($sql);
											foreach($gro->fetchAll(PDO::FETCH_OBJ) as $grupo){
												echo "<a class='nav-link' is='menu-link' href='#a_respuesta/grupos?idgrupo=$grupo->idgrupo' is='menu-link'>$grupo->grupo</a>";
											}
										}
										else{
											$sql="select * from modulo_per left outer join modulo on modulo.id=modulo_per.idmodulo where modulo.idtrack=$track->id and modulo_per.idpaciente='".$_SESSION['idusuario']."'";
											$mod = $db->dbh->query($sql);
											foreach($mod->fetchAll(PDO::FETCH_OBJ) as $modulo){

												$sql="select * from grupo_actividad_pre left outer join grupo_actividad on grupo_actividad.idgrupo=grupo_actividad_pre.idgrupo where grupo_actividad.idmodulo='$modulo->id' and grupo_actividad_pre.idpaciente='".$_SESSION['idusuario']."'";
												$gro = $db->dbh->query($sql);
												foreach($gro->fetchAll(PDO::FETCH_OBJ) as $grupo){
													echo "<a class='nav-link' is='menu-link' href='#a_respuesta/grupos?idgrupo=$grupo->idgrupo' is='menu-link'>$grupo->grupo</a>";
												}
											}
										}

										//echo "<a class='nav-link' is='menu-link' href='#a_respuesta/grupos?idtrack=$track->id' is='menu-link'>$track->nombre</a>";
										//echo "<a class='nav-link' is='menu-link' href='#a_respuesta/grupos' is='menu-link'>$track->nombre</a>";
										//echo "<a class='nav-link' is='menu-link' href='#a_respuesta/terapias' is='menu-link'>$track->nombre aca</a>";
									echo "</nav>";
								}
								echo "</div>";
							}
						}

						if($_SESSION['nivel']==1 or $_SESSION['nivel']==2 or $_SESSION['nivel']==3 or $_SESSION['nivel']==4){
							echo "<a class='nav-link' is='menu-link' href='#a_pacientes/index' title='Pacientes'><div class='sb-nav-link-icon'><i class='far fa-file-alt'></i></div>Pacientes</a>";
						}
						if($_SESSION['nivel']==1 or $_SESSION['nivel']==3 or $_SESSION['nivel']==4){
							echo "<a class='nav-link' is='menu-link' href='#a_terapeutas/index' title='Terapeutas'><div class='sb-nav-link-icon'><i class='fas fa-user-alt'></i></div>Terapeutas</a>";
						}
						if($_SESSION['nivel']==1 or $_SESSION['nivel']==2){
							echo "<a class='nav-link' is='menu-link' href='#a_actividades/index' title='Actividades'><div class='sb-nav-link-icon'><i class='far fa-file-alt'></i></div>Catalogo Terapias</a>";
						}

						if($_SESSION['nivel']==1 or $_SESSION['nivel']==4){
							echo "<a class='nav-link' is='menu-link' href='#a_usuarios/index' title='Usuarios'><div class='sb-nav-link-icon'><i class='fas fa-user-alt'></i></div>Cuentas</a>";
						}
						if($_SESSION['nivel']==666 or $_SESSION['nivel']==1 or $_SESSION['nivel']==2 or $_SESSION['nivel']==3 or $_SESSION['nivel']==4){
							echo "<a class='nav-link' is='menu-link' href='#a_agenda/index' title='Agenda'><div class='sb-nav-link-icon'><i class='fas fa-ticket-alt'></i></div>Agenda</a>";
						}

						if($_SESSION['nivel']==666){
							echo "<a class='nav-link' is='menu-link' href='#a_pacientes/relaciones' v_idpaciente='".$_SESSION['idusuario']."' title='Usuarios'><div class='sb-nav-link-icon'><i class='far fa-file-alt'></i></div>Relaciones</a>";
						}
						if($_SESSION['nivel']==666){
							echo "<a class='nav-link' is='menu-link' href='#a_pacientes/editar' title='Usuarios'><div class='sb-nav-link-icon'><i class='fas fa-user-alt'></i></div>Mi cuenta</a>";
						}

						if($_SESSION['nivel']==2 or $_SESSION['nivel']==1 or $_SESSION['nivel']==3 or $_SESSION['nivel']==4){
							echo "<a class='nav-link' is='menu-link' href='#a_reportes/index' title='Reportes'><div class='sb-nav-link-icon'><i class='fas fa-user-alt'></i></div>Reportes</a>";
						}
						if($_SESSION['nivel']==666 or $_SESSION['nivel']==1 or $_SESSION['nivel']==2 or $_SESSION['nivel']==3  or $_SESSION['nivel']==4){
							echo "<a class='nav-link' is='menu-link' href='#a_ticket/index' title='Ticket'><div class='sb-nav-link-icon'><i class='fas fa-ticket-alt'></i></div>Soporte</a>";
						}
						if ($_SESSION['nivel']==1 or $_SESSION['nivel']==4){
							echo "<a class='nav-link' is='menu-link' href='#a_sucursal/index' title='Sucursal'><div class='sb-nav-link-icon'><i class='fas fa-store'></i></div>Sucursal</a>";
						}
						if ($_SESSION['nivel']==1 or $_SESSION['nivel']==3 or $_SESSION['nivel']==4){
							echo "<a class='nav-link' is='menu-link' href='#a_consultorios/index' title='Consultorios'><div class='sb-nav-link-icon'><i class='fas fa-store'></i></div>Consultorios</a>";
						}
						if ($_SESSION['nivel']==1 or $_SESSION['nivel']==2 or $_SESSION['nivel']==3 or $_SESSION['nivel']==4){
							echo "<a class='nav-link' is='menu-link' href='#a_usuarios/editar_p' title='Mi cuenta'><div class='sb-nav-link-icon'><i class='fas fa-user-alt'></i></div>Mi cuenta</a>";
						}
					?>
				</div>
				</div>
				<div class="sb-sidenav-footer">
					<a onclick='salir()' href='#' class="btn btn-block"><i class="fas fa-sign-out-alt"></i>Salir</a>
				</div>
			</nav>
			</div>
			<div id="layoutSidenav_content">
				<!-- Topbar -->
				<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

					<!-- Sidebar Toggle (Topbar) -->
					<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
					<i class="fa fa-bars"></i>
					</button>

					<!-- Topbar Mensaje bienvenida-->
					<p class="bienvenida"> Hola, <?php echo $_SESSION['nombrec']; ?>, Que bueno tenerte de vuelta </p>

					<!-- Topbar Navbar -->
					<ul class="navbar-nav ml-auto">

						<!-- Nav Item - Alerts -->
						<li class="nav-item dropdown no-arrow mx-1">
							<a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="fas fa-bell fa-fw"></i>
								<span class="badge badge-danger badge-counter">3+</span>
							</a>
						</li>

						<!-- Nav Item - User Information -->
						<li class="nav-item dropdown no-arrow">
							<span class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<span class="mr-2 d-none d-lg-inline text-gray-600 small">
									<?php
										if($_SESSION['nivel']==666){
											echo "<a class='topcuenta' id='cuenta' is='menu-link' href='#a_paciente_perfil/index' title='Mi cuenta'>Mi cuenta</a>";
										}
										if ($_SESSION['nivel']==1 or $_SESSION['nivel']==2 or $_SESSION['nivel']==3 or $_SESSION['nivel']==4){
											echo "<a class='topcuenta' id='cuenta' is='menu-link' href='#a_usuarios/editar_p' title='Mi cuenta'>Mi cuenta</a>";
										}
									?>
									<span class="mr-2 d-none d-lg-inline text-gray-600 small">|</span>
									<span class="mr-2 d-none d-lg-inline text-gray-600 small">
										<a onclick='salir()' href="#"class="topcuenta">Salir</a>
									</span>
									<img class="img-profile rounded-circle" src="<?php echo $_SESSION['foto']; ?>">
								</span>
							</span>
						</li>
					</ul>
				</nav>
				<main>
					<div id="contenido" class="container-fluid">
					</div>
				</main>
			</div>
		</div>

		<div class="loader loader-double is-active" id='cargando_div'></div>

		<div class="modal" tabindex="-1" role="dialog" id="myModal" data-keyboard="false" data-backdrop="static">
			<div class="modal-dialog modal-dialog-centered  modal-lg" role="document" id='modal_dispo'>
				<div class="modal-content" id='modal_form'>

				</div>
			</div>
		</div>

		<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

		<link rel="stylesheet" href="librerias15/jqueryconfirm/css/jquery-confirm.css">
		<script src="librerias15/jqueryconfirm/js/jquery-confirm.js"></script>

		<!-- Animation library for notifications   -->
		<link href="librerias15/animate.css" rel="stylesheet"/>

		<!-- WYSWYG   -->
		<link href="librerias15/summernote8.12/summernote.css" rel="stylesheet" type="text/css">
		<script src="librerias15/summernote8.12/summernote.js"></script>
		<script src="librerias15/summernote8.12/lang/summernote-es-ES.js"></script>

		<!--   Alertas   -->
		<script src="librerias15/swal/dist/sweetalert2.min.js"></script>

		<!--   para imprimir   -->
		<script src="librerias15/VentanaCentrada.js" type="text/javascript"></script>

		<!--   iconos   -->
		<link rel="preconnect" href="https://pro.fontawesome.com">
		<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

		<script src="sagyc.js"></script>
	</body>
</html>
