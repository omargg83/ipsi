<?php
	require_once("db_.php");
	$idusuario=$_REQUEST['idusuario'];


	$desde="";
	if(isset($_REQUEST['desde'])){
		$desde=$_REQUEST['desde'];
	}

	if($desde=='contenido')
		echo "<form is='f-submit' id='form_foto' db='a_usuarios/db_' fun='curriculum' cmodal='1' des='a_usuarios/editar_contenido' desid='idusuario' cmodal='1' v_desde='$desde' dix='contenido'>";
	if($desde=='trabajo')
		echo "<form is='f-submit' id='form_foto' db='a_usuarios/db_' fun='curriculum' cmodal='1' des='a_usuarios/editar_trabajo' desid='idusuario' cmodal='1' v_desde='$desde' dix='trabajo'>";
	if($desde=='cuentas')
		echo "<form is='f-submit' id='form_foto' db='a_usuarios/db_' fun='curriculum' cmodal='1' des='a_usuarios/editar_cuenta' desid='idusuario' cmodal='1' v_desde='$desde' dix='contenido'>";
	
?>


<div class='modal-header'>
	<h5 class='modal-title'>Curriculum</h5>
</div>
  <div class='modal-body' >
		<?php
			echo "<input  type='hidden' id='id1' NAME='id1' value='$idusuario'>";
		?>
		<label>Subir archivo:</label>

		<div class="custom-file">
			<input type="file" name="foto" id="foto" value="" class="custom-file-input">
			<label class="custom-file-label" for="imagen">Documento</label>
		</div>
	</div>
	<div class="modal-footer">
		<button class='btn btn-warning' type='submit'>Guardar</button>
		<button type="button" class="btn btn-warning" data-dismiss="modal" title='Cancelar'>Cancelar</button>
  </div>
</form>
