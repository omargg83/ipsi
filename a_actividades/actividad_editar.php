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
	$indicaciones="";
	$tipo="";
	$terapia="";
	if($idactividad>0){
		$cuest=$db->actividad_editar($idactividad);
		$nombre=$cuest->nombre;
		$observaciones=$cuest->observaciones;
		$tipo=$cuest->tipo;
		$terapia=$cuest->terapia;
		$indicaciones=$cuest->indicaciones;
	}
?>
	<nav aria-label='breadcrumb'>
		<ol class='breadcrumb'>
			<li class='breadcrumb-item' id='lista_act' data-lugar='a_actividades/lista'>Actividades</li>
			<li class='breadcrumb-item active' aria-current='page'>Actividad</li>
		</ol>
	</nav>

	<div class='container'>

		<form id='form_actividad' action='' data-lugar='a_actividades/db_'  data-funcion='guarda_actividad'>
			<input type='hidden' class='form-control' id='id' name='id' placeholder='Nombre' value='<?php echo $idactividad; ?>' readonly>
			<div class='card'>
				<div class="card-header">
					Editar actividad
				</div>
				<div class='card-body'>
					<div class='row'>
						<div class='col-12'>
							<label>Nombre de la actividad</label>
							<input type='text' class='form-control' id='nombre' name='nombre' placeholder='Nombre de la actividad' value='<?php echo $nombre; ?>' required>
						</div>
						<div class="col-3">
							<label>Tipo de terapia:</label>
								<select class='form-control' id='tipo' name='tipo'>
									<option value='normal' <?php if($tipo=="normal"){ echo " selected";} ?>>Normal</option>
									<option value='evaluacion' <?php if($tipo=="evaluacion"){ echo " selected";} ?>>Evaluacion</option>
								</select>
						</div>
						<div class="col-3">
							<label>Tipo de terapia:</label>
								<select class='form-control' id='track' name='track'>
									<option value='inicial' <?php if($tipo=="inicial"){ echo " selected";} ?>>Inicial</option>
									<option value='individual' <?php if($tipo=="individual"){ echo " selected";} ?>>Individual</option>
									<option value='pareja' <?php if($tipo=="pareja"){ echo " selected";} ?>>Pareja</option>
									<option value='infantil' <?php if($tipo=="infantil"){ echo " selected";} ?>>Infantil</option>
								</select>
						</div>
						<div class="col-3">
							<label>Terapia:</label>
								<select class='form-control' id='terapia' name='terapia'>
									<option value='enojo' <?php if($tipo=="enojo"){ echo " selected";} ?>>Enojo</option>
									<option value='ansiedad' <?php if($tipo=="ansiedad"){ echo " selected";} ?>>Ansiedad</option>
								</select>
						</div>
					</div>
					<div class='row'>
						<div class='col-12'>
							<label>Indicaciones</label>
							<textarea type='text' class='form-control' id='indicaciones' name='indicaciones' placeholder='Indicaciones' rows=10><?php echo $indicaciones; ?></textarea>
						</div>
						<div class='col-12'>
							<label>Observaciones</label>
							<textarea type='text' class='form-control' id='observaciones' name='observaciones' placeholder='Observaciones' rows=3><?php echo $observaciones; ?></textarea>
						</div>
					</div>
				</div>
				<div class='card-footer'>
					<?php
						echo "<button type='submit' class='btn btn-warning'><i class='far fa-save'></i> Guardar</button>";
						echo "<button type='button' class='btn btn-warning' id='regresar' onclick='actividad_ver(document.getElementById(\"id\").value)'><i class='fas fa-undo-alt'></i> Regresar</button>";
					?>
				</div>
			</div>
		</form>
		<br>

  </div>
