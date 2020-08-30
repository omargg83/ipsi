<?php
require_once("db_.php");
$idpaciente=$_SESSION['idusuario'];
?>
<div class='modal-header'>
	<h5 class='modal-title'>Cambiar contraseña</h5>
</div>
<div class='modal-body' >
	<form is="f-submit" id="form_passx" db="a_paciente_perfil/db_" fun="password" cmodal="0" des="a_paciente_perfil/index" v_idpaciente="<?php echo $idpaciente; ?>" dix='contenido'>
	<?php
	echo "<input  type='hidden' id='id' NAME='id' value='$idpaciente'>";
	?>
	<p class='input_title'>Contraseña:</p>
		<div class='form-group input-group'>
			<div class='input-group-prepend'>
				<span class='input-group-text'> <i class='fas fa-user-circle'></i>
			</div>
			<input class='form-control' placeholder='pass1' type='password'  id='pass1' name='pass1' required>
		</div>

	<p class='input_title'>Contraseña:</p>
		<div class='form-group input-group'>
			<div class='input-group-prepend'>
				<span class='input-group-text'> <i class='fa fa-lock'></i>
			</div>
			<input class='form-control' placeholder='pass2' type='password'  id='pass2' name='pass2' required>
		</div>
		<div class='btn-group'>
			<button class='btn btn-warning btn-sm' type='submit' title='Guardar'><i class='far fa-save'></i>Guardar</button>
			<button type="button" class="btn btn-warning btn-sm" data-dismiss="modal" title='Cancelar'><i class="fas fa-sign-out-alt"></i>Cancelar</button>
		</div>
	</form>
</div>
