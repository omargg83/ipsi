<?php
	require_once("db_.php");
	if (isset($_REQUEST['idconsultorio'])){$idconsultorio=$_REQUEST['idconsultorio'];} else{ $idconsultorio=0;}

	$nombre="Agregar consultorio";
	$idsucursal="";
	if($idconsultorio>0){
		$pd = $db->consultorio($idconsultorio);
		$nombre=$pd->nombre;
		$idsucursal=$pd->idsucursal;
	}

	$sucursal = $db->sucursal_lista();
?>

<nav aria-label='breadcrumb'>
 <ol class='breadcrumb'>
	 <li class='breadcrumb-item' id='lista_track' is="li-link" des="a_consultorios/index" dix="contenido">Citas</li>
	 <li class='breadcrumb-item active' id='lista_track' is="li-link" des="a_consultorios/editar" v_idconsultorio="<?php echo $idconsultorio; ?>" dix="contenido"><?php echo $nombre; ?></li>
	 <button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_consultorios/index" dix="contenido">Regresar</button>
 </ol>
</nav>


<div class="container">
	<form is="f-submit" id="form_cliente" db="a_consultorios/db_" fun="guardar_consultorio" des="a_consultorios/index" dix='contenido' desid='idconsultorio'>
		<input type="hidden" name="idconsultorio" id="idconsultorio" value="<?php echo $idconsultorio;?>">
		<div class='card'>
			<div class='card-body'>
				<div class='row'>
					<div class="col-12">
						<label>Nombre:</label>
							<input type="text" class="form-control " name="nombre" id="nombre" value="<?php echo $nombre;?>" placeholder="Nombre" required maxlength='100'>
					</div>

				</div>
				<div class='row'>
					<div class='col-12'>
						<label for='nombre'>Sucursal</label>
						<select name='idsucursal' id='idsucursal' class='form-control'>
						<?php
							foreach($sucursal as $key){
								echo  "<option value=".$key->idsucursal;
								if ($key->idsucursal==$idsucursal){
									echo  " selected ";
								}
								echo  ">".$key->nombre."</option>";
							}
						?>
						</select>
					</div>
				</div>
			</div>

			<div class='card-footer'>
				<div class="row">
					<div class='col-12'>

						<button class="btn btn-warning btn-sm" type="submit">Guardar</button>

						<button type='button' class='btn btn-warning btn-sm' id='lista_penarea' is='b-link' des='a_consultorios/index' dix='contenido' title='regresar'>Regresar</button>

					</div>
				</div>
			</div>
		</div>
	</form>
</div>
