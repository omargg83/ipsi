<?php
	require_once("db_.php");
	$pd = $db->track_lista();
?>
	<nav aria-label='breadcrumb'>
		<ol class='breadcrumb'>
			<li class='breadcrumb-item' id='lista_pacientes' data-lugar='a_track/lista'>Track</li>
		</ol>
	</nav>

	<div class='container'>
		<div class='row'>
			<?php
				foreach($pd as $key){
			?>
					<div id='<?php echo $key->id; ?>' class='col-4 edit-t p-3'>
						<div class='card '>
							<div class='card-body'>
								<div class='text-center'><?php echo $key->nombre; ?></div>
							</div>
							<div class='card-footer'>
								<div class='row'>
									<div class='col-12'>
										<div class='btn-group'>
											<button class='btn btn-sm' id='edit_persona' title='Editar' data-lugar='a_track/editar'><i class='fas fa-pencil-alt'></i>Editar</button>
											<button class='btn btn-sm' id='edit_ver' title='Ver' data-lugar='a_track/ver'><i class="far fa-eye"></i>Ver</button>

											<button class='btn btn-sm' id='eliminar_terapia' data-lugar='a_track/db_' data-destino='a_track/lista' data-id='<?php echo $key->id; ?>' data-funcion='borrar_track' data-div='trabajo'><i class='far fa-trash-alt'></i>Eliminar</button>

										</div>
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