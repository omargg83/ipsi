<?php
	require_once("db_.php");

	$idhorario=$_REQUEST['idhorario'];

  if($idhorario>0){
    $pd=$db->horario_editar($idhorario);
    $desde = date ( 'h:i' , strtotime($pd->desde));
    $hasta = date ( 'h:i' , strtotime($pd->hasta));

		$desdef = date ( 'Y-m-d' , strtotime($pd->desde));
    $hastaf = date ( 'Y-m-d' , strtotime($pd->hasta));
    $idconsultorio=$pd->idconsultorio;

		$desde_dia=$pd->desde_dia;
		$recurrente=$pd->recurrente;
  }
  else{
    $idconsultorio=$_REQUEST['idconsultorio'];
		$desdef=date("Y-m-d");
		$hastaf=date("Y-m-d");

		$desde_dia="";
		$recurrente="";

    $desde=date("h").":00";
    $hasta = strtotime ( '+59 minute' , strtotime ($desde) ) ;
    $hasta = date ( 'h:i' , $hasta);
  }

	$pd = $db->consultorio($idconsultorio);
	$nombre=$pd->nombre;
?>

<nav aria-label='breadcrumb'>
 <ol class='breadcrumb'>
	 <li class='breadcrumb-item' id='lista_track' is="li-link" des="a_consultorios/index" dix="contenido">Citas</li>

	 <li class='breadcrumb-item active' id='lista_track' is="li-link" des="a_consultorios/editar" v_idconsultorio="<?php echo $idconsultorio; ?>" dix="contenido"><?php echo $nombre; ?></li>

	 <li class='breadcrumb-item active' id='lista_track' is="li-link" des="a_consultorios/horarios" v_idconsultorio="<?php echo $idconsultorio; ?>" v_idhorario='<?php echo $idhorario; ?>' dix="contenido">Horario</li>

	 <li class='breadcrumb-item active' id='lista_track' is="li-link" des="a_consultorios/editar_horario" v_idconsultorio="<?php echo $idconsultorio; ?>" v_idhorario='<?php echo $idhorario; ?>' dix="contenido">Editar Horario</li>

	 <button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_consultorios/horarios" _idconsultorio="<?php echo $idconsultorio; ?>" v_idhorario='<?php echo $idhorario; ?>' dix="contenido">Regresar</button>
 </ol>
</nav>

<div class="container">
		<form is="f-submit" id="form_cliente" db="a_consultorios/db_" fun="guardar_horario" des="a_consultorios/horarios" dix='contenido' desid='idhorario' v_idconsultorio='<?php echo $idconsultorio;?>'>
			<input type="hidden" name="idhorario" id="idhorario" value="<?php echo $idhorario;?>">
			<input type="hidden" name="idconsultorio" id="idconsultorio" value="<?php echo $idconsultorio;?>">
			<div class="card">
				<div class='card-body'>
					<div class='row'>
						<div class='col-3'>
							<label for='nombre'>Desde</label>
						</div>

						<div class='col-3'>
							<select class="form-control" name="desde_dia" id="desde_dia">
								<?php
									echo "<option value='Domingo'"; if($desde_dia=="Domingo"){ echo "selected"; } echo ">Domingo</option>";
									echo "<option value='Lunes'"; if($desde_dia=="Lunes"){ echo "selected"; } echo ">Lunes</option>";
									echo "<option value='Martes'"; if($desde_dia=="Martes"){ echo "selected"; } echo ">Martes</option>";
									echo "<option value='Miercoles'"; if($desde_dia=="Miercoles"){ echo "selected"; } echo ">Miercoles</option>";
									echo "<option value='Jueves'"; if($desde_dia=="Jueves"){ echo "selected"; } echo ">Jueves</option>";
									echo "<option value='Viernes'"; if($desde_dia=="Viernes"){ echo "selected"; } echo ">Viernes</option>";
									echo "<option value='Sabado'"; if($desde_dia=="Sabado"){ echo "selected"; } echo ">Sabado</option>";
								?>
							</select>
						</div>

						<div class='col-3'>
							<input type="time" class="form-control " name="desde" id="desde" value="<?php echo $desde;?>" placeholder="Desde" required>
						</div>

						<div class='col-3'>
							<input type="time" class="form-control " name="hasta" id="hasta" value="<?php echo $hasta;?>" placeholder="Hasta" required>
						</div>
					</div>

					<div class="row">
						<div class='col-12'>
								<button class="btn btn-warning btn-sm" type="submit">Guardar</button>

                <button type='button' class='btn btn-warning btn-sm' id='lista_penarea' is='b-link' des='a_consultorios/horarios' dix='contenido' title='regresar' v_idconsultorio='<?php echo $idconsultorio;?>'>Regresar</button>
						</div>
					</div>

				</div>
			</div>
		</form>
</div>
