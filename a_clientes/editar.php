<?php
	require_once("db_.php");
	if (isset($_POST['id'])){$id=$_POST['id'];} else{ $id=0;}

	$nombre="";
	$apellidop="";
	$apellidom="";
	$telefono="";
	$correo="";
	$foto="";

	if($id>0){
		$pd = $db->cliente_editar($id);
		$nombre=$pd->nombre;
		$apellidop=$pd->apellidop;
		$apellidom=$pd->apellidom;
		$telefono=$pd->telefono;
		$correo=$pd->correo;
		$foto=$pd->foto;
	}

?>

<div class="container">
	<form action="" id="form_cliente" data-lugar="a_clientes/db_" data-funcion="guardar_cliente" data-destino='a_clientes/editar'>
		<input type="hidden" name="id" id="id" value="<?php echo $id;?>">
		<div class='card'>
			<div class='card-header'>
				Editar cliente
			</div>
			<div class='card-body'>
				<?php
					echo "<div class='form-group' id='imagen_div'>";
						echo "<img src='".$db->doc.trim($foto)."' class='img-thumbnail' width='100%'>";
					echo "</div>";
				?>

				<div class='row'>
					<div class="col-3">
						<label>Nombre:</label>
							<input type="text" class="form-control form-control-sm" name="nombre" id="nombre" value="<?php echo $nombre;?>" placeholder="Nombre" required>
					</div>

					<div class="col-3">
						<label>Apellido Paterno:</label>
							<input type="text" class="form-control form-control-sm" name="apellidop" id="apellidop" value="<?php echo $apellidop;?>" placeholder="Apellido Paterno" required>
					</div>

					<div class="col-3">
						<label>Apellido materno:</label>
							<input type="text" class="form-control form-control-sm" name="apellidom" id="apellidom" value="<?php echo $apellidom;?>" placeholder="Apellido materno" required>
					</div>

				</div>
				<div class='row'>
					<div class="col-3">
						<label>Teléfono:</label>
							<input type="text" class="form-control form-control-sm" name="telefono" id="telefono" value="<?php echo $telefono;?>" placeholder="Teléfono" required>
					</div>
					<div class="col-3">
						<label>Correo:</label>
							<input type="text" class="form-control form-control-sm" name="correo" id="correo" value="<?php echo $correo;?>" placeholder="Correo" required>
					</div>
				</div>
			</div>
			<div class='card-footer'>
				<div class="row">
					<div class="col-sm-12">
						<div class="btn-group">
						<button class="btn btn-sm" type="submit"><i class='far fa-save'></i>Guardar</button>
						<?php
							if($id>0){
								echo "<button type='button' class='btn btn-sm' data-toggle='modal' data-target='#myModal' id='fileup_foto' data-ruta='$db->doc' data-tabla='clientes' data-campo='foto' data-tipo='1' data-id='$id' data-keyt='id' data-destino='a_clientes/editar' data-iddest='$id' data-ext='.jpg,.png' title='Subir foto'><i class='fas fa-cloud-upload-alt'></i>Foto</button>";

								echo "<button type='button' class='btn btn-sm' id='winmodal_pass' data-id='$id' data-lugar='a_clientes/form_pass' title='Cambiar contraseña' ><i class='fas fa-key'></i>Contraseña</button>";
							}
						?>
						<button class='btn btn-sm' id='lista_penarea' data-lugar='a_clientes/lista' title='regresar'><i class='fas fa-undo-alt'></i>Regresar</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
