<?php
	require_once("../a_actividades/db_.php");
	$idactividad=clean_var($_REQUEST['idactividad']);
	$idmodulo=clean_var($_REQUEST['idmodulo']);
	$modulo = $db->modulo_editar($idmodulo);
	$track=$db->track_editar($modulo->idtrack);
	$terapia=$db->terapia_editar($track->idterapia);

	$nombre="Nueva actividad";
	$observaciones="";
	$indicaciones="";
	$tipo="";
	if($idactividad>0){
		$cuest=$db->actividad_editar($idactividad);
		$nombre=$cuest->nombre;
		$observaciones=$cuest->observaciones;
		$indicaciones=$cuest->indicaciones;
		$tipo=$cuest->tipo;
	?>
		<form is="f-submit" id="form_editaract" db="a_actividades/db_" fun="guarda_actividad" des="a_actividades/actividad_ver" v_idactividad="<?php echo $idactividad; ?>" cmodal="1">
	<?php
	}
	else{
	?>
		<form is="f-submit" id="form_editaract" db="a_actividades/db_" fun="guarda_actividad" des="a_actividades/actividades" v_idmodulo="<?php echo $idmodulo; ?>" cmodal="1">
	<?php
	}

?>

	<input type='hidden' class='form-control' id='idactividad' name='idactividad' value='<?php echo $idactividad; ?>' readonly>
	<input type='hidden' class='form-control' id='idmodulo' name='idmodulo' value='<?php echo $idmodulo; ?>' readonly>

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
						<button class='btn btn-warning'  type='submit'><i class="far fa-save"></i>Guardar</button>
						<button class="btn btn-warning" type="button" is="b-link" cmodal="1">Regresar</button>
				</div>
			</div>
		</div>
	</div>
</form>
