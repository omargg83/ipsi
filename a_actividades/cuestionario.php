<?php
	require_once("db_.php");
  $idcuest=$_REQUEST['id'];
	$cuest=$db->cuestionario_editar($idcuest);
	$nombre="";
	$observaciones="";
	if($idcuest>0){
		$nombre=$cuest->nombre;
		$observaciones=$cuest->observaciones;
	}
  $pd=$db->preguntas($idcuest);
?>
  <div class='container'>
		<form id='form_cuestionario' action='' data-lugar='a_actividades/db_'  data-funcion='guarda_cuestionario' data-destino='a_actividades/cuestionario'>
			<input class='form-control' type='hidden' id='id' NAME='id' value='<?php echo $idcuest; ?>' >
			<div class='card'>
				<div class='card-body'>
					<div class='row'>
						<div class='col-2'>
							<label>Numero</label>
							<input type='text' class='form-control' id='numero' name='numero' placeholder='Nombre' value='<?php echo $idcuest; ?>' readonly>
						</div>
						<div class='col-4'>
							<label>Nombre</label>
							<input type='text' class='form-control' id='nombre' name='nombre' placeholder='Nombre' value='<?php echo $nombre; ?>' required>
						</div>
					</div>
					<div class='row'>
						<div class='col-12'>
							<label>Observaciones</label>
							<textarea type='text' class='form-control' id='observaciones' name='observaciones' placeholder='Observaciones'><?php echo $observaciones; ?></textarea>
						</div>
					</div>
				</div>
				<div class='card-footer'>
					<div class='btn-group'>
						<button type='submit' class='btn btn-outline-secondary btn-sm'><i class='far fa-save'></i> Guardar</button>
						<button type='button' class='btn btn-outline-secondary btn-sm' onclick='preguntas(0,<?php echo $idcuest; ?>)'><i class="fas fa-plus"></i> Pregunta</button>
						<button type='button' class='btn btn-outline-secondary btn-sm' id='lista_reg1' data-lugar='a_actividades/lista'><i class='fas fa-undo-alt'></i> Regresar</button>
					</div>
				</div>
			</div>
		</form>

		<div id='actividad'>
			<h5>Lista de preguntas</h5>

			<?php
				foreach($pd as $key){
					echo "<div id='".$key->id."''  class='row edit-t'>";

						echo "<div class='col-2'>";
							echo "<div class='btn-group'>";
							echo "<button class='btn btn-outline-primary btn-sm' onclick='preguntas($key->id,$idcuest)'><i class='fas fa-pencil-alt'></i></button>";
							echo "</div>";
						echo "</div>";

						echo "<div class='col-2'>";
							echo $key->orden;
						echo "</div>";
						echo "<div class='col-6'>".$key->pregunta."</div>";
					echo "</div>";
				}
			?>


		</div>
  </div>
