<?php
	require_once("db_.php");

	$idusuario=$_REQUEST['idusuario'];
	$pd = $db->usuario_editar($idusuario);
	$nombre=$pd->nombre;
	$dix='trabajo';

	$mi="";
	if (isset($_REQUEST['mi'])){
		$mi="1";
	}

?>

<div class="container">
		<div class='card'>
			<div class='card-header'>
				Usuario
			</div>
			<div class='card-body'>
				<div class='row'>
					<div class="col-6">
						<label>Nombre:</label>
							<input type="text" class="form-control " name="nombre" id="nombre" value="<?php echo $nombre;?>" placeholder="Nombre" required maxlength='100' readonly>
					</div>
				</div>
			</div>

			<div class='card-footer'>
				<div class="row">
					<div class='col-12'>
						<?php

							if($mi!=1){
								echo "<button type='button' class='btn btn-warning btn-sm' id='lista_penarea' is='b-link' des='a_terapeutas/editar_horario' dix='trabajo' title='regresar' v_idusuario='$idusuario' v_idhorario='0'>Agregar horario</button>";

								echo "<button type='button' class='btn btn-warning btn-sm' id='lista_penarea' is='b-link' des='a_terapeutas/editar' dix='trabajo' title='regresar' v_idusuario='$idusuario'>Regresar</button>";
							}
							else{
								echo "<button type='button' class='btn btn-warning btn-sm' id='lista_penarea' is='b-link' des='a_terapeutas/editar_horario' dix='contenido' title='regresar' v_idusuario='$idusuario' v_idhorario='0' v_mi='1'>Agregar horario</button>";

								echo "<button type='button' class='btn btn-warning btn-sm' id='lista_penarea' is='b-link' des='a_terapeutas/editar_p' dix='contenido' title='regresar' v_idusuario='$idusuario'>Regresar</button>";
							}
						?>
					</div>
				</div>
			</div>
		</div>
		<hr>
		<div class='card'>
			<div class='card-header'>
				Horarios
			</div>
			<div class='card-body'>
				<div class='tabla_v' id='tabla_css'>

					<div class='header-row'>
						<div class='cell'>#</div>
						<div class='cell'>Dia</div>
						<div class='cell'>Desde</div>
						<div class='cell'>Hasta</div>
						<div class='cell'>Recurrente</div>
					</div>
					<?php
						$horarios=$db->usuario_horarios($idusuario);
						foreach($horarios as $key){
							echo "<div class='body-row' draggable='true'>";
								echo "<div class='cell'>";

								if($mi!=1){
									echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_terapeutas/editar_horario' dix='trabajo' v_idhorario='$key->idhorario'>Editar</button>";

									echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_terapeutas/horarios' dix='trabajo' db='a_terapeutas/db_' fun='horario_quitar' v_idhorario='$key->idhorario' v_idusuario='$idusuario' tp='¿Desea eliminar el horario seleccionado?' title='Borrar'>Eliminar</button>";
								}
								else{
									echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_terapeutas/editar_horario' dix='contenido' v_idhorario='$key->idhorario' v_mi='1'>Editar</button>";

									echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_terapeutas/horarios' dix='contenido' db='a_terapeutas/db_' fun='horario_quitar' v_idhorario='$key->idhorario' v_idusuario='$idusuario' tp='¿Desea eliminar el horario seleccionado?' title='Borrar' v_mi='1'>Eliminar</button>";
								}

								echo "</div>";
								echo "<div class='cell' data-titulo='Dia'>".$key->desde_dia."</div>";
								echo "<div class='cell' data-titulo='Desde'>".date ( 'h:i' , strtotime($key->desde))."</div>";
								echo "<div class='cell' data-titulo='Hasta'>".date ( 'h:i' , strtotime($key->hasta))."</div>";
								echo "<div class='cell' data-titulo='Recurrente'>";
									if($key->recurrente){
										echo "Recurrente";
									}
								echo "</div>";
							echo "</div>";
						}
					 ?>
				 </div>
			</div>
		</div>
</div>
