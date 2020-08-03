<?php
	require_once("db_.php");
	$idmodulo=$_REQUEST['id1'];

	$modulo=$db->modulo_editar($idmodulo);
	$track=$db->track_editar($modulo->idtrack);
	$terapia=$db->terapia_editar($track->idterapia);


	$pd = $db->actividad_lista($idmodulo);
?>


<nav aria-label='breadcrumb'>
	<ol class='breadcrumb'>
		<li class="breadcrumb-item" type="button" is="li-link" des="a_actividades/terapias" dix="trabajo" id1="">Inicio</lis>
		<li class="breadcrumb-item" type="button" is="li-link" des="a_actividades/track" dix="trabajo" title="Track" id1="<?php echo $terapia->id; ?>"><?php echo $terapia->nombre; ?></li>
		<li class="breadcrumb-item active" type="button" is="li-link" des="a_actividades/modulos" dix="trabajo" id1="<?php echo $track->id; ?>" ><?php echo $track->nombre; ?></li>
		<li class="breadcrumb-item active" type="button" is="li-link" des="a_actividades/actividades" dix="trabajo" id1="<?php echo $modulo->id; ?>" ><?php echo $modulo->nombre; ?></li>
	</ol>
</nav>

<div class="alert alert-warning text-center" role="alert">
	Actividades
	<button class="btn btn-warning btn-sm float-right" type="button" is="b-link" des="a_actividades/modulos" dix="trabajo" id1="<?php echo $track->id; ?>">Regresar</button>
</div>

<div class='container'>
	<div class='row'>


	<?php
		foreach($pd as $key){
	?>
			<div id='<?php echo $key->idactividad; ?>' class='col-4 p-3 w-50'>
				<div class='card' style='height:200px;'>
					<div class='card-header'>
						<?php echo $key->nombre; ?>
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
								<button class="btn btn-warning btn-block" type="button" is="b-link" des="a_actividades/actividad_ver" dix="trabajo" id1="<?php echo $key->idactividad; ?>">Ver</button>
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
					<button class="btn btn-warning btn-block" type="button" is="b-link" des="a_actividades_editar/actividad_editar" dix="trabajo" id1="0">Nueva actividad</button>
				</div>
			</div>
		</div>

	</div>
</div>
