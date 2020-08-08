<?php
	require_once("../a_actividades/db_.php");

	$idactividad=0;
	if(isset($_REQUEST['id1'])){
		$idactividad=clean_var($_REQUEST['id1']);
	}

	$idmodulo=clean_var($_REQUEST['id2']);
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
	}

?>
<nav aria-label='breadcrumb'>
	<ol class='breadcrumb'>
		<li class="breadcrumb-item" type="button" is="li-link" des="a_actividades/terapias" dix="trabajo" id1="">Inicio</lis>
		<li class="breadcrumb-item" type="button" is="li-link" des="a_actividades/track" dix="trabajo" title="Track" id1="<?php echo $terapia->id; ?>"><?php echo $terapia->nombre; ?></li>
		<li class="breadcrumb-item" type="button" is="li-link" des="a_actividades/modulos" dix="trabajo" id1="<?php echo $track->id; ?>" ><?php echo $track->nombre; ?></li>
		<li class="breadcrumb-item" type="button" is="li-link" des="a_actividades/actividades" dix="trabajo" id1="<?php echo $modulo->id; ?>" ><?php echo $modulo->nombre; ?></li>
		<li class="breadcrumb-item active" type="button" is="li-link" des="a_actividades_e/actividad_editar" dix="trabajo" id1="<?php echo $idactividad; ?>" id2="<?php echo $idmodulo; ?>"><?php echo $nombre; ?></li>
	</ol>
</nav>

<div class="alert alert-warning text-center" role="alert">
	Actividad
	<button class="btn btn-warning btn-sm float-right" type="button" is="b-link" des="a_actividades/actividades" dix="trabajo" id1="<?php echo $modulo->id; ?>">Regresar</button>
</div>

	<div class='container'>
		<form is="f-submit" id="form_editaract" db="a_actividades/db_" fun="guarda_actividad">
			<input type='hidden' class='form-control' id='id1' name='id1' placeholder='Nombre' value='<?php echo $idactividad; ?>' readonly>
			<input type='hidden' class='form-control' id='idmodulo' name='idmodulo' placeholder='Nombre' value='<?php echo $idmodulo; ?>' readonly>
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
								<button class='btn btn-warning'  type='submit'>Guardar</button>
								<button class="btn btn-warning" type="button" is="b-link" des="a_actividades/actividades" dix="trabajo" id1="<?php echo $modulo->id; ?>">Regresar</button>
						</div>
					</div>
				</div>
			</div>
		</form>
		<br>

  </div>