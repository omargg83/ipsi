<?php
	require_once("../a_actividades/db_.php");

	$id1=clean_var($_REQUEST['idrespuesta']);
	$idcontexto=clean_var($_REQUEST['idcontexto']);
	$idactividad=clean_var($_REQUEST['idactividad']);

	$orden="";
	$nombre="";

	if($id1>0){
		$res=$db->respuestas_editar($id1);
		$orden=$res->orden;
		$nombre=$res->nombre;
	}
 ?>
 <form is="f-submit" id="form-respuesta" db="a_actividades/db_" des="a_actividades/actividad_ver" v_idactividad="<?php echo $idactividad; ?>" fun="guarda_respuesta" lug="" cmodal="1">
	 <input type="hidden" name="id1" id="id1" value="<?php echo $id1; ?>">
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
			<button class="btn btn-warning" type="button" is="b-link" des="a_actividades/actividad_ver" cmodal="1">Regresar</button>
		</div>
	 </div>
</form>
