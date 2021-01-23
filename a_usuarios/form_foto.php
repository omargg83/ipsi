<?php
	require_once("db_.php");
	$idusuario=$_REQUEST['idusuario'];

	if($_SESSION['nivel']==1  or $_SESSION['nivel']==4){
		$dix='trabajo';
	}
	if($_SESSION['nivel']==2 or $_SESSION['nivel']==3){
		$dix='contenido';
	}
?>
<form is="f-submit" id="form_foto" db="a_usuarios/db_" fun="foto" cmodal="1" des="a_usuarios/editar" dix='<?php echo $dix;?>' desid='idusuario' cmodal='1' dix='contenido'>
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
		<button class='btn btn-warning btn-sm' type='submit'>Guardar</button>
		<button type="button" class="btn btn-warning btn-sm" data-dismiss="modal" title='Cancelar'>Cancelar</button>
  </div>
</form>
