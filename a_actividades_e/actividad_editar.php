<?php
	require_once("../a_actividades/db_.php");

	$idactividad=clean_var($_REQUEST['idactividad']);
	$proviene=clean_var($_REQUEST['proviene']);

	$nombre="";
	$observaciones="";
	$indicaciones="";
	$tipo="";
	$visible="1";
	$idgrupo="";

	if($idactividad>0){
		$cuest=$db->actividad_editar($idactividad);
		$nombre=$cuest->nombre;
		$observaciones=$cuest->observaciones;
		$indicaciones=$cuest->indicaciones;
		$tipo=$cuest->tipo;
		$visible=$cuest->visible;
		$idgrupo=$cuest->idgrupo;
	}
	else{
		$idgrupo=clean_var($_REQUEST['idgrupo']);
	}

	$sql="SELECT * from grupo_actividad where idgrupo=$idgrupo";
	$sth = $db->dbh->query($sql);
	$grupo=$sth->fetch(PDO::FETCH_OBJ);
	if(strlen($grupo->idtrack)){
		$idtrack=$grupo->idtrack;
		$track=$db->track_editar($idtrack);
		$idterapia=$track->idterapia;
		$terapia=$db->terapia_editar($idterapia);
	}
	else{
		$idmodulo=$grupo->idmodulo;
		$modulo=$db->modulo_editar($idmodulo);
		$track=$db->track_editar($modulo->idtrack);
		$terapia=$db->terapia_editar($track->idterapia);
	}

?>

<nav aria-label='breadcrumb'>
	<ol class='breadcrumb'>
		<li class="breadcrumb-item" is="li-link" des="a_actividades/terapias" dix="trabajo">Inicio</lis>
		<li class="breadcrumb-item" is="li-link" des="a_actividades/track" dix="trabajo" title="Track" v_idterapia="<?php echo $terapia->id; ?>"><?php echo $terapia->nombre; ?></li>
		<li class="breadcrumb-item" is="li-link" des="a_actividades/modulos" dix="trabajo" v_idtrack="<?php echo $track->id; ?>" ><?php echo $track->nombre; ?></li>
		<?php

			if($proviene=="grupos" and $idactividad>0){
				echo "<li class='breadcrumb-item' is='li-link' des='a_actividades/actividades' dix='trabajo' v_idmodulo='$idmodulo'>$modulo->nombre</li>";
				echo "<li class='breadcrumb-item active' is='li-link' des='a_actividades/grupos' dix='trabajo' title='Grupo' v_idgrupo='$grupo->idgrupo'>$grupo->grupo</li>";
				echo "<li class='breadcrumb-item' is='li-link' des='a_actividades_e/actividad_editar' dix='trabajo' v_idgrupo='$idgrupo' v_idactividad='$idactividad' dix='trabajo' v_proviene='$proviene'>$nombre</li>";
			}
			if($proviene=="grupos" and $idactividad==0){
				///echo "<li class='breadcrumb-item' is='li-link' des='a_actividades/actividades' dix='trabajo' v_idmodulo='$idmodulo'>$modulo->nombre</li>";
				echo "<li class='breadcrumb-item active' is='li-link' des='a_actividades/grupos' dix='trabajo' title='Grupo' v_idgrupo='$grupo->idgrupo'>$grupo->grupo</li>";
				echo "<li class='breadcrumb-item' is='li-link' des='a_actividades_e/actividad_editar' dix='trabajo' v_idgrupo='$idgrupo' v_idactividad='$idactividad' dix='trabajo' v_proviene='$proviene'>Nueva actividad</li>";
			}
			if($proviene=="actividadver"){
				if($idmodulo>0){
					echo "<li class='breadcrumb-item' is='li-link' des='a_actividades/actividades' dix='trabajo' v_idmodulo='$idmodulo'>$modulo->nombre</li>";
				}
				echo "<li class='breadcrumb-item active' is='li-link' des='a_actividades/grupos' dix='trabajo' title='Grupo' v_idgrupo='$grupo->idgrupo'>$grupo->grupo</li>";
				echo "<li class='breadcrumb-item' is='li-link' des='a_actividades_e/actividad_editar' dix='trabajo' v_idgrupo='$idgrupo' v_idactividad='$idactividad' dix='trabajo' v_proviene='$proviene'>$nombre</li>";
			}
			if($proviene=="actividades" and $idactividad==0){
				echo "<li class='breadcrumb-item' is='li-link' des='a_actividades/actividades' dix='trabajo' v_idmodulo='$idmodulo'>$modulo->nombre</li>";
				echo "<li class='breadcrumb-item active' is='li-link' des='a_actividades_e/actividad_editar' dix='trabajo' v_idmodulo='$idmodulo' v_idactividad='0' v_proviene='$proviene'>Nueva Actividad</li>";
			}
			if($proviene=="actividades" and $idactividad>0){
				echo "<li class='breadcrumb-item' is='li-link' des='a_actividades/actividades' dix='trabajo' v_idmodulo='$idmodulo'>$modulo->nombre</li>";
				echo "<li class='breadcrumb-item active' is='li-link' des='a_actividades_e/actividad_editar' dix='trabajo' v_idmodulo='$idmodulo' v_idactividad='0' v_proviene='$proviene'>$nombre</li>";
			}


			if($proviene=="grupos"){
				echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades/grupos' v_idgrupo='$idgrupo' dix='trabajo'>Regresar</button>";
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

			if($proviene=="grupos" and $idactividad==0){
				echo "<form is='f-submit' id='form_editaract' db='a_actividades/db_' fun='guarda_actividad' des='a_actividades/actividad_ver' desid='idactividad' >";

			}
			if($proviene=="grupos" and $idactividad>0){
				echo "<form is='f-submit' id='form_editaract' db='a_actividades/db_' fun='guarda_actividad' >";

			}
			if($proviene=="actividadver"){
				echo "<form is='f-submit' id='form_editaract' db='a_actividades/db_' fun='guarda_actividad' >";
			}

			if($proviene=="actividades"){
				echo "<form is='f-submit' id='form_editaract' db='a_actividades/db_' fun='guarda_actividad' des='a_actividades/actividad_ver' desid='idactividad' >";

			}
			echo "<input type='hidden' class='form-control' id='idactividad' name='idactividad' value='$idactividad' readonly>";


			echo "<input type='hidden' class='form-control' id='idgrupo' name='idgrupo' value='$idgrupo' readonly>";

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
							if($proviene=="grupos"){
								echo "<button class='btn btn-warning' type='button' is='b-link' des='a_actividades/grupos' v_idgrupo='$idgrupo' dix='trabajo'>Regresar</button>";
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
