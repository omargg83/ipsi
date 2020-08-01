<?php
	require_once("db_.php");
	if(!isset($tipo_terapia)){
		$tipo_terapia="";
	}
	$pd = $db->actividad_lista($tipo_terapia);
?>
	<nav aria-label='breadcrumb'>
		<ol class='breadcrumb'>
			<li class="breadcrumb-item" type="button" is="li-link" des="a_actividades/lista" dix="trabajo" id1="">Actividades</lis>
		</ol>
	</nav>

	<div class='container'>


	<div class='row'>
		<div id='' class='col-4 p-3 w-50'>
			<div class="card" style='height:200px;'>
				<div class='card-body text-center'>
					<button class="btn btn-warning btn-block" type="button" is="b-link" des="a_actividades/actividad_editar" dix="trabajo" id1="0">Nueva actividad</button>
				</div>
			</div>
		</div>

	<?php
		foreach($pd as $key){
	?>
			<div id='<?php echo $key->idactividad; ?>' class='col-4 p-3 w-50'>
				<div class='card' style='height:200px;'>
					<div class='card-body'>
						<div class='row'>
							<div class='col-12'>
								<div><?php echo $key->nombre; ?></div>
								<div><?php echo $key->observaciones; ?></div>
								<div>#<?php echo $key->terapia; ?></div>
								<div>#<?php echo $key->track; ?></div>
							</div>
						</div>
					</div>
					<div class='card-body'>
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


	</div>
</div>
