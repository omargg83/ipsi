<?php
	require_once("../a_actividades/db_.php");
	$idactividad=clean_var($_REQUEST['idactividad']);

	$inicial=0;
	if(isset($_REQUEST['idmodulo'])){
		$idmodulo=clean_var($_REQUEST['idmodulo']);
		$inicial=0;
		$modulo = $db->modulo_editar($idmodulo);
		$idtrack=$modulo->idtrack;
	}
	if(isset($_REQUEST['idtrack'])){
		$idtrack=clean_var($_REQUEST['idtrack']);
		$inicial=1;
	}


	$nombre="Nueva actividad";
	$observaciones="";
	$indicaciones="";
	$tipo="";
	$visible="";
	if($idactividad>0){
		$cuest=$db->actividad_editar($idactividad);
		$nombre=$cuest->nombre;
		$observaciones=$cuest->observaciones;
		$indicaciones=$cuest->indicaciones;
		$tipo=$cuest->tipo;
		$visible=$cuest->visible;

		if($cuest->idtrack){
			$idtrack=$cuest->idtrack;
			$inicial=1;
		}
	}


	$track=$db->track_editar($idtrack);
	$idterapia=$track->idterapia;
	$terapia=$db->terapia_editar($idterapia);


	$origen="";
	if(isset($_REQUEST['origen'])){
		$origen=$_REQUEST['origen'];
		echo $origen;
	}
?>

<nav aria-label='breadcrumb'>
	<ol class='breadcrumb'>
		<li class="breadcrumb-item" is="li-link" des="a_actividades/terapias" dix="trabajo" id1="">Inicio</lis>
		<li class="breadcrumb-item" is="li-link" des="a_actividades/track" dix="trabajo" title="Track" v_idterapia="<?php echo $terapia->id; ?>"><?php echo $terapia->nombre; ?></li>
		<li class="breadcrumb-item" is="li-link" des="a_actividades/modulos" dix="trabajo" v_idtrack="<?php echo $track->id; ?>" ><?php echo $track->nombre; ?></li>
		<?php
			if($inicial==0){
		?>
			<li class="breadcrumb-item" is="li-link" des="a_actividades/actividades" dix="trabajo" v_idmodulo="<?php echo $modulo->id; ?>" ><?php echo $modulo->nombre; ?></li>
			<li class="breadcrumb-item active" is="li-link" des="a_actividades/actividad_ver" dix="trabajo" v_idactividad="<?php echo $idactividad; ?>" ><?php echo $nombre; ?></li>
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
				echo "<input type='hidden' class='form-control' id='idtrack' name='idtrack' value='$idtrack' readonly>";
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
								if($idactividad==0){
									echo "<option value='normal'>Normal</option>";
									echo "<option value='evaluacion'>Evaluacion</option>";
								}
								else{
									if($tipo=="normal"){
										echo "<option value='normal' selected>Normal</option>";
									}
									else{
										echo "<option value='evaluacion' selected>Evaluacion</option>";
									}
								}
							?>
						</select>
					</div>

					<div class="col-3">
						<label>Visible:</label>
						<select class='form-control' id='visible' name='visible'>
							<?php
								echo "<option value='1'"; if ($visible==1) { echo " selected"; } echo ">Mostrar</option>";
								echo "<option value='0'"; if ($visible==0) { echo " selected"; } echo ">Oculta</option>";
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
								if($idactividad>0 and strlen($origen)==0){
									echo "<button class='btn btn-warning' type='button' is='b-link' des='a_actividades/actividad_ver' v_idactividad='$idactividad' dix='trabajo'>Regresar</button>";
								}
								else{
									echo "<button class='btn btn-warning' type='button' is='b-link' des='a_actividades/actividades' v_idmodulo='$idmodulo' dix='trabajo'>Regresar</button>";
								}
							}
							else{

								echo "<button class='btn btn-warning' type='button' is='b-link' des='a_actividades/modulos' v_idtrack='$idtrack' dix='trabajo'>Regresar</button>";
							}
							?>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
