<?php
	require_once("db_.php");
	$idterapia=clean_var($_REQUEST['idterapia']);
  $track=$db->track($idterapia);
  $terapia=$db->terapia_editar($idterapia);
?>

<nav aria-label='breadcrumb'>
  <ol class='breadcrumb'>
    <li class="breadcrumb-item" type="button" is="li-link" des="a_actividades/terapias" dix="trabajo" title="Inicio" id1="">Inicio</li>
    <li class="breadcrumb-item active" type="button" is="li-link" des="a_actividades/track" dix="trabajo" title="Terapias" v_idterapia="<?php echo $idterapia; ?>"><?php echo $terapia->nombre; ?></li>
		<button class="btn btn-warning btn-sm float-right" type="button" is="b-link" des="a_actividades/terapias" dix="trabajo" id1="">Regresar</button>
  </ol>
</nav>

<div class="alert alert-warning text-center" role="alert">
  Track
</div>

<div class='container'>
  <div class='row'>
  	<?php
  	foreach($track as $key){
  	?>
  		<div class='col-4 p-3 w-50'>
  			<div class='card' style='height:200px;'>
  				<div class='card-header'>
						<?php echo $key->nombre; ?>

						<button class="btn btn-warning btn-sm float-right" type="button" is="b-link" des="a_actividades/track" dix="trabajo" db="a_actividades/db_" fun="borrar_track" v_idtrack="<?php echo $key->id; ?>" v_idterapia="<?php echo $idterapia; ?>" tp="¿Desea eliminar el track seleccionado?" title="Borrar"><i class="far fa-trash-alt"></i></button>

						<button class="btn btn-warning btn-sm float-right" type="button" is="b-link" des="a_actividades_e/track_editar" dix="trabajo" v_idtrack="<?php echo $key->id; ?>" v_idterapia="<?php echo $idterapia; ?>"><i class="fas fa-pencil-alt"></i></button>
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
  							<button class="btn btn-warning btn-block" type="button" is="b-link" des="a_actividades/modulos" dix="trabajo" v_idtrack="<?php echo $key->id; ?>" v_idterapia="<?php echo $idterapia; ?>">Ver</button>
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
          <button class="btn btn-warning btn-block" type="button" is="b-link" des="a_actividades_e/track_editar" dix="trabajo" v_idtrack="0" v_idterapia="<?php echo $idterapia; ?>">Nuevo track</button>
        </div>
      </div>
    </div>
  </div>
	<hr>

	<div class="alert alert-warning text-center" role="alert">
	  Actividad inicial
	</div>
	<div class='container'>
	  <div class='row'>
			<?php
			$actividad=$db->actividad_inicial($idterapia);
			foreach($actividad as $key){
			?>
				<div class='col-4 p-3 w-50'>
					<div class='card' style='height:200px;'>
						<div class='card-header'>
							<?php echo $key->nombre; ?>

							<button class="btn btn-warning btn-sm float-right" type="button" is="b-link" des="a_actividades/track" dix="trabajo" db="a_actividades/db_" fun="borrar_actividad" v_idactividad="<?php echo $key->idactividad; ?>" v_idterapia="<?php echo $idterapia; ?>" tp="¿Desea eliminar la actividad inicial seleccionada?" title="Borrar"><i class="far fa-trash-alt"></i></button>

							<button class="btn btn-warning btn-sm float-right" type="button" is="b-link" des="a_actividades_e/actividad_editar" dix="trabajo" v_idactividad="<?php echo $key->idactividad; ?>" v_idterapia="<?php echo $idterapia; ?>"><i class="fas fa-pencil-alt"></i></button>
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
									<button class="btn btn-warning btn-block" type="button" is="b-link" des="a_actividades/actividad_ver" dix="trabajo" v_idactividad="<?php echo $key->idactividad; ?>" v_idterapia="<?php echo $idterapia; ?>">Ver</button>
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
	          <button class="btn btn-warning btn-block" type="button" is="b-link" des="a_actividades_e/actividad_editar" dix="trabajo" v_idactividad="0" v_idterapia='<?php echo $idterapia; ?>'>Nueva Actividad inicial</button>
	        </div>
	      </div>
	    </div>

		</div>
	</div>
