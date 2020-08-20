<?php
	require_once("../a_actividades/db_.php");
	$idactividad=clean_var($_REQUEST['idactividad']);

	$inicial=0;
	if(isset($_REQUEST['idmodulo'])){
		$idmodulo=clean_var($_REQUEST['idmodulo']);
		$inicial=0;
		$modulo = $db->modulo_editar($idmodulo);
		$track=$db->track_editar($modulo->idtrack);
		$idterapia=$track->idterapia;
	}
	if(isset($_REQUEST['idterapia'])){
		$idterapia=clean_var($_REQUEST['idterapia']);
		$inicial=1;
	}
	$terapia=$db->terapia_editar($idterapia);


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
		<li class="breadcrumb-item" type="button" is="li-link" des="a_actividades/track" dix="trabajo" title="Track" v_idterapia="<?php echo $terapia->id; ?>"><?php echo $terapia->nombre; ?></li>
		<?php
			if($inicial==0){
		?>
			<li class="breadcrumb-item" type="button" is="li-link" des="a_actividades/modulos" dix="trabajo" v_idtrack="<?php echo $track->id; ?>" ><?php echo $track->nombre; ?></li>
			<li class="breadcrumb-item" type="button" is="li-link" des="a_actividades/actividades" dix="trabajo" v_idmodulo="<?php echo $modulo->id; ?>" ><?php echo $modulo->nombre; ?></li>
			<li class="breadcrumb-item active" type="button" is="li-link" des="a_actividades/actividad_ver" dix="trabajo" v_idactividad="<?php echo $idactividad; ?>" ><?php echo $nombre; ?></li>
		<?php
			}
		?>
	</ol>
</nav>

<div class='container'>
	<form is="f-submit" id="form_editaract" db="a_actividades/db_" fun="guarda_actividad" >
		<input type='hidden' class='form-control' id='idactividad' name='idactividad' value='<?php echo $idactividad; ?>' readonly>
		<?php
			if($inicial==0){
				echo "<input type='hidden' class='form-control' id='idmodulo' name='idmodulo' value='$idmodulo' readonly>";
			}
			else{
				echo "<input type='hidden' class='form-control' id='idterapia' name='idterapia' value='$idterapia' readonly>";
			}
		?>

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
							<?php
							if($inicial==0){
								echo "<option value='normal' "; if($tipo=="normal"){ echo " selected";} echo ">Normal</option>";
								echo "<option value='evaluacion' "; if($tipo=="evaluacion"){ echo " selected";} echo ">Evaluacion</option>";
							}
							else{
								echo "<option value='inicial' "; if($tipo=="inicial"){ echo " selected";} echo ">Inicial</option>";
							}
							?>
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
							<?php
							if($inicial==0){
								echo "<button class='btn btn-warning' type='button' is='b-link' des='a_actividades/actividades' v_idmodulo='$idmodulo' dix='trabajo'>Regresar</button>";
							}
							else{
								echo "<button class='btn btn-warning' type='button' is='b-link' des='a_actividades/track' v_idterapia='$idterapia' dix='trabajo'>Regresar</button>";
							}
							?>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
