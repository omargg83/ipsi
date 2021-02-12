<?php
	require_once("../a_actividades/db_.php");

	$idactividad=clean_var($_REQUEST['idactividad']);
	$proviene=clean_var($_REQUEST['proviene']);

	$idtrack="";
	$idmodulo="";

	if(isset($_REQUEST['idmodulo'])){
		$idmodulo=clean_var($_REQUEST['idmodulo']);
		$modulo = $db->modulo_editar($idmodulo);
	}
	if(isset($_REQUEST['idtrack'])){
		$idtrack=clean_var($_REQUEST['idtrack']);
	}

	$nombre="";
	$observaciones="";
	$indicaciones="";
	$tipo="";
	$visible="1";

	if($idactividad>0){
		$cuest=$db->actividad_editar($idactividad);
		$nombre=$cuest->nombre;
		$observaciones=$cuest->observaciones;
		$indicaciones=$cuest->indicaciones;
		$tipo=$cuest->tipo;
		$visible=$cuest->visible;
		$idtrack=$cuest->idtrack;
		$idmodulo=$cuest->idmodulo;
	}


	if($idtrack>0){
		$track=$db->track_editar($idtrack);
		$idterapia=$track->idterapia;
		$terapia=$db->terapia_editar($idterapia);
	}

	if($idmodulo>0){
		$modulo=$db->modulo_editar($idmodulo);
		$track=$db->track_editar($modulo->idtrack);
		$terapia=$db->terapia_editar($track->idterapia);
	}
?>

<nav aria-label='breadcrumb'>
	<ol class='breadcrumb'>
		<li class="breadcrumb-item" is="li-link" des="a_actividades/terapias" dix="trabajo" id1="">Inicio</lis>
		<li class="breadcrumb-item" is="li-link" des="a_actividades/track" dix="trabajo" title="Track" v_idterapia="<?php echo $terapia->id; ?>"><?php echo $terapia->nombre; ?></li>
		<li class="breadcrumb-item" is="li-link" des="a_actividades/modulos" dix="trabajo" v_idtrack="<?php echo $track->id; ?>" ><?php echo $track->nombre; ?></li>
		<?php

			if($proviene=="moduloscatalogo" and $idactividad>0){
				echo "<li class='breadcrumb-item' is='li-link' des='a_actividades_e/actividad_editar' dix='trabajo' v_idtrack='$idtrack' v_idactividad='$idactividad' dix='trabajo' v_proviene='$proviene'>$nombre</li>";
			}
			if($proviene=="moduloscatalogo" and $idactividad==0){
				echo "<li class='breadcrumb-item' is='li-link' des='a_actividades_e/actividad_editar' dix='trabajo' v_idtrack='$idtrack' v_idactividad='$idactividad' dix='trabajo' v_proviene='$proviene'>Nueva actividad</li>";
			}
			if($proviene=="actividadver"){
				if($idmodulo>0){
					echo "<li class='breadcrumb-item' is='li-link' des='a_actividades/actividades' dix='trabajo' v_idmodulo='$idmodulo'>$modulo->nombre</li>";
				}

				echo "<li class='breadcrumb-item' is='li-link' des='a_actividades_e/actividad_editar' dix='trabajo' v_idtrack='$idtrack' v_idactividad='$idactividad' dix='trabajo' v_proviene='$proviene'>$nombre</li>";
			}
			if($proviene=="actividades" and $idactividad==0){
				echo "<li class='breadcrumb-item' is='li-link' des='a_actividades/actividades' dix='trabajo' v_idmodulo='$idmodulo'>$modulo->nombre</li>";
				echo "<li class='breadcrumb-item active' is='li-link' des='a_actividades_e/actividad_editar' dix='trabajo' v_idmodulo='$idmodulo' v_idactividad='0' v_proviene='$proviene'>Nueva Actividad</li>";
			}
			if($proviene=="actividades" and $idactividad>0){
				echo "<li class='breadcrumb-item' is='li-link' des='a_actividades/actividades' dix='trabajo' v_idmodulo='$idmodulo'>$modulo->nombre</li>";
				echo "<li class='breadcrumb-item active' is='li-link' des='a_actividades_e/actividad_editar' dix='trabajo' v_idmodulo='$idmodulo' v_idactividad='0' v_proviene='$proviene'>$nombre</li>";
			}

			if($proviene=="moduloscatalogo"){
				echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades/modulos' v_idtrack='$idtrack' dix='trabajo'>Regresar</button>";
			}
			if($proviene=="actividades"){
				echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades/actividades' v_idmodulo='$idmodulo' dix='trabajo'>Regresar</button>";
			}
			if($proviene=="actividadver"){
				echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades/actividad_ver' v_idactividad='$idactividad' dix='trabajo'>Regresar</button>";
			}

		?>
	</ol>
</nav>

<div class='container'>
	<?php

			if($proviene=="moduloscatalogo" and $idactividad==0){
				echo "<form is='f-submit' id='form_editaract' db='a_actividades/db_' fun='guarda_actividad' des='a_actividades/actividad_ver' desid='idactividad' >";

			}
			if($proviene=="moduloscatalogo" and $idactividad>0){
				echo "<form is='f-submit' id='form_editaract' db='a_actividades/db_' fun='guarda_actividad' >";

			}
			if($proviene=="actividadver"){
				echo "<form is='f-submit' id='form_editaract' db='a_actividades/db_' fun='guarda_actividad' >";
			}

			if($proviene=="actividades"){
				echo "<form is='f-submit' id='form_editaract' db='a_actividades/db_' fun='guarda_actividad' des='a_actividades/actividad_ver' desid='idactividad' >";

			}
			echo "<input type='hidden' class='form-control' id='idactividad' name='idactividad' value='$idactividad' readonly>";

			if(strlen($idtrack)>0){
				echo "<input type='hidden' class='form-control' id='idtrack' name='idtrack' value='$idtrack' readonly>";
			}
			if(strlen($idmodulo)>0){
				echo "<input type='hidden' class='form-control' id='idmodulo' name='idmodulo' value='$idmodulo' readonly>";
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
							<button class='btn btn-warning'  type='submit'>Guardar</button>
							<?php
							if($proviene=="moduloscatalogo"){
								echo "<button class='btn btn-warning' type='button' is='b-link' des='a_actividades/modulos' v_idtrack='$idtrack' dix='trabajo'>Regresar</button>";
							}
							if($proviene=="actividades"){
								echo "<button class='btn btn-warning' type='button' is='b-link' des='a_actividades/actividades' v_idmodulo='$idmodulo' dix='trabajo'>Regresar</button>";
							}
							if($proviene=="actividadver"){
								echo "<button class='btn btn-warning' type='button' is='b-link' des='a_actividades/actividad_ver' v_idactividad='$idactividad' dix='trabajo'>Regresar</button>";
							}
							?>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
