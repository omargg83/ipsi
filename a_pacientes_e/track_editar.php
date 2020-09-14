<?php
	require_once("../a_pacientes/db_.php");

	$idtrack=clean_var($_REQUEST['idtrack']);
	$idterapia=clean_var($_REQUEST['idterapia']);
	$idpaciente=clean_var($_REQUEST['idpaciente']);


	//////////////breadcrumb
	$paciente = $db->cliente_editar($idpaciente);
  $nombre_p=$paciente->nombre." ".$paciente->apellidop." ".$paciente->apellidom;

	$sql="select * from terapias where id=:idterapia";
	$sth = $db->dbh->prepare($sql);
	$sth->bindValue(":idterapia",$idterapia);
	$sth->execute();
	$terapia=$sth->fetch(PDO::FETCH_OBJ);


  $nombre="Track nuevo";
	$video="";
	$descripcion="";

  if($idtrack>0){
		$pd = $db->track_editar($id1);
    $nombre=$pd->nombre;
    $video=$pd->video;
    $descripcion=$pd->descripcion;
  }
?>

<nav aria-label='breadcrumb'>
	<ol class='breadcrumb'>
		<li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/lista" dix="trabajo">Pacientes</li>
		<li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/paciente" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo"><?php echo $nombre_p; ?></li>
		<li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/terapias" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo">Terapias</li>
		<li class="breadcrumb-item" is="li-link" des="a_pacientes/track" dix="trabajo" title="Terapias" v_idterapia="<?php echo $idterapia; ?>" v_idpaciente="<?php echo $idpaciente; ?>"><?php echo $terapia->nombre; ?></li>
		<li class="breadcrumb-item active" is="li-link" des="a_pacientes_e/track_editar" dix="trabajo" title="Terapias" v_idtrack='<?php echo $idtrack; ?>' v_idterapia="<?php echo $idterapia; ?>" v_idpaciente="<?php echo $idpaciente; ?>">Nuevo track</li>
	</ol>
</nav>


<div class="container">
	<form is="f-submit" id="form_track" db="a_actividades/db_" fun="guardar_track" des="a_pacientes/track" v_idterapia="<?php echo $idterapia; ?>" v_idpaciente="<?php echo $idpaciente; ?>">

    <input type="hidden" name="idtrack" id="idtrack" value="<?php echo $idtrack;?>">
    <input type="hidden" name="idterapia" id="idterapia" value="<?php echo $idterapia;?>">
		<input type="hidden" name="idpaciente" id="idpaciente" value="<?php echo $idpaciente; ?>">
    <div class='card'>
			<div class='card-header'>
				Editar Track
			</div>
			<div class='card-body'>
				<div class='row'>
					<div class="col-12">
						<label>Nombre:</label>
							<input type="text" class="form-control form-control-sm" name="nombre" id="nombre" value="<?php echo $nombre;?>" placeholder="Nombre" maxlength="100" required >
					</div>
					<div class="col-12">
						<label>Descripción:</label>
            <textarea rows="5" name='descripcion' id='descripcion' class="form-control form-control-sm"><?php echo $descripcion; ?></textarea>
					</div>

			  </div>
				<div class='row'>
					<div class="col-12">
						<label>Video:</label>
						<textarea rows="5" name='video' id='video' class="form-control form-control-sm"><?php echo $video; ?></textarea>
					</div>
			  </div>
			</div>
			<div class='card-footer'>
				<div class="row">
					<div class="col-sm-12">
						<button class="btn btn-warning" type="submit">Guardar</button>
            <button class="btn btn-warning" type="button" is="b-link" des='a_actividades/track' id1="<?php echo $idterapia; ?>" dix='trabajo'>Regresar</button>
					</div>
				</div>
			</div>
		</div>
  </form>
</div>
