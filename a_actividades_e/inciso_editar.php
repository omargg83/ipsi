<?php
	require_once("../a_actividades/db_.php");

	$idrespuesta=clean_var($_REQUEST['idrespuesta']);
	$idcontexto=clean_var($_REQUEST['idcontexto']);
	$idactividad=clean_var($_REQUEST['idactividad']);

	$paciente=0;
	if (isset($_REQUEST['idpaciente'])) {
		$idpaciente=clean_var($_REQUEST['idpaciente']);
		$paciente=1;
	}

	$orden="";
	$nombre="";

	if($idrespuesta>0){
		$res=$db->respuestas_editar($idrespuesta);
		$orden=$res->orden;
		$nombre=$res->nombre;
	}

	if($paciente==0){
		echo "<form is='f-submit' id='form-respuesta' db='a_actividades/db_' fun='guarda_respuesta' des='a_actividades/actividad_ver' v_idactividad='$idactividad' cmodal='1'>";
	}
	else{
		echo "<form is='f-submit' id='form-respuesta' db='a_actividades/db_' fun='guarda_respuesta' des='a_pacientes/actividad_ver' v_idactividad='$idactividad' v_idpaciente='$idpaciente'  cmodal='1'>";
	}
?>
	 <input type="hidden" name="idrespuesta" id="idrespuesta" value="<?php echo $idrespuesta; ?>">
	 <input type="hidden" name="idcontexto" id="idcontexto" value="<?php echo $idcontexto; ?>">
	 <div class="card">
	 	<div class="card-header">
			Agregar respuesta
	 	</div>
		<div class="card-body">
			<div class="row">
				<div class="col-2">
					<label>Orden</label>
					<input type="text" name="orden" id="orden" value="<?php echo $orden; ?>" class="form-control">
				</div>

				<div class="col-6">
					<label>Inciso</label>
					<input type="text" name="nombre" id="nombre" value="<?php echo $nombre; ?>" class="form-control">
				</div>

				<div class="col-4">
					<label>Imagen</label>
					<div class="custom-file">
						<input type="file" name="imagen" id="imagen" value="" class="custom-file-input">
						<label class="custom-file-label" for="imagen">Imagen</label>
					</div>
				</div>
			</div>
		</div>
		<div class="card-footer">
			<button type='submit' class='btn btn-warning'> Guardar</button>
			<button class="btn btn-warning" type="button" is="b-link" cmodal="1">Regresar</button>
		</div>
	 </div>
</form>
