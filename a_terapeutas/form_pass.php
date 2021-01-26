<?php
	require_once("db_.php");
	$id=$_REQUEST['idusuario'];

	$mi="";
	if (isset($_REQUEST['mi'])){
		$mi="1";
	}

	echo "<form is='f-submit' id='form_clientepass' db='a_terapeutas/db_' fun='password' cmodal='1' des='a_terapeutas/editar' desid='idusuario' cmodal='1' dix='trabajo'>";

?>

	<div class='modal-header'>
		<h5 class='modal-title'>Cambiar contraseña</h5>
	</div>

  <div class='modal-body' >
	<?php
		echo "<input  type='hidden' id='id' NAME='id' value='$id'>";
	?>
		<p class='input_title'>Contraseña:</p>
		<div class='form-group input-group'>
			<div class='input-group-prepend'>
				<span class='input-group-text'> <i class='fas fa-user-circle'></i>
			</div>
			<input class='form-control' placeholder='pass1' type='password'  id='pass1' name='pass1' new-password required>
		</div>

		<p class='input_title'>Contraseña:</p>
		<div class='form-group input-group'>
			<div class='input-group-prepend'>
				<span class='input-group-text'> <i class='fa fa-lock'></i>
			</div>
			<input class='form-control' placeholder='pass2' type='password'  id='pass2' name='pass2' new-password required>
		</div>
	</div>
	<div class='modal-footer' >
		<button class='btn btn-warning' type='submit' id='acceso' title='Guardar'>Guardar</button>
		<button type="button" class="btn btn-warning" data-dismiss="modal" title='Cancelar'>Cancelar</button>

  </div>

	</form>
