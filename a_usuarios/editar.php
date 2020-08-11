<?php
	require_once("db_.php");

	$idusuario=$_REQUEST['idusuario'];

	$nombre="";
	$apellidop="";
	$apellidom="";
	$autoriza="";
	$nivel="";
	$correo="";
	$foto="";
	if($idusuario>0){
		$pd = $db->usuario_editar($idusuario);
		$nombre=$pd->nombre;
		$apellidop=$pd->apellidop;
		$apellidom=$pd->apellidom;
		$autoriza=$pd->autoriza;
		$nivel=$pd->nivel;
		$correo=$pd->correo;
		$foto=$pd->foto;
	}
?>

<div class="container">
	<form is="f-submit" id="form_personal" db="a_usuarios/db_" fun="guardar_usuario" lug="a_usuarios/editar" lugid="idusuario"  v_idusuario="<?php echo $idusuario; ?>">
		<input type="hidden" class="form-control form-control-sm" name="idusuario" id="idusuario" value="<?php echo $idusuario ;?>" placeholder="No" readonly>
		<div class='card'>
		<div class='card-header'>
			Usuarios
		</div>
		<div class='card-body'>
			<?php
				echo "<div class='form-group' id='imagen_div'>";
					echo "<img src='".$db->doc.trim($foto)."' class='img-thumbnail' width='100px'>";
				echo "</div>";
			?>

			<div class='row'>
				<div class="col-4">
					<label for="">Nombre:</label>
					<input type="text" class="form-control form-control-sm" name="nombre" id="nombre" value="<?php echo $nombre ;?>" placeholder="Nombre" required>
				</div>

				<div class="col-3">
					<label for="">Apellido Paterno:</label>
					<input type="text" class="form-control form-control-sm" name="apellidop" id="apellidop" value="<?php echo $apellidop ;?>" placeholder="Apellido Paterno" required>
				</div>

				<div class="col-3">
					<label for="">Apellido Materno:</label>
					<input type="text" class="form-control form-control-sm" name="apellidom" id="apellidom" value="<?php echo $apellidom;?>" placeholder="Apellido Materno">
				</div>

				<div class="col-4">
					<label for="">Correo:</label>
					<input type="text" class="form-control form-control-sm" name="correo" id="correo" value="<?php echo $correo ;?>" placeholder="Usuario" >
				</div>

				<div class="col-4">
					<label for="">Nivel:</label>
					<select class="form-control form-control-sm" name="nivel" id="nivel">
						<?php
							if($_SESSION['nivel']==1){
								echo "<option value='1'"; if($nivel=="1") echo "selected"; echo ">1 Administrador</option>";
							}
						 ?>
					  <option value="2"<?php if($nivel=="2") echo "selected"; ?> >2 Terapeuta</option>
					</select>
				</div>
			</div>
		</div>

		<div class='card-footer'>
			<div class='row'>
				<div class="col-sm-12">
					<div class="btn-group">
					<button class="btn btn-warning" type="submit"><i class='far fa-save'></i>Guardar</button>
					<?php
						if($idusuario>0){
							echo "<button type='button' class='btn btn-warning' data-toggle='modal' data-target='#myModal' id='fileup_foto' data-ruta='$db->doc' data-tabla='usuarios' data-campo='foto' data-tipo='1' data-id='$idusuario' data-keyt='idusuario' data-destino='a_clientes/editar' data-iddest='$idusuario' data-ext='.jpg,.png' title='Subir foto'><i class='fas fa-cloud-upload-alt'></i>Foto</button>";

							echo "<button type='button' class='btn btn-warning' id='winmodal_pass' data-id='$idusuario' data-lugar='a_usuarios/form_pass' title='Cambiar contraseña' ><i class='fas fa-key'></i>Contraseña</button>";
						}
					?>
					<button class="btn btn-warning" type="button" is="b-link" des="a_usuarios/lista" dix="trabajo">Regresar</button>

					</div>
				</div>
			</div>
		</div>
	</div>
	</form>
</div>
