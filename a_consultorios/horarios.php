<?php
	require_once("db_.php");


	$idconsultorio=$_REQUEST['idconsultorio'];
	$pd = $db->consultorio($idconsultorio);
	$nombre=$pd->nombre;
	$idsucursal=$pd->idsucursal;

	$sucursal = $db->sucursal($idsucursal);
  $snombre=$sucursal->nombre;

?>

<div class="container">
		<div class='card'>
			<div class='card-header'>
				Consultorio
			</div>
			<div class='card-body'>
				<div class='row'>
					<div class="col-6">
						<label>Nombre:</label>
							<input type="text" class="form-control " name="nombre" id="nombre" value="<?php echo $nombre;?>" placeholder="Nombre" required maxlength='100' readonly>
					</div>

					<div class='col-6'>
						<label for='nombre'>Sucursal</label>
            <input type="text" class="form-control " name="sucursal" id="sucursal" value="<?php echo $snombre;?>" placeholder="Nombre" required maxlength='100' readonly>

					</div>
				</div>
			</div>

			<div class='card-footer'>
				<div class="row">
					<div class='col-12'>

						<button type='button' class='btn btn-warning btn-sm' id='lista_penarea' is='b-link' des='a_consultorios/editar_horario' dix='trabajo' title='regresar' v_idconsultorio='<?php echo $idconsultorio;?>' v_idhorario='0'>Agregar horario</button>

						<button type='button' class='btn btn-warning btn-sm' id='lista_penarea' is='b-link' des='a_consultorios/lista' dix='trabajo' title='regresar'>Regresar</button>

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
						<div class='cell'>Desde</div>
						<div class='cell'>Hasta</div>
					</div>
					<?php
						$horarios=$db->lista_horarios($idconsultorio);
						foreach($horarios as $key){
							echo "<div class='body-row' draggable='true'>";
								echo "<div class='cell'>";
									echo "<div class='btn-group'>";

									echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_consultorios/editar_horario' dix='trabajo' v_idhorario='$key->idhorario'>Editar</button>";

									echo "<button class='btn btn-warning btn-sm float-right' type='button' is='b-link' des='a_consultorios/horarios' dix='trabajo' db='a_consultorios/db_' fun='horario_quitar' v_idhorario='$key->idhorario' v_idconsultorio='$idconsultorio' tp='¿Desea eliminar el horario seleccionado?' title='Borrar'>Eliminar</button>";

									echo "</div>";
								echo "</div>";
								echo "<div class='cell' data-titulo='Nombre'>".date ( 'h:i' , strtotime($key->desde))."</div>";
								echo "<div class='cell' data-titulo='Sucursal'>".date ( 'h:i' , strtotime($key->hasta))."</div>";
							echo "</div>";
						}
					 ?>
				 </div>
			</div>
		</div>
</div>
