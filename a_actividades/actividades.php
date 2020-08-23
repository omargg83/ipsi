<?php
	require_once("db_.php");
	$idmodulo=$_REQUEST['idmodulo'];

	$modulo=$db->modulo_editar($idmodulo);
	$track=$db->track_editar($modulo->idtrack);
	$terapia=$db->terapia_editar($track->idterapia);
	$pd = $db->actividad_lista($idmodulo);
?>

<nav aria-label='breadcrumb'>
	<ol class='breadcrumb'>
		<li class="breadcrumb-item" type="button" is="li-link" des="a_actividades/terapias" dix="trabajo" id1="">Inicio</lis>
		<li class="breadcrumb-item" type="button" is="li-link" des="a_actividades/track" dix="trabajo" title="Track" v_idterapia="<?php echo $terapia->id; ?>"><?php echo $terapia->nombre; ?></li>
		<li class="breadcrumb-item" type="button" is="li-link" des="a_actividades/modulos" dix="trabajo" v_idtrack="<?php echo $track->id; ?>" ><?php echo $track->nombre; ?></li>
		<li class="breadcrumb-item active" type="button" is="li-link" des="a_actividades/actividades" dix="trabajo" v_idmodulo="<?php echo $modulo->id; ?>" ><?php echo $modulo->nombre; ?></li>
		<button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_actividades/modulos" dix="trabajo" v_idtrack="<?php echo $track->id; ?>">Regresar</button>
	</ol>
</nav>

<div class="alert alert-warning text-center tituloventana" role="alert">
	Actividades

</div>

<div class='container'>
	<div class='row'>


	<?php
		foreach($pd as $key){
	?>
<div id='<?php echo $key->idactividad; ?>' class='col-4 p-3 w-50 actcard'>
				<div class='card'>
				<img style="vertical-align: bottom;border-radius: 10px;max-width: 70px;margin: 0 auto;padding: 10px;" src="img/lapiz.png">	
					<div class='card-header'>
						<?php echo $key->nombre; ?>

						<button class="btn btn-warning btn-sm float-right" type="button" is="b-link" des="a_actividades/actividades" dix="trabajo" db="a_actividades/db_" fun="borrar_actividad" v_idactividad="<?php echo $key->idactividad; ?>" v_idmodulo="<?php echo $idmodulo; ?>" tp="¿Desea eliminar la actividad seleccionada?" title="Borrar"><i class="far fa-trash-alt"></i></button>

						<button class="btn btn-warning btn-sm float-right" type="button" is="b-link" des="a_actividades_e/actividad_editar" dix="trabajo" v_idactividad="<?php echo $key->idactividad; ?>" v_idmodulo="<?php echo $idmodulo; ?>"><i class="fas fa-pencil-alt"></i></button>
					</div>
					<div class='card-body'>
						<div class='row'>
							<div class='col-12'>
								<?php echo $key->observaciones; ?>
							</div>
						</div>
					</div>
					<div class='card-footer'>
						<div class='row'>
							<div class='col-12'>
								<button class="btn btn-warning btn-block" type="button" is="b-link" des="a_actividades/actividad_ver" dix="trabajo" v_idactividad="<?php echo $key->idactividad; ?>">Ver</button>
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
					<button class="btn btn-warning btn-block" type="button" is="b-link" des="a_actividades_e/actividad_editar" dix="trabajo" v_idactividad="0" v_idmodulo="<?php echo $idmodulo; ?>" >Nueva actividad</button>
				</div>
			</div>
		</div>
	</div>
</div>
