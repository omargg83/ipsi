<?php
	require_once("db_.php");
	if(isset($_REQUEST['id1'])){
		$id1=$_REQUEST['id1'];
	}
	else{
		$id1=0;
	}

	$idactividad=$id1;
	$nombre="";
	$observaciones="";
	$indicaciones="";
	$tipo="";
	$terapia="";
	$track="";
	if($idactividad>0){
		$cuest=$db->actividad_editar($idactividad);
		$nombre=$cuest->nombre;
		$observaciones=$cuest->observaciones;
		$indicaciones=$cuest->indicaciones;
		$tipo=$cuest->tipo;
		$terapia=$cuest->terapia;
		$track=$cuest->track;
	}

	$terapias=$db->terapias();
	$tracks=$db->track();
?>
	<nav aria-label='breadcrumb'>
		<ol class='breadcrumb'>
			<li class='breadcrumb-item' id='lista_act' data-lugar='a_actividades/lista'>Actividades</li>
			<li class='breadcrumb-item active' aria-current='page'>Editar</li>
		</ol>
	</nav>

	<div class='container'>
		<form is="f-submit" id="form_editaract" db="a_actividades/db_" fun="guarda_actividad" lug="a_actividades/actividad_editar" cmodal="0">
			<input type='hidden' class='form-control' id='id1' name='id1' placeholder='Nombre' value='<?php echo $idactividad; ?>' readonly>
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
								<select class='form-control' id='terapia' name='terapia'>
									<?php
										foreach($terapias as $key){
											echo "<option value='$key->nombre'"; if($key->nombre==$terapia){ echo " selected";} echo ">$key->nombre</option>";
										}
									?>
								</select>
						</div>

						<div class="col-3">
							<label>Track:</label>
								<select class='form-control' id='track' name='track'>
									<?php
										foreach($tracks as $key){
											echo "<option value='$key->nombre'"; if($key->nombre==$track){ echo " selected";} echo ">$key->nombre</option>";
										}
									?>
								</select>
						</div>



						<div class="col-3">
							<label>Tipo de terapia:</label>
								<select class='form-control' id='tipo' name='tipo'>
									<option value='normal' <?php if($tipo=="normal"){ echo " selected";} ?>>Normal</option>
									<option value='evaluacion' <?php if($tipo=="evaluacion"){ echo " selected";} ?>>Evaluacion</option>
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
					<div class='row'>
						<div class='col-12'>
							<?php
								echo "<button class='btn btn-warning'  type='submit'>Guardar</button>";
								if($idactividad==0)
									echo "<button class='btn btn-warning' type='button' is='b-link' des='a_actividades/lista' dix='trabajo'>Regresar</button>";
								else
									echo "<button class='btn btn-warning' type='button' is='b-link' des='a_actividades/actividad_ver' dix='trabajo' id1='$idactividad'>Regresar</button>";
							?>
						</div>
					</div>
				</div>
			</div>
		</form>
		<br>

  </div>
