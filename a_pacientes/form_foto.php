<?php
	require_once("db_.php");
	$idpaciente=$_REQUEST['idpaciente'];
	$desde="";
	if(isset($_REQUEST['desde'])){
		$desde=$_REQUEST['desde'];
	}
	if($desde=='contenido')
		echo "<form is='f-submit' id='form_foto' db='a_pacientes/db_' fun='foto' cmodal='1' des='a_pacientes/editar_contenido' desid='idpaciente' cmodal='1' dix='$desde'>";
	else
		echo "<form is='f-submit' id='form_foto' db='a_pacientes/db_' fun='foto' cmodal='1' des='a_pacientes/editar_trabajo' desid='idpaciente' cmodal='1' dix='$desde'>";


?>

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
