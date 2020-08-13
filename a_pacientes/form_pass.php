<?php
	$idpaciente=$_REQUEST['idpaciente'];
?>
<form is="f-submit" id="form_pass" db="a_pacientes/db_" fun="password" cmodal="1">
	<div class='modal-header'>
		<h5 class='modal-title'>Cambiar contraseña</h5>
	</div>
  <div class='modal-body' >
	<?php
		echo "<input  type='hidden' id='id1' NAME='id1' value='$idpaciente'>";
	?>
		<label class='input_title'>Contraseña:</label>
		<div class='form-group input-group'>
			<div class='input-group-prepend'>
				<span class='input-group-text'> <i class='fas fa-user-circle'></i>
			</div>
			<input class='form-control' placeholder='pass1' type='password'  id='pass1' name='pass1' required>
		</div>

		<label class='input_title'>Confirmar Contraseña:</label>
		<div class='form-group input-group'>
			<div class='input-group-prepend'>
				<span class='input-group-text'> <i class='fa fa-lock'></i>
			</div>
			<input class='form-control' placeholder='pass2' type='password'  id='pass2' name='pass2' required>
		</div>
	</div>
	<div class="modal-footer">
		<button class='btn btn-warning' type='submit'>Guardar</button>
		<button type="button" class="btn btn-warning" data-dismiss="modal" title='Cancelar'>Cancelar</button>
  </div>
</form>
