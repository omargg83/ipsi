<?php
	require_once("../a_pacientes/db_.php");

	$idactividad=clean_var($_REQUEST['idactividad']);
	$idpaciente=clean_var($_REQUEST['idpaciente']);

	$paciente = $db->cliente_editar($idpaciente);
	$nombre_p=$paciente->nombre." ".$paciente->apellidop." ".$paciente->apellidom;


	if($idactividad>0){
		$idmodulo=clean_var($_REQUEST['idmodulo']);
		$sql="select * from actividad where idactividad=:idactividad";
		$sth = $db->dbh->prepare($sql);
		$sth->bindValue(":idactividad",$idactividad);
		$sth->execute();
		$actividad=$sth->fetch(PDO::FETCH_OBJ);

		$sql="select * from modulo where id=:idmodulo";
		$sth = $db->dbh->prepare($sql);
		$sth->bindValue(":idmodulo",$actividad->idmodulo);
		$sth->execute();
		$modulo=$sth->fetch(PDO::FETCH_OBJ);

		$sql="select * from track where id=:idtrack";
		$sth = $db->dbh->prepare($sql);
		$sth->bindValue(":idtrack",$modulo->idtrack);
		$sth->execute();
		$track=$sth->fetch(PDO::FETCH_OBJ);

		$sql="select * from terapias where id=:idterapia";
		$sth = $db->dbh->prepare($sql);
		$sth->bindValue(":idterapia",$track->idterapia);
		$sth->execute();
		$terapia=$sth->fetch(PDO::FETCH_OBJ);

		$cuest=$db->actividad_editar($idactividad);
		$nombre=$cuest->nombre;
		$observaciones=$cuest->observaciones;
		$indicaciones=$cuest->indicaciones;
		$tipo=$cuest->tipo;

	}
	else{
		$nombre="Nueva actividad";
		$observaciones="";
		$indicaciones="";
		$tipo="";
	}

	$sql="select modulo.id, modulo.nombre as modulo, track.nombre as track, terapias.nombre as terapia from modulo
	left outer join track on track.id=modulo.idtrack
	left outer join terapias on terapias.id=track.idterapia order by terapias.nombre asc, track.nombre asc, modulo.nombre asc";
	$sth = $db->dbh->prepare($sql);
	$sth->execute();
	$modulo_p=$sth->fetchAll(PDO::FETCH_OBJ);
?>

<nav aria-label='breadcrumb'>
 <ol class='breadcrumb'>
	 <li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/lista" dix="trabajo">Pacientes</li>
	 <li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/paciente" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo"><?php echo $nombre_p; ?></li>
	<?php
		if($idactividad>0){
	?>
		<li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/terapias" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo">Terapias</li>
 		<li class="breadcrumb-item" id='lista_track' is="li-link" des="a_pacientes/track" dix="trabajo" v_idterapia="<?php echo $terapia->id; ?>" v_idpaciente="<?php echo $idpaciente; ?>"><?php echo $terapia->nombre; ?></li>
 		<li class="breadcrumb-item" id='lista_track' is="li-link" des="a_pacientes/modulos" dix="trabajo" v_idtrack="<?php echo $track->id; ?>" v_idpaciente="<?php echo $idpaciente; ?>"><?php echo $track->nombre; ?></li>
 		<li class="breadcrumb-item active" id='lista_track' is="li-link" des="a_pacientes/actividades" dix="trabajo" v_idmodulo="<?php echo $idmodulo; ?>" v_idpaciente="<?php echo $idpaciente; ?>"><?php echo $modulo->nombre; ?></li>
	<?php
		}
	?>

 </ol>
</nav>

<div class='container'>
		<form is="f-submit" id="form_editaract" db="a_actividades/db_" fun="guarda_actividad" des="a_pacientes/actividad_ver" desid="idactividad" v_idactividad="<?php echo $idactividad; ?>" v_idpaciente="<?php echo $idpaciente; ?>">
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
						<div class="col-12">
							<label>Modulo:</label>
							<select class='form-control' id='idmodulo' name='idmodulo'>
								<?php
									foreach($modulo_p as $key){
										echo "<option value='$key->id'"; if($tipo=="normal"){ echo " selected";} echo ">$key->terapia - $key->track - $key->modulo</option>";
									}
								?>
							</select>
						</div>

						<div class="col-3">
							<label>Tipo de terapia:</label>
							<select class='form-control' id='tipo' name='tipo'>
								<option value='normal' <?php if($tipo=="normal"){ echo " selected";} ?>>Normal</option>
								<option value='evaluacion' <?php if($tipo=="evaluacion"){ echo " selected";} ?>>Evaluacion</option>
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
									if($idactividad>0){
								?>
									<button class="btn btn-warning" type="button" is="b-link" des='a_pacientes/actividades' v_idmodulo="<?php echo $idmodulo; ?>" v_idpaciente="<?php echo $idpaciente; ?>" dix='trabajo'>Regresar</button>
								<?php
									}
									else{
								?>
									<button class="btn btn-warning" type="button" is="b-link" des='a_pacientes/paciente' v_idpaciente="<?php echo $idpaciente; ?>" dix='trabajo'>Regresar</button>
								<?php
									}
								?>
						</div>
					</div>
				</div>
			</div>
		</form>
</div>
