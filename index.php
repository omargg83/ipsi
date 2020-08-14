<?php
	require_once("db_.php");
	if(!isset($_SESSION['idusuario']) and strlen($_SESSION['idusuario'])==0){
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
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.5.5/dist/css/uikit.min.css" />
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="index.php">IPSI</a>

            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ml-auto ml-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#">Settings</a>
                        <a class="dropdown-item" href="#">Activity Log</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="login.html">Logout</a>
                    </div>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
													<div class="sb-sidenav-menu-heading">Inicio</div>

														------------
														<?php
															if($_SESSION['tipo_user'] == "Paciente"){

																$sql="select terapias.* from actividad
															  left outer join modulo on modulo.id=actividad.idmodulo
															  left outer join track on track.id=modulo.idtrack
															  left outer join terapias on terapias.id=track.idterapia
															  where actividad.idpaciente=:id group by terapias.id";
															  $sth_te = $db->dbh->prepare($sql);
															  $sth_te->bindValue(":id",$_SESSION['idusuario']);
															  $sth_te->execute();

															  foreach($sth_te->fetchAll(PDO::FETCH_OBJ) as $terapia){
																	echo "<div>";
																	echo "<a>".$terapia->nombre."</a>";
																	echo "</div>";

																	$sql="select track.* from actividad
																	left outer join modulo on modulo.id=actividad.idmodulo
																	left outer join track on track.id=modulo.idtrack
																	where actividad.idpaciente=:id and track.idterapia=:idterapia group by track.id";
																	$sth_tr = $db->dbh->prepare($sql);
																	$sth_tr->bindValue(":id",$_SESSION['idusuario']);
																	$sth_tr->bindValue(":idterapia",$terapia->id);
																	$sth_tr->execute();
																	foreach($sth_tr->fetchAll(PDO::FETCH_OBJ) as $track){
																		echo "<div>";
																		echo "--><a>".$track->nombre."</a>";
																		echo "</div>";

																		$sql="select modulo.* from actividad
																		left outer join modulo on modulo.id=actividad.idmodulo
																		where actividad.idpaciente=:id and modulo.idtrack=:idtrack group by modulo.id";
																		$sth_mo = $db->dbh->prepare($sql);
																		$sth_mo->bindValue(":id",$_SESSION['idusuario']);
																		$sth_mo->bindValue(":idtrack",$track->id);
																		$sth_mo->execute();
																		foreach($sth_mo->fetchAll(PDO::FETCH_OBJ) as $modulo){
																			echo "<div>";
																			echo "----><a>".$modulo->nombre."</a>";
																			echo "</div>";

																			$sql="select * from actividad
																			where actividad.idpaciente=:id and actividad.idmodulo=:idmodulo";
																			$sth_a = $db->dbh->prepare($sql);
																			$sth_a->bindValue(":id",$_SESSION['idusuario']);
																			$sth_a->bindValue(":idmodulo",$modulo->id);
																			$sth_a->execute();
																			foreach($sth_a->fetchAll(PDO::FETCH_OBJ) as $actividad){
																				echo "<div>";
																				echo "------><a href='#a_respuesta/index' is='menu-link' v_idactividad='$actividad->idactividad'>".$actividad->nombre."</a>";
																				echo "</div>";
																			}
																		}
																	}
																}
														?>
															------------
															<!---
																<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#demo1" aria-expanded="false" aria-controls="demo1">
																	<div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
																	Terapias 2
																	<div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
															</a>
															<div class="collapse" id="demo1" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
																	<nav class="sb-sidenav-menu-nested nav">
																		<a class='nav-link' is='menu-link' id1='$terapias->nombre' href='#a_actividades/index'>Terapia</a>
																	</nav>
															</div>
															--->

															<a class="nav-link" is='menu-link' href='#a_usuarios/index' title='Usuarios'><div class="sb-nav-link-icon"><i class="fas fa-user-alt"></i></div>Expediente</a>
															<a class="nav-link" is='menu-link' href='#a_usuarios/index' title='Usuarios'><div class="sb-nav-link-icon"><i class="fas fa-user-alt"></i></div>Relaciones</a>
															<a class="nav-link" is='menu-link' href='#a_usuarios/index' title='Usuarios'><div class="sb-nav-link-icon"><i class="fas fa-user-alt"></i></div>Agenda</a>

															<a class="nav-link" is='menu-link' href='#a_usuarios/index' title='Usuarios'><div class="sb-nav-link-icon"><i class="fas fa-user-alt"></i></div>Mi cuenta</a>
														<?php
															}
															if($_SESSION['tipo_user'] == "Psicólogo" and $_SESSION['nivel']==2){
														?>
																<a class="nav-link" is='menu-link' href='#a_pacientes/index' title='Pacientes'><div class="sb-nav-link-icon"><i class='far fa-file-alt'></i></div>Mis Pacientes</a>
																<a class="nav-link" is='menu-link' href='#a_usuarios/index' title='Usuarios'><div class="sb-nav-link-icon"><i class='far fa-file-alt'></i></div>Agenda</a>
																<a class="nav-link" is='menu-link' href='#a_usuarios/index' title='Usuarios'><div class="sb-nav-link-icon"><i class="fas fa-user-alt"></i></div>Mi cuenta</a>

																<div class="sb-sidenav-menu-heading">Terapias</div>
																<a class="nav-link" is='menu-link' href='#a_actividades/index' title='Actividades'><div class="sb-nav-link-icon"><i class='far fa-file-alt'></i></div>Catalogo Terapias</a>

														<?php
															}
															if($_SESSION['tipo_user'] == "Psicólogo" and $_SESSION['nivel']==1){
														?>
															<a class="nav-link" is='menu-link' href='#a_pacientes/index' title='Pacientes'><div class="sb-nav-link-icon"><i class="far fa-file-alt"></i></div>Pacientes</a>
															<a class="nav-link" is='menu-link' href='#a_usuarios/index' title='Usuarios'><div class="sb-nav-link-icon"><i class="fas fa-user-alt"></i></div>Cuentas</a>
															<div class="sb-sidenav-menu-heading">Terapias</div>
															<a class="nav-link" is='menu-link' href='#a_actividades/index' title='Actividades'><div class="sb-nav-link-icon"><i class='far fa-file-alt'></i></div>Catalogo Terapias</a>
														<?php
															}
														?>


                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <a onclick='salir()' href='#' class="btn btn-warning btn-block"><i class="fas fa-sign-out-alt"></i>Salir</a>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div id="contenido" class="container-fluid">
                    </div>
                </main>
            </div>
        </div>

        <div class="loader loader-default is-active" id='cargando_div' data-text="Cargando"></div>

        <div class="modal animated fadeInDown" tabindex="-1" role="dialog" id="myModal" data-keyboard="false" data-backdrop="static">
          <div class="modal-dialog modal-dialog-centered  modal-lg" role="document" id='modal_dispo'>
            <div class="modal-content" id='modal_form'>

            </div>
          </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>

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

        <!--   Boostrap   -->
        <link href="https://fonts.googleapis.com/css2?family=Baloo+Paaji+2&display=swap" rel="stylesheet">

        <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.5/dist/js/uikit.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.5/dist/js/uikit-icons.min.js"></script>

        <script src="librerias15/js/bootstrap.js"></script>

        <!--   Propios   -->
        <script src="sagyc.js"></script>
        <script src="vainilla.js"></script>
    </body>
</html>
