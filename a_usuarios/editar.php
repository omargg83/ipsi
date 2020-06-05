<?php
	require_once("db_.php");

	$id=$_REQUEST['id'];

	$nombre="";

	$usuario="";
	$autoriza="";
	$nivel="";
	$correo="";

	if($id>0){
		$pd = $db->usuario_editar($id);
		$nombre=$pd->nombre;
		$usuario=$pd->usuario;
		$autoriza=$pd->autoriza;
		$nivel=$pd->nivel;
		$correo=$pd->correo;
	}
?>

<div class="container">
	<form action="" id="form_personal" data-lugar="a_usuarios/db_" data-funcion="guardar_usuario">
		<div class='card'>
		<div class='card-header'>
			Usuarios
		</div>
		<div class='card-body'>
			<div class='row'>
				<div class="col-2">
					<label for="">Numero:</label>
					<input type="text" class="form-control form-control-sm" name="id" id="id" value="<?php echo $id ;?>" placeholder="No" readonly>
				</div>

				<div class="col-4">
					<label for="">Nombre:</label>
					<input type="text" class="form-control form-control-sm" name="nombre" id="nombre" value="<?php echo $nombre ;?>" placeholder="Nombre" required>
				</div>

				<div class="col-4">
					<label for="">Usuario:</label>
					<input type="text" class="form-control form-control-sm" name="usuario" id="usuario" value="<?php echo $usuario ;?>" placeholder="Usuario" required>
				</div>

				<div class="col-4">
					<label for="">Correo:</label>
					<input type="text" class="form-control form-control-sm" name="correo" id="correo" value="<?php echo $correo ;?>" placeholder="Usuario" required>
				</div>

				<div class="col-4">
					<label for="">Nivel:</label>
					<select class="form-control form-control-sm" name="nivel" id="nivel">
					  <option value="1"<?php if($nivel=="1") echo "selected"; ?> >1</option>
					  <option value="2"<?php if($nivel=="2") echo "selected"; ?> >2</option>
					</select>
				</div>
			</div>
		</div>

		<div class='card-footer'>
			<div class='row'>
				<div class="col-sm-12">
					<div class="btn-group">
					<button class="btn btn-sm" type="submit"><i class='far fa-save'></i>Guardar</button>
					<?php
						if($id>0){
							echo "<button type='button' class='btn btn-sm' id='winmodal_pass' data-id='$id' data-lugar='a_usuarios/form_pass' title='Cambiar contraseña' ><i class='fas fa-key'></i>Contraseña</button>";
						}
					?>
					<button class='btn btn-sm' id='lista_penarea' data-lugar='a_usuarios/lista' title='regresar'><i class='fas fa-undo-alt'></i>Regresar</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	</form>
</div>