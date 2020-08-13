<?php
	$idpaciente=$_REQUEST['idpaciente'];
?>
<form is="f-submit" id="form_foto" db="a_pacientes/db_" fun="foto" cmodal="1">
<div class='modal-header'>
	<h5 class='modal-title'>Actualizar foto</h5>
</div>
  <div class='modal-body' >
		<?php
			echo "<input  type='hidden' id='id1' NAME='id1' value='$idpaciente'>";
		?>
		<label>Subir archivo:</label>

		<div class="custom-file">
			<input type="file" name="foto" id="foto" value="" class="custom-file-input">
			<label class="custom-file-label" for="imagen">Imagen</label>
		</div>
	</div>
	<div class="modal-footer">
		<button class='btn btn-warning btn-sm' type='submit'>Guardar</button>
		<button type="button" class="btn btn-warning btn-sm" data-dismiss="modal" title='Cancelar'>Cancelar</button>
  </div>
</form>
