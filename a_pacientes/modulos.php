<?php
	require_once("db_.php");
	$idtrack=$_REQUEST['idtrack'];
	$idpaciente=$_REQUEST['idpaciente'];

	/////////////////////breadcrumb
	$paciente = $db->cliente_editar($idpaciente);
	$nombre=$paciente->nombre." ".$paciente->apellidop." ".$paciente->apellidom;

	$sql="select * from track where id=:idtrack";
	$sth = $db->dbh->prepare($sql);
	$sth->bindValue(":idtrack",$idtrack);
	$sth->execute();
	$track=$sth->fetch(PDO::FETCH_OBJ);

	$sql="select * from terapias where id=:idterapia";
	$sth = $db->dbh->prepare($sql);
	$sth->bindValue(":idterapia",$track->idterapia);
	$sth->execute();
	$terapia=$sth->fetch(PDO::FETCH_OBJ);

	///////////////////////CODIGO
	$sql="SELECT * from modulo_per left outer join modulo on modulo.id=modulo_per.idmodulo where modulo_per.idpaciente=:id and modulo.idtrack=:idtrack";
	$sth = $db->dbh->prepare($sql);
	$sth->bindValue(":id",$idpaciente);
	$sth->bindValue(":idtrack",$idtrack);
	$sth->execute();
	$modulos=$sth->fetchAll(PDO::FETCH_OBJ);
?>

<nav aria-label='breadcrumb'>
 <ol class='breadcrumb'>
	 <li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/lista" dix="trabajo">Pacientes</li>
	 <li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/paciente" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo"><?php echo $nombre; ?></li>
	 <li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/terapias" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo">Terapias</li>
	 <li class="breadcrumb-item" id='lista_track' is="li-link" des="a_pacientes/track" dix="trabajo" v_idterapia="<?php echo $terapia->id; ?>" v_idpaciente="<?php echo $idpaciente; ?>"><?php echo $terapia->nombre; ?></li>
	 <li class="breadcrumb-item active" id='lista_track' is="li-link" des="a_pacientes/modulos" dix="trabajo" v_idtrack="<?php echo $idtrack; ?>" v_idpaciente="<?php echo $idpaciente; ?>"><?php echo $track->nombre; ?></li>
	 <button class="btn btn-warning btn-sm " type="button" is="b-link" des="a_pacientes/track" dix="trabajo" v_idterapia="<?php echo $terapia->id; ?>" v_idpaciente="<?php echo $idpaciente; ?>">Regresar</button>
 </ol>
</nav>

 <div class="alert alert-warning text-center tituloventana" role="alert">
   Mis Modulos
 </div>

<div class='container'>
  <div class='row'>
		<?php
		///////////////////////CODIGO
		 $sql="SELECT * from actividad_per
		 left outer join actividad on actividad.idactividad=actividad_per.idactividad where actividad_per.idpaciente=:id and actividad.idtrack=:idtrack";
		$sth = $db->dbh->prepare($sql);
		$sth->bindValue(":id",$idpaciente);
		$sth->bindValue(":idtrack",$idtrack);
		$sth->execute();
		$inicial=$sth->fetchAll(PDO::FETCH_OBJ);

		foreach($inicial as $key){
		?>
			<div class='col-4 p-3 w-50 actcard'>
  			<div class='card'>
					<img style="vertical-align: bottom;border-radius: 10px;max-width: 70px;margin: 0 auto;padding: 10px;" src="img/lapiz.png">
					<div class='card-header'>
						<?php echo $key->nombre; ?>

						<button class="btn btn-warning btn-sm float-right" type="button" is="b-link" des="a_pacientes/modulos" dix="trabajo" db="a_pacientes/db_" fun="quitar_actividad" v_idactividad="<?php echo $key->idactividad; ?>" v_idpaciente="<?php echo $idpaciente; ?>" v_idtrack="<?php echo $idtrack; ?>" tp="¿Desea quitar la actividad inicial seleccionada?" title="Borrar"><i class="far fa-trash-alt"></i></button>

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
  	foreach($modulos as $key){
  ?>
  		<div class='col-4 p-3 w-50 actcard'>
  			<div class='card'>
					<img style="vertical-align: bottom;border-radius: 10px;max-width: 70px;margin: 0 auto;padding: 10px;" src="img/lapiz.png">
					<div class="card-header">
						<?php echo $key->nombre; ?>

						<button class="btn btn-warning btn-sm float-right" type="button" is="b-link" des="a_pacientes/modulos" dix="trabajo" db="a_pacientes/db_" fun="quitar_modulo" v_idmodulo="<?php echo $key->id; ?>" v_idtrack="<?php echo $idtrack; ?>"  v_idpaciente="<?php echo $idpaciente; ?>"  tp="¿Desea quitar el modulo seleccionado?" title="Borrar"><i class="far fa-trash-alt"></i></button>
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
  							<button class="btn btn-warning btn-block" type="button" is="b-link" des="a_pacientes/actividades" dix="trabajo" v_idmodulo="<?php echo $key->id; ?>"  v_idpaciente="<?php echo $idpaciente; ?>">Ver</button>
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
					<button class="btn btn-warning btn-block" type="button" is="b-link" des="a_pacientes_e/inicial_agregar" dix="trabajo" v_idtrack="<?php echo $idtrack; ?>" v_idpaciente='<?php echo $idpaciente; ?>'>Agregar Actividad inicial</button>
				</div>
			</div>
		</div>


		<div id='' class='col-4 p-3 w-50'>
      <div class="card" style='height:200px;'>
        <div class='card-body text-center'>
          <button class="btn btn-warning btn-block" type="button" is="b-link" des="a_pacientes_e/modulos_agregar" dix="trabajo" v_idmodulo="0" v_idtrack="<?php echo $idtrack; ?>"  v_idpaciente="<?php echo $idpaciente; ?>" >Nuevo modulo</button>
        </div>
      </div>
    </div>
  </div>
</div>
