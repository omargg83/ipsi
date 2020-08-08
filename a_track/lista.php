<?php
	require_once("db_.php");
	$pd = $db->track_lista();
?>
	<nav aria-label='breadcrumb'>
		<ol class='breadcrumb'>
			<li class='breadcrumb-item' id='lista_track' is="li-link" des="a_track/lista" dix="trabajo" id1="">Track</li>
		</ol>
	</nav>


	<div class='container'>
		<div class='row'>
			<?php
				foreach($pd as $key){
			?>
					<div id='<?php echo $key->id; ?>' class='col-3 edit-t mb-3'>
						<div class='card '>
							<div class='card-body'>
								<div class='text-center'><?php echo $key->nombre; ?></div>
							</div>
							<div class='card-footer'>
								<div class='row'>
									<div class='col-12'>
											<button class='btn btn-warning' type="button" is="b-link" des='a_track/editar' dix='trabajo' id1='<?php echo $key->id; ?>' title='editar'>Editar</button>
											<button class='btn btn-warning' type="button" is="b-link" des='a_track/ver' dix='trabajo' id1='<?php echo $key->id; ?>' title='editar'>Ver</button>
											<button class='btn btn-warning' type="button" is="b-link" des='a_track/lista'  dix='trabajo' tp="proceso" id1='<?php echo $key->id; ?>' db="a_track/db_" fun='borrar_track' title='Eliminar'>Eliminar</button>
									</div>
								</div>
							</div>
						</div>
					</div>
			<?php
				}
			?>
			<div id='0' class='col-3 edit-t mb-3'>
				<div class='card '>
					<div class='card-body'>
						<div class='text-center'>Nuevo Track</div>
					</div>
					<div class='card-footer'>
						<div class='row'>
							<div class='col-12'>
								<button class='btn btn-warning btn-block' type="button" is="b-link" des='a_track/editar' dix='trabajo' tp="edit" id1='0' title='editar'>Nuevo</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
</div>
