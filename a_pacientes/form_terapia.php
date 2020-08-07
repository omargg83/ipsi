<?php
	$id1=$_REQUEST['id1'];
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
					<button class="btn btn-warning btn-block" type="button" onclick='buscar_actividad(<?php echo $id;  ?>)'><i class='fas fa-search'></i>Buscar</button>
				</div>
			</div>
				<div clas='row' id='resultadosx'>
		    </div>
			</div>
		</div>
	</div>
	<div class='modal-footer' >
		<button class='btn btn-warning' type='button' id='acceso' title='Guardar'>Guardar</button>
		<button type="button" class="btn btn-warning" data-dismiss="modal" title='Cancelar'>Cancelar</button>
	</div>

<script>
	alert("gola muindo");
</script>
