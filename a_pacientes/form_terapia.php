<?php
	require_once("db_.php");
	$idpaciente=clean_var($_REQUEST['idpaciente']);
?>

<form is="f-submit" id="form_terapiab" des="a_pacientes/terapia_buscar" dix="resultadosx">

	<div class='modal-header'>
		<h5 class='modal-title'>Agregar Actividad</h5>
	</div>
  <div class='modal-body' >
	<?php
		echo "<input  type='hidden' id='idpaciente' NAME='idpaciente' value='$idpaciente'>";
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
		<button class="btn btn-warning" type="button" is="b-link" cmodal="1">Regresar</button>
	</div>
</form>
