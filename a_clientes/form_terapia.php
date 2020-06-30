<?php
	$id=$_REQUEST['id'];
?>
<div class='modal-header'>
	<h5 class='modal-title'>Agregar Actividad</h5>
</div>
  <div class='modal-body' >
	<?php
		echo "<input  type='hidden' id='id' NAME='id' value='$id'>";
	?>
		<div class='row'>
			<div class='col-12'>
				<label>Buscar actividad</label>
				<div class="input-group mb-3">
				<input type="text" class="form-control" name="b_actividad" id='b_actividad' placeholder='buscar producto' aria-label="buscar producto" aria-describedby="basic-addon2" onkeyup='Javascript: if (event.keyCode==13) buscar_actividad(<?php echo $id;  ?>)'>
				<div class="input-group-append">
					<button class="btn btn-outline-primary btn-sm" type="button" onclick='buscar_actividad(<?php echo $id;  ?>)'><i class='fas fa-search'></i>Buscar</button>
				</div>
			</div>

			<div clas='row' id='resultadosx'>

	    </div>
			<hr>
			<div class='row'>
				<div class='col-12'>
					<div class='btn-group'>
						<button class='btn btn-outline-primary btn-sm' type='button' id='acceso' title='Guardar'><i class='far fa-save'></i>Guardar</button>
						<button type="button" class="btn btn-outline-primary btn-sm" data-dismiss="modal" title='Cancelar'><i class="fas fa-sign-out-alt"></i>Cancelar</button>
					</div>
				</div>
			</div>
		</div>

  </div>
