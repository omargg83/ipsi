<?php
	require_once("../a_pacientes/db_.php");

	$idpaciente=$_REQUEST['idpaciente'];
	$idactividad=$_REQUEST['idactividad'];

  /////////////////////breadcrumb
  $paciente = $db->cliente_editar($idpaciente);
  $nombre_p=$paciente->nombre." ".$paciente->apellidop." ".$paciente->apellidom;
	$inicial=0;

	if(isset($_REQUEST['idmodulo'])){
		echo "entra";
		$idmodulo=$_REQUEST['idmodulo'];

		$sql="select * from modulo where id=:idmodulo";
		 $sth = $db->dbh->prepare($sql);
		$sth->bindValue(":idmodulo",$idmodulo);
		$sth->execute();
		$modulo=$sth->fetch(PDO::FETCH_OBJ);

		$sql="select * from track where id=:idtrack";
		$sth = $db->dbh->prepare($sql);
		$sth->bindValue(":idtrack",$modulo->idtrack);
		$sth->execute();
		$track=$sth->fetch(PDO::FETCH_OBJ);
		$idterapia=$track->idterapia;
	}
	if(isset($_REQUEST['idterapia'])){
		$idterapia=clean_var($_REQUEST['idterapia']);
		$inicial=1;
	}

	$nombre="Nueva actividad";
	$observaciones="";
	$indicaciones="";
	$tipo="";
	if($idactividad>0){
		$actividad=$db->actividad_editar($idactividad);
		$nombre=$actividad->nombre;
		$observaciones=$actividad->observaciones;
		$indicaciones=$actividad->indicaciones;
		$tipo=$actividad->tipo;
	}

  $sql="select * from terapias where id=:idterapia";
  $sth = $db->dbh->prepare($sql);
  $sth->bindValue(":idterapia",$idterapia);
  $sth->execute();
  $terapia=$sth->fetch(PDO::FETCH_OBJ);
?>


  <nav aria-label='breadcrumb'>
   <ol class='breadcrumb'>
  	 <li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/lista" dix="trabajo">Pacientes</li>
  	 <li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/paciente" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo"><?php echo $nombre_p; ?></li>
  	 <li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/terapias" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo">Terapias</li>
  	 <li class="breadcrumb-item" id='lista_track' is="li-link" des="a_pacientes/track" dix="trabajo" v_idterapia="<?php echo $terapia->id; ?>" v_idpaciente="<?php echo $idpaciente; ?>"><?php echo $terapia->nombre; ?></li>
		 	<?php
		 	if($inicial==0){
			?>
				<li class="breadcrumb-item" id='lista_track' is="li-link" des="a_pacientes/modulos" dix="trabajo" v_idtrack="<?php echo $track->id; ?>" v_idpaciente="<?php echo $idpaciente; ?>"><?php echo $track->nombre; ?></li>
		 		<li class="breadcrumb-item" id='lista_track' is="li-link" des="a_pacientes/actividades" dix="trabajo" v_idmodulo="<?php echo $modulo->id; ?>" v_idpaciente="<?php echo $idpaciente; ?>"><?php echo $modulo->nombre; ?></li>
				<li class="breadcrumb-item active" id='lista_track' is="li-link" des="a_pacientes_e/actividad_editar" dix="trabajo" v_idactividad="<?php echo $idactividad; ?>" v_idmodulo="<?php echo $idmodulo; ?>" v_idpaciente="<?php echo $idpaciente; ?>">Nueva actividad</li>
			<?php
			}
			else{
			?>
				<li class="breadcrumb-item active" id='lista_track' is="li-link" des="a_pacientes_e/actividad_editar" dix="trabajo" v_idactividad="<?php echo $idactividad; ?>" v_idterapia="<?php echo $idterapia; ?>" v_idpaciente="<?php echo $idpaciente; ?>">Nueva actividad</li>
			<?php
			}
			?>
   </ol>
  </nav>


	<div class='container'>
			<?php
				if(isset($modulo)){
					echo "<form is='f-submit' id='form_editaract' db='a_actividades/db_' fun='guarda_actividad' des='a_pacientes/actividades' v_idactividad='$idactividad' v_idpaciente='$idpaciente' v_idmodulo='$idmodulo'>";
					echo "<input type='hidden' class='form-control' id='idmodulo' name='idmodulo' value='$idmodulo;' readonly>";
			 	}
				else{
					echo "<form is='f-submit' id='form_editaract' db='a_actividades/db_' fun='guarda_actividad' des='a_pacientes/track' v_idactividad='$idactividad' v_idpaciente='$idpaciente' v_idterapia='$idterapia'>";
					echo "<input type='hidden' class='form-control' id='idterapia' name='idterapia' value='$idterapia;' readonly>";
				}
			?>
			<input type='hidden' class='form-control' id='idactividad' name='idactividad' value='<?php echo $idactividad; ?>' readonly>
			<input type='hidden' class='form-control' id='idpaciente' name='idpaciente' value='<?php echo $idpaciente; ?>' readonly>

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
								if($inicial==0){
									echo "<option value='normal' "; if($tipo=="normal"){ echo " selected";} echo ">Normal</option>";
									echo "<option value='evaluacion' "; if($tipo=="evaluacion"){ echo " selected";} echo ">Evaluacion</option>";
								}
								else{
									echo "<option value='inicial' "; if($tipo=="inicial"){ echo " selected";} echo ">Inicial</option>";
								}
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
									if($inicial==0){
										if($idactividad>0){
											echo "<button class='btn btn-warning' type='button' is='b-link' des='a_pacientes/actividades' v_idmodulo='$idmodulo' v_idpaciente='$idpaciente' dix='trabajo'>Regresar</button>";
										}
										else{
											echo "<button class='btn btn-warning' type='button' is='b-link' des='a_pacientes/paciente' v_idpaciente='$idpaciente' dix='trabajo'>Regresar</button>";
										}
									}
									else{
										echo "<button class='btn btn-warning' type='button' is='b-link' des='a_pacientes/track' dix='trabajo' v_idterapia='$idterapia' v_idpaciente='$idpaciente'>Regresar</button>";
									}

								?>
						</div>
					</div>
				</div>
			</div>
		</form>
</div>
