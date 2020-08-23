<?php
	require_once("db_.php");
	$idterapia=$_REQUEST['idterapia'];
	$idpaciente=$_REQUEST['idpaciente'];

	/////////////////////breadcrumb
	$paciente = $db->cliente_editar($idpaciente);
	$nombre=$paciente->nombre." ".$paciente->apellidop." ".$paciente->apellidom;

	$sql="select * from terapias where id=:idterapia";
	$sth = $db->dbh->prepare($sql);
	$sth->bindValue(":idterapia",$idterapia);
	$sth->execute();
	$terapia=$sth->fetch(PDO::FETCH_OBJ);

	///////////////////////CODIGO
	 $sql="SELECT * from track_per
	 left outer join track on track.id=track_per.idtrack where track_per.idpaciente=:id and track.idterapia=:idterapia";
	$sth = $db->dbh->prepare($sql);
	$sth->bindValue(":id",$idpaciente);
	$sth->bindValue(":idterapia",$idterapia);
	$sth->execute();
	$track=$sth->fetchAll(PDO::FETCH_OBJ);

?>

<nav aria-label='breadcrumb'>
	<ol class='breadcrumb'>
		<li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/lista" dix="trabajo">Pacientes</li>
		<li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/paciente" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo"><?php echo $nombre; ?></li>
		<li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/terapias" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo">Terapias</li>
		<li class="breadcrumb-item active" type="button" is="li-link" des="a_pacientes/track" dix="trabajo" title="Terapias" v_idterapia="<?php echo $idterapia; ?>" v_idpaciente="<?php echo $idpaciente; ?>"><?php echo $terapia->nombre; ?></li>
		<button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_pacientes/terapias" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo">Regresar</button>
	</ol>
</nav>


<div class="alert alert-warning text-center" role="alert">
	Tracks
</div>

<div class='container'>
	<div class='row'>
		<?php
		///////////////////////CODIGO
		 $sql="SELECT * from actividad_per
		 left outer join actividad on actividad.idactividad=actividad_per.idactividad where actividad_per.idpaciente=:id and actividad.idterapia=:idterapia";
		$sth = $db->dbh->prepare($sql);
		$sth->bindValue(":id",$idpaciente);
		$sth->bindValue(":idterapia",$idterapia);
		$sth->execute();
		$inicial=$sth->fetchAll(PDO::FETCH_OBJ);

		foreach($inicial as $key){
		?>
			<div class='col-4 p-3 w-50'>
				<div class='card' style='height:200px;'>
					<div class='card-header'>
						<?php echo $key->nombre; ?>

						<button class="btn btn-warning btn-sm float-right" type="button" is="b-link" des="a_pacientes/track" dix="trabajo" db="a_pacientes/db_" fun="quitar_actividad" v_idactividad="<?php echo $key->idactividad; ?>" v_idpaciente="<?php echo $idpaciente; ?>" v_idterapia="<?php echo $idterapia; ?>" tp="¿Desea quitar la actividad inicial seleccionada?" title="Borrar"><i class="far fa-trash-alt"></i></button>

					</div>
					<div class='card-body'>
						<div class='row'>
							<div class='col-12'>
								<?php echo $key->observaciones; ?>
							</div>
						</div>
					</div>
					<div class='card-body'>
						<div class='row'>
							<div class='col-12'>
								<button class="btn btn-warning btn-block" type="button" is="b-link" des="a_pacientes/actividad_ver" dix="trabajo" v_idactividad="<?php echo $key->idactividad; ?>" v_idterapia="<?php echo $idterapia; ?>" v_idpaciente='<?php echo $idpaciente; ?>'>Ver</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php
		}
		?>


  	<?php
  	foreach($track as $key){
  	?>
  		<div class='col-4 p-3 w-50'>
  			<div class='card' style='height:200px;'>
  				<div class='card-header'>
						<?php echo $key->nombre; ?>

						<button class="btn btn-warning btn-sm float-right" type="button" is="b-link" des="a_pacientes/track" dix="trabajo" db="a_pacientes/db_" fun="quitar_track" v_idtrack="<?php echo $key->id; ?>" v_idpaciente="<?php echo $idpaciente; ?>" v_idterapia="<?php echo $idterapia; ?>" tp="¿Desea quitar el track seleccionado?" title="Borrar"><i class="far fa-trash-alt"></i></button>
					</div>
  				<div class='card-body'>
  					<div class='row'>
  						<div class='col-12'>
  							<?php echo $key->descripcion; ?>
  						</div>
  					</div>
  				</div>
  				<div class='card-body'>
  					<div class='row'>
  						<div class='col-12'>
  							<button class="btn btn-warning btn-block" type="button" is="b-link" des="a_pacientes/modulos" dix="trabajo" v_idtrack="<?php echo $key->id; ?>" v_idpaciente="<?php echo $idpaciente; ?>">Ver</button>
  						</div>
  					</div>
  				</div>
  			</div>
  		</div>
  	<?php
  	}
  	?>
		<div id='' class='col-4 p-3 w-50'>
			<div class="card" style='height:200px;'>
				<div class='card-body text-center'>
					<button class="btn btn-warning btn-block" type="button" is="b-link" des="a_pacientes_e/inicial_agregar" dix="trabajo" v_idterapia="<?php echo $idterapia; ?>" v_idpaciente='<?php echo $idpaciente; ?>'>Agregar Actividad inicial</button>
				</div>
			</div>
		</div>


		<div id='' class='col-4 p-3 w-50'>
      <div class="card" style='height:200px;'>
        <div class='card-body text-center'>
          <button class="btn btn-warning btn-block" type="button" is="b-link" des="a_pacientes_e\track_agregar" dix="trabajo" v_idtrack="0" v_idterapia="<?php echo $idterapia; ?>" v_idpaciente='<?php echo $idpaciente; ?>'>Agregar track</button>
        </div>
      </div>
    </div>
  </div>
</div>
