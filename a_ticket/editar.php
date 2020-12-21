<?php
	require_once("db_.php");

	$idusuario=$_REQUEST['idusuario'];

	$numero="";

	if($idusuario>0){
		$pd = $db->ticket_editar($idusuario);
		$numero=$pd->numero;
		
	}
?>

<div class="container">
	<form is="f-submit" id="form_personal" db="a_usuarios/db_" fun="guardar_usuario" des="a_usuarios/editar" desid="idusuario" v_idusuario="<?php echo $idusuario; ?>">
		<input type="hidden" class="form-control form-control-sm" name="idusuario" id="idusuario" value="<?php echo $idusuario ;?>" placeholder="No" readonly>
		<div class='card'>
		<div class='card-header'>
			Ticket
		</div>
		<div class='card-body'>


			<div class='row'>
				<div class="col-4">
					<label for="">Número:</label>
					<input type="text" class="form-control form-control-sm" name="numero" id="numero" value="<?php echo $numero;?>" placeholder="Número" required>
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

					<button class="btn btn-warning btn-sm" type="submit"><i class='far fa-save'></i>Guardar</button>
					<?php
						if($idusuario>0){
							echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_usuarios/form_foto' v_idusuario='$idusuario' omodal='1'><i class='fas fa-camera'></i>Foto</button>";
							echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_usuarios/form_pass' v_idusuario='$idusuario' omodal='1'><i class='fas fa-key'></i>Contraseña</button>";
						}
					?>
					<button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_usuarios/lista" dix="trabajo"><i class="fas fa-undo"></i>Regresar</button>
				</div>
			</div>
		</div>
	</div>
	</form>
</div>
