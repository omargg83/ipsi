<?php
	require_once("db_.php");

  $idcita=$_REQUEST['idcita'];
	$id="";
	$pacientes=$db->pacientes();
	$sucursal=$db->sucursal();
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
				<div class="col-3">
					<label for="">Pacientes</label>
					<select name='idpaciente' id='idpaciente' class='form-control'>
					<?php
						foreach($pacientes as $key){
							echo  "<option value=".$key->id;
							if ($key->id==$id){
								echo  " selected ";
							}
							echo  ">$key->nombre $key->apellidop $key->apellidom</option>";
						}
					?>
					</select>
				</div>
			</div>

			<div class="" id='fechas_disponibles'>

			</div>
		</div>
  </div>
</div>
