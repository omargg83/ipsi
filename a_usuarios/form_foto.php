<?php
	require_once("db_.php");
	$idusuario=$_REQUEST['idusuario'];


	$mi="";
	if (isset($_REQUEST['mi'])){
		$mi="1";
	}

	if(strlen($mi)==0){
		echo "<form is='f-submit' id='form_foto' db='a_usuarios/db_' fun='foto' cmodal='1' des='a_usuarios/editar' desid='idusuario' cmodal='1' dix='trabajo'>";
	}
	else{
		echo "<form is='f-submit' id='form_foto' db='a_usuarios/db_' fun='foto' cmodal='1' des='a_usuarios/editar_p' desid='idusuario' cmodal='1' dix='contenido'>";
	}
?>


<div class='modal-header'>
	<h5 class='modal-title'>Actualizar foto</h5>
</div>
  <div class='modal-body' >
		<?php
			echo "<input  type='hidden' id='id1' NAME='id1' value='$idusuario'>";
		?>
		<label>Subir archivo:</label>

		<div class="custom-file">
			<input type="file" name="foto" id="foto" value="" class="custom-file-input">
			<label class="custom-file-label" for="imagen">Imagen</label>
		</div>
	</div>
	<div class="modal-footer">
		<button class='btn btn-warning' type='submit'>Guardar</button>
		<button type="button" class="btn btn-warning" data-dismiss="modal" title='Cancelar'>Cancelar</button>
  </div>
</form>
