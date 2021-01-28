<?php
	require_once("db_.php");

  $idcita=$_REQUEST['idcita'];
	$idpaciente="";
	$idsucursal="";
	$idusuario="";
	$fecha=date("Y-m-d");

	if($idcita>0){
		$cita=$db->cita($idcita);
		$idsucursal=$cita->idsucursal;
		$idpaciente=$cita->idpaciente;
		$idusuario=$cita->idusuario;

		$h_desde = new DateTime($cita->desde);
		$fecha=$h_desde->format("Y-m-d");
	}

	$sucursal=$db->sucursal();
	$terapueutas=$db->terapueutas();
	$pacientes=$db->pacientes();


	$fecha_min=date("Y-m-d");
?>

<div class="container">
	<form is="f-submit" id="form_personal" des="a_agenda/resultados" dix='resultados' action='' >
		<input type="hidden" name="idcita" id="idcita" value="<?php echo $idcita;?>">
  	<div class="card">
	  	<div class="card-header">
				Solicitar cita
	  	</div>
			<div class="card-body">
			<div class="row">
				<div class="col-3">
					<label for="">Fecha</label>
					<input type="date" name="fecha_cita" id="fecha_cita" value="<?php echo $fecha;?>" min='<?php echo $fecha_min;?>' class='form-control' required>
				</div>

				<div class="col-3">
					<label for="">Sucursal</label>
					<select name='idsucursal' id='idsucursal' class='form-control'>
					<?php
						foreach($sucursal as $key){
							echo  "<option value=".$key->idsucursal;
							if ($key->idsucursal==$idsucursal){
								echo  " selected ";
							}
							echo  ">$key->nombre</option>";
						}
					?>
					</select>
				</div>

				<div class="col-3">
					<label for="">Pacientes</label>
					<select name='idpaciente' id='idpaciente' class='form-control' >
					<?php
						foreach($pacientes as $key){
							echo  "<option value=".$key->id;
							if ($key->id==$idpaciente){
								echo  " selected ";
							}
							echo  ">$key->nombre $key->apellidop $key->apellidom</option>";
						}
					?>
					</select>
				</div>

				<div class="col-3">
					<label for="">Terapeuta</label>
					<select name='idusuario' id='idusuario' class='form-control'>
					<?php
						foreach($terapueutas as $key){
							echo  "<option value=".$key->idusuario;
							if ($key->idusuario==$idusuario){
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
			<div class='card-footer'>
				<button class="btn btn-warning" type="submit">Buscar</button>
				<button class="btn btn-warning" type="button" is="b-link" des="a_agenda/lista" dix="trabajo">Regresar</button>
			</div>
		</div>
	</form>
	<div id='resultados'>

	</div>
</div>
