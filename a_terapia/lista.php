<?php
	require_once("db_.php");
	$pd = $db->terapias_lista();
?>
	<nav aria-label='breadcrumb'>
		<ol class='breadcrumb'>
			<li class='breadcrumb-item' id='lista_pacientes' data-lugar='a_terapia/lista'>Terapias</li>
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
											<button class='btn btn-sm' id='edit_persona' title='Editar' data-lugar='a_terapia/editar'><i class='fas fa-pencil-alt'></i>Editar</button>

											<button class='btn btn-sm' id='eliminar_terapia' data-lugar='a_terapia/db_' data-destino='a_terapia/lista' data-id='<?php echo $key->id; ?>' data-funcion='borrar_terapia' data-div='trabajo'><i class='far fa-trash-alt'></i>Eliminar</button>

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
