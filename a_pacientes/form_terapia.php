<?php
	require_once("db_.php");
	$id1=clean_var($_REQUEST['id1']);
?>

<form is="f-submit" id="form_terapiab" des="a_pacientes/terapia_buscar" dix="resultadosx">

	<div class='modal-header'>
		<h5 class='modal-title'>Agregar Actividad</h5>
	</div>
  <div class='modal-body' >
	<?php
		echo "<input  type='hidden' id='id1' NAME='id1' value='$id1'>";
	?>
		<div class='row'>
			<div class='col-12'>
				<label>Buscar actividad</label>
				<div class="input-group mb-3">
				<input type="text" class="form-control" name="terapia_b" id='terapia_b' placeholder='buscar producto' />
			</div>
				<div clas='row' id='resultadosx'>
		    </div>
			</div>
		</div>
	</div>
	<div class='modal-footer' >
		<button class="btn btn-warning" type="submit" id1="">Buscar</button>
		<button type="button" class="btn btn-warning" data-dismiss="modal" title='Cancelar'>Cancelar</button>
	</div>
</form>
