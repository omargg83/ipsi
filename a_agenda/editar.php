<?php
	require_once("db_.php");

  $idcita=$_REQUEST['idcita'];
?>
<div class="container">
  <div class="card">
  	<div class="card-header">
			Solicitar cita
  	</div>
		<div class="card-body">
			<div class="row">
				<div class="col-3">
					<label for="">Fecha</label>
					<input type="date" name="fecha_cita" id="fecha_cita" value="" class='form-control'>
				</div>

			</div>
			<div class="" id='fechas_disponibles'>

			</div>
		</div>
  </div>
</div>
