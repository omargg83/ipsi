<?php
	require_once("db_.php");

	echo print_r($_REQUEST);
	$id1=clean_var($_REQUEST['id1']);
	$idsubactividad=clean_var($_REQUEST['id2']);

	$orden="";
	$respuesta="";

	if($id1>0){
		$res=$db->respuestas_editar($id1);
		$orden=$res->orden;
		$respuesta=$res->respuesta;
	}
 ?>
 <form is="f-submit" id="form-respuesta" db="a_actividades/db_" fun="guarda_respuesta" lug="" cmodal="1">
	 <input type="text" name="id1" id="id1" value="<?php echo $id1; ?>">
	 <input type="text" name="idsubactividad" id="idsubactividad" value="<?php echo $idsubactividad; ?>">
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

				<div class="col-4">
					<label>Inciso</label>
					<input type="text" name="respuesta" id="respuesta" value="<?php echo $respuesta; ?>" class="form-control">
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
