<?php
	require_once("db_.php");
	if (isset($_REQUEST['idsucursal'])){$idsucursal=$_REQUEST['idsucursal'];} else{ $idsucursal=0;}

	$nombre="";
	$ubicacion="";
	$ciudad="";
	$tel1="";
	$tel2="";
	$cp="";
	$estado="";
	$tipoticket="";
	$etiqueta="";
	$matriz="";
	if($idsucursal>0){
		$pd = $db->sucursal($idsucursal);
		$nombre=$pd->nombre;
		$ubicacion=$pd->ubicacion;
		$ciudad=$pd->ciudad;
		$tel1=$pd->tel1;
		$tel2=$pd->tel2;
		$cp=$pd->cp;
		$estado=$pd->estado;
		$tipoticket=$pd->tipoticket;
		$etiqueta=$pd->etiqueta;
		$matriz=$pd->matriz;
	}
?>

<div class="container">
	<form is="f-submit" id="form_cliente" db="a_sucursal/db_" fun="guardar_sucursal" des="a_sucursal/editar" desid='idsucursal'>
		<input type="hidden" name="idsucursal" id="idsucursal" value="<?php echo $idsucursal;?>">
		<div class='card'>
			<div class='card-header'>
				Editar sucursal
			</div>
			<div class='card-body'>
				<div class='row'>
					<div class="col-12 col-sm-6">
						<label>Nombre:</label>
							<input type="text" class="form-control " name="nombre" id="nombre" value="<?php echo $nombre;?>" placeholder="Nombre" required maxlength='100'>
					</div>
					<div class="col-12 col-sm-6">
						<label>Ubicación:</label>
						<input type="text" class="form-control " name="ubicacion" id="ubicacion" value="<?php echo $ubicacion;?>" placeholder="Ubicación" maxlength='155'>
					</div>
					<div class="col-12 col-sm-4">
						<label>Ciudad:</label>
						<input type="text" class="form-control " name="ciudad" id="ciudad" value="<?php echo $ciudad;?>" placeholder="Ciudad" maxlength='145'>
					</div>

					<div class="col-12 col-sm-4">
						<label>Estado:</label>
						<input type="text" class="form-control " name="estado" id="estado" value="<?php echo $estado;?>" placeholder="Estado" maxlength='45'>
					</div>

					<div class="col-12 col-sm-4">
						<label>Código Postal:</label>
							<input type="text" class="form-control " name="cp" id="cp" value="<?php echo $cp;?>" placeholder="Código  postal" maxlength='5'>
					</div>
					<div class="col-12 col-sm-4">
						<label>Teléfono 1:</label>
							<input type="text" class="form-control " name="tel1" id="tel1" value="<?php echo $tel1;?>" placeholder="Teléfono 1" maxlength='15'>
					</div>

					<div class="col-12 col-sm-4">
						<label>Teléfono 2:</label>
							<input type="text" class="form-control " name="tel2" id="tel2" value="<?php echo $tel2;?>" placeholder="Teléfono 2" maxlength='15'>
					</div>

				</div>
			</div>

			<div class='card-footer'>
				<div class="row">
					<div class='col-12'>

						<button class="btn btn-warning btn-sm" type="submit">Guardar</button>
						<button type='button' class='btn btn-warning btn-sm' id='lista_penarea' is='b-link' des='a_sucursal/lista' dix='trabajo' title='regresar'>Regresar</button>

					</div>
				</div>
			</div>
		</div>
	</form>
</div>
