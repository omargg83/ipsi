<?php
	require_once("../a_pacientes/db_.php");

	$idpaciente=$_REQUEST['idpaciente'];
	$idactividad=$_REQUEST['idactividad'];

	$proviene=$_REQUEST['proviene'];

  /////////////////////breadcrumb
  $paciente = $db->cliente_editar($idpaciente);
  $nombre_p=$paciente->nombre." ".$paciente->apellidop." ".$paciente->apellidom;
	$inicial=0;
	$idtrack="";
	$idmodulo="";

	$nombre="";
	$observaciones="";
	$indicaciones="";
	$tipo="";
	$visible="1";
	if($idactividad>0){
		$actividad=$db->actividad_editar($idactividad);
		$nombre=$actividad->nombre;
		$observaciones=$actividad->observaciones;
		$indicaciones=$actividad->indicaciones;
		$tipo=$actividad->tipo;
		$visible=$actividad->visible;
		$idgrupo=$actividad->idgrupo;
	}
	else{
		$idgrupo=clean_var($_REQUEST['idgrupo']);
	}

	$sql="SELECT * from grupo_actividad where idgrupo=$idgrupo";
	$sth = $db->dbh->query($sql);
	$grupo=$sth->fetch(PDO::FETCH_OBJ);
	if(strlen($grupo->idtrack)){

		$sql="select * from track where id=$grupo->idtrack";
		$sth = $db->dbh->query($sql);
		$track=$sth->fetch(PDO::FETCH_OBJ);

		$sql="select * from terapias where id=$track->idterapia";
		$sth = $db->dbh->query($sql);
		$terapia=$sth->fetch(PDO::FETCH_OBJ);

	}
	else{
		$sql="select * from modulo where id=$grupo->idmodulo";
		$sth = $db->dbh->query($sql);
		$modulo=$sth->fetch(PDO::FETCH_OBJ);

		$sql="select * from track where id=$modulo->idtrack";
		$sth = $db->dbh->query($sql);
		$track=$sth->fetch(PDO::FETCH_OBJ);

		$sql="select * from terapias where id=$track->idterapia";
		$sth = $db->dbh->query($sql);
		$terapia=$sth->fetch(PDO::FETCH_OBJ);
	}


?>


