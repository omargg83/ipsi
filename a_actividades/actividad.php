<?php
	require_once("db_.php");
	if(isset($_REQUEST['idactividad'])){
		$idactividad=$_REQUEST['idactividad'];
	}
	else{
		$idactividad=0;
	}

	$nombre="";
	$observaciones="";
	$tipo="";
	if($idactividad>0){
		$cuest=$db->actividad_editar($idactividad);
		$nombre=$cuest->nombre;
		$observaciones=$cuest->observaciones;
		$tipo=$cuest->tipo;
	}
	echo "<div class='container'>";
		echo "<nav aria-label='breadcrumb'>";
			echo "<ol class='breadcrumb'>";
				echo "<li class='breadcrumb-item'>Actividades</li>";
				echo "<li class='breadcrumb-item active' aria-current='page'>Actividad</li>";
			echo "</ol>";
		echo "</nav>";
?>
		<form id='form_cuestionario' action='' data-lugar='a_actividades/db_'  data-funcion='guarda_cuestionario'>
			<div class='card'>
				<div class='card-body'>
					<div class='row'>
						<div class='col-2'>
							<label>Numero</label>
							<input type='text' class='form-control' id='id' name='id' placeholder='Nombre' value='<?php echo $idactividad; ?>' readonly>
						</div>
						<div class='col-10'>
							<label>Nombre</label>
							<input type='text' class='form-control' id='nombre' name='nombre' placeholder='Nombre' value='<?php echo $nombre; ?>' required>
						</div>
						<div class="col-3">
							<label>Tipo de terapia:</label>
								<select class='form-control' id='tipo' name='tipo'>
									<option value='inicial' <?php if($tipo=="inicial"){ echo " selected";} ?>>Inicial</option>
									<option value='individual' <?php if($tipo=="individual"){ echo " selected";} ?>>Individual</option>
									<option value='pareja' <?php if($tipo=="pareja"){ echo " selected";} ?>>Pareja</option>
									<option value='infantil' <?php if($tipo=="infantil"){ echo " selected";} ?>>Infantil</option>
								</select>
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
						<?php
							echo "<button type='submit' class='btn btn-outline-secondary btn-sm'><i class='far fa-save'></i> Guardar</button>";
							echo "<button type='button' class='btn btn-outline-secondary btn-sm' onclick='preguntas(document.getElementById(\"id\").value,0)'><i class='fas fa-plus'></i> Pregunta</button>";
							echo "<button type='button' class='btn btn-outline-secondary btn-sm' onclick='pacientes(document.getElementById(\"id\").value)'><i class='fas fa-user-edit'></i> Pacientes</button>";
							echo "<button type='button' class='btn btn-outline-secondary btn-sm' id='lista_reg1' data-lugar='a_actividades/lista'><i class='fas fa-undo-alt'></i> Regresar</button>";
						?>
					</div>
				</div>
			</div>
		</form>
		<br>
		<div id='actividad'>
			<div class='card'>
				<div class='card-body'>
					<?php
					  $pd=$db->preguntas($idactividad);
						foreach($pd as $key){
							echo "<div id='".$key->id."''  class='row edit-t'>";

								echo "<div class='col-1'>";
									echo "<div class='btn-group'>";
									echo "<button class='btn btn-outline-primary btn-sm' onclick='preguntas($idactividad,$key->id)'><i class='fas fa-pencil-alt'></i></button>";
									echo "</div>";
								echo "</div>";

								echo "<div class='col-10'>".$key->orden.".-".$key->pregunta."</div>";
							echo "</div>";
						}
					?>
				</div>
			</div>
		</div>
  </div>