<nav aria-label='breadcrumb'>
 <ol class='breadcrumb'>
	<li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/lista" dix="trabajo">Pacientes</li>
	<li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/paciente" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo"><?php echo $nombre_p; ?></li>
	<?php
		echo "<li class='breadcrumb-item' id='lista_track' is='li-link' des='a_pacientes/terapias' v_idpaciente='$idpaciente' dix='trabajo'>Terapias</li>";
		echo "<li class='breadcrumb-item' id='lista_track' is='li-link' des='a_pacientes/track' dix='trabajo' v_idterapia='$terapia->id' v_idpaciente='$idpaciente'>$terapia->nombre</li>";
		echo "<li class='breadcrumb-item' id='lista_track' is='li-link' des='a_pacientes/modulos' dix='trabajo' v_idtrack='$track->id' v_idpaciente='$idpaciente'>$track->nombre</li>";

		if($proviene=="moduloscatalogo"){
			echo "<li class='breadcrumb-item' id='lista_track' is='li-link' des='a_pacientes/grupos' dix='trabajo' v_idgrupo='$grupo->idgrupo' v_idpaciente='$idpaciente'>$grupo->grupo</li>";

			echo "<li class='breadcrumb-item active' id='lista_track' is='li-link' des='a_pacientes_e/actividad_editar' dix='trabajo' v_idactividad='$idactividad' v_idpaciente='$idpaciente' v_proviene='$proviene' v_idtrack='$track->id'>$nombre</li>";
		}

		if($proviene=="nuevaactividad"){
		  echo "<li class='breadcrumb-item active' is='li-link' des='a_pacientes_e/inicial_agregar' dix='trabajo' v_idgrupo='$idgrupo' v_idpaciente='$idpaciente'>Agregar actividad inicial</li>";

			if($idactividad==0){
				echo "<li class='breadcrumb-item active' is='li-link' des='a_pacientes_e/actividad_editar' dix='trabajo' v_idgrupo='$idgrupo' v_idpaciente='$idpaciente' v_idactividad='0' v_proviene='$proviene'>Nueva actividad</li>";
			}
		}
		if($proviene=="actividadver"){
			if(strlen($grupo->idmodulo)){
				echo "<li class='breadcrumb-item' id='lista_track' is='li-link' des='a_pacientes/actividades' dix='trabajo' v_idmodulo='$modulo->id' v_idpaciente='$idpaciente'>$modulo->nombre</li>";
			}
			else{
				echo "<li class='breadcrumb-item' id='lista_track' is='li-link' des='a_pacientes/actividades' dix='trabajo' v_idgrupo='$grupo->idgrupo' v_idpaciente='$idpaciente'>$grupo->grupo</li>";
			}
			echo "<li class='breadcrumb-item' id='lista_track' is='li-link' des='a_pacientes_e/actividad_editar' dix='trabajo' v_idactividad='$idactividad' v_idpaciente='$idpaciente' v_proviene='$proviene'>$nombre</li>";
		}

		if($proviene=="actividades"){
			echo "<li class='breadcrumb-item' id='lista_track' is='li-link' des='a_pacientes/actividades' dix='trabajo' v_idmodulo='$modulo->id' v_idpaciente='$idpaciente'>$modulo->nombre</li>";
			echo "<li class='breadcrumb-item' id='lista_track' is='li-link' des='a_pacientes_e/actividad_editar' dix='trabajo' v_idactividad='$idactividad' v_idpaciente='$idpaciente' v_proviene='$proviene'>$nombre</li>";
		}
			///////////////////////////botones regresar
			if($proviene=="moduloscatalogo"){
				echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_pacientes/grupos' dix='trabajo' v_idgrupo='$idgrupo' v_idpaciente='$idpaciente'>Regresar</button>";
			}

			if($proviene=="nuevaactividad"){
				echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_pacientes_e/inicial_agregar' dix='trabajo' v_idgrupo='$idgrupo' v_idpaciente='$idpaciente'>Regresar</button>";
			}

			if($proviene=="actividadver"){
					echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_pacientes/actividad_ver' dix='trabajo' v_idactividad='$idactividad' v_idpaciente='$idpaciente' v_proviene='$proviene'>Regresar</button>";
			}

			if($proviene=="actividades"){
					echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_pacientes/actividades' dix='trabajo' v_idactividad='$idactividad' v_idpaciente='$idpaciente' v_idmodulo='$idmodulo' v_proviene='$proviene'>Regresar</button>";
			}

			if($proviene=="nuevaagregar"){
					echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_pacientes_e/actividad_agregar' dix='trabajo' v_idpaciente='$idpaciente' v_idmodulo='$idmodulo' v_proviene='$proviene'>Regresar</button>";
			}
			?>
   </ol>
  </nav>

	<div class='container'>
			<?php
				if($proviene=="nuevaactividad"){
					echo "<form is='f-submit' id='form_editaract' db='a_actividades/db_' fun='guarda_actividad' v_idpaciente='$idpaciente' des='a_pacientes/actividad_ver' desid='idactividad'>";
				}
				if($proviene=="moduloscatalogo"){
					echo "<form is='f-submit' id='form_editaract' db='a_actividades/db_' fun='guarda_actividad' v_idpaciente='$idpaciente'>";
				}

				if($proviene=="actividadver"){
					echo "<form is='f-submit' id='form_editaract' db='a_actividades/db_' fun='guarda_actividad' v_idpaciente='$idpaciente' des='a_pacientes/actividad_ver' desid='idactividad'>";
				}

				if($proviene=="actividades"){
					echo "<form is='f-submit' id='form_editaract' db='a_actividades/db_' fun='guarda_actividad' v_idpaciente='$idpaciente' v_idmodulo='$idmodulo' des='a_pacientes/actividades' desid='idactividad'>";
				}

				if($proviene=="nuevaagregar"){
					echo "<form is='f-submit' id='form_editaract' db='a_actividades/db_' fun='guarda_actividad' v_idpaciente='$idpaciente' v_idmodulo='$idmodulo' des='a_pacientes/actividad_ver' desid='idactividad'>";
				}

				echo "<input type='hidden' class='form-control' id='idgrupo' name='idgrupo' value='$idgrupo' readonly>";
				echo "<input type='hidden' class='form-control' id='idactividad' name='idactividad' value='$idactividad' readonly>";
				echo "<input type='hidden' class='form-control' id='idpaciente' name='idpaciente' value='$idpaciente' readonly>";
			?>


			<div class='card'>
				<div class="card-header">
					Editar actividad
				</div>
				<div class='card-body'>
					<div class='row'>
						<div class='col-12'>
							<label>Nombre de la actividad</label>
							<input type='text' class='form-control' id='nombre' name='nombre' placeholder='Nombre de la actividad' value='<?php echo $nombre; ?>' required>
						</div>
						<div class="col-3">
							<label>Tipo de terapia:</label>
							<select class='form-control' id='tipo' name='tipo'>
								<?php
									if($idactividad==0){
										echo "<option value='normal'>Normal</option>";
										echo "<option value='evaluacion'>Evaluacion</option>";
									}
									else{
										if($tipo=="normal"){
											echo "<option value='normal' selected>Normal</option>";
										}
										else{
											echo "<option value='evaluacion' selected>Evaluacion</option>";
										}
									}
								?>
							</select>
						</div>
						<div class="col-3">
							<label>Visible:</label>
							<select class='form-control' id='visible' name='visible'>
								<?php
									echo "<option value='1'"; if ($visible==1) { echo " selected"; } echo ">Mostrar</option>";
									echo "<option value='0'"; if ($visible==0) { echo " selected"; } echo ">Oculta</option>";
								?>
							</select>
						</div>
					</div>

					<div class='row'>
						<div class='col-12'>
							<label>Indicaciones</label>
							<textarea type='text' class='form-control' id='indicaciones' name='indicaciones' placeholder='Indicaciones' rows=10><?php echo $indicaciones; ?></textarea>
						</div>
						<div class='col-12'>
							<label>Observaciones</label>
							<textarea type='text' class='form-control' id='observaciones' name='observaciones' placeholder='Observaciones' rows=3><?php echo $observaciones; ?></textarea>
						</div>
					</div>
				</div>
				<div class='card-footer'>
					<div class='row'>
						<div class='col-12'>
								<button class='btn btn-warning'  type='submit'>Guardar</button>
								<?php
									if($proviene=="moduloscatalogo"){
										echo "<button class='btn btn-warning' type='button' is='b-link' des='a_pacientes/grupos' dix='trabajo' v_idgrupo='$idgrupo' v_idpaciente='$idpaciente'>Regresar</button>";
									}

									if($proviene=="nuevaactividad"){
										echo "<button class='btn btn-warning' type='button' is='b-link' des='a_pacientes_e/inicial_agregar' dix='trabajo' v_idgrupo='$idgrupo' v_idpaciente='$idpaciente'>Regresar</button>";
									}

									if($proviene=="actividadver"){
											echo "<button class='btn btn-warning' type='button' is='b-link' des='a_pacientes/actividad_ver' dix='trabajo' v_idactividad='$idactividad' v_idpaciente='$idpaciente' v_proviene='$proviene'>Regresar</button>";
									}

									if($proviene=="actividades"){
											echo "<button class='btn btn-warning' type='button' is='b-link' des='a_pacientes/actividades' dix='trabajo' v_idactividad='$idactividad' v_idpaciente='$idpaciente' v_idmodulo='$idmodulo' v_proviene='$proviene'>Regresar</button>";
									}

									if($proviene=="nuevaagregar"){
											echo "<button class='btn btn-warning' type='button' is='b-link' des='a_pacientes_e/actividad_agregar' dix='trabajo' v_idpaciente='$idpaciente' v_idmodulo='$idmodulo' v_proviene='$proviene'>Regresar</button>";
									}


								?>
						</div>
					</div>
				</div>
			</div>
		</form>
</div>
