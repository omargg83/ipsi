<?php
	require_once("db_.php");

	$idhorario=$_REQUEST['idhorario'];

  if($idhorario>0){
    $pd=$db->horario_editar($idhorario);
    $desde = date ( 'h:i' , strtotime($pd->desde));
    $hasta = date ( 'h:i' , strtotime($pd->hasta));

		$desdef = date ( 'Y-m-d' , strtotime($pd->desde));
    $hastaf = date ( 'Y-m-d' , strtotime($pd->hasta));
    $idusuario=$pd->idusuario;

		$desde_dia=$pd->desde_dia;
		$recurrente=$pd->recurrente;
  }
  else{
    $idusuario=$_REQUEST['idusuario'];
		$desdef=date("Y-m-d");
		$hastaf=date("Y-m-d");

		$desde_dia="";
		$recurrente="";

    $desde=date("h").":00";
    $hasta = strtotime ( '+59 minute' , strtotime ($desde) ) ;
    $hasta = date ( 'h:i' , $hasta);
  }

	$mi="";
	if (isset($_REQUEST['mi'])){
		$mi="1";
	}

?>

<div class="container">
	<?php
		if($mi!=1){
			echo "<form is='f-submit' id='form_cliente' db='a_terapeutas/db_' fun='guardar_horario' des='a_terapeutas/horarios' desid='idhorario' dix='trabajo' v_idusuario='$idusuario'>";
		}
		else{
			echo "<form is='f-submit' id='form_cliente' db='a_terapeutas/db_' fun='guardar_horario' des='a_terapeutas/horarios' desid='idhorario' dix='contenido' v_idusuario='$idusuario' v_mi='1'>";
		}
		?>
			<input type="hidden" name="idhorario" id="idhorario" value="<?php echo $idhorario;?>">
			<input type="hidden" name="idusuario" id="idusuario" value="<?php echo $idusuario;?>">
			<div class="card">
				<div class='card-header'>
					Horarios
				</div>
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
						<div class='col-6'>
							<div class="form-group form-check">
						    <input type="checkbox" class="form-check-input" id="recurrente" name='recurrente' value='1' <?php if($recurrente==1){ echo "checked";} ?>>
						    <label class="form-check-label" for="recurrente">Recurrente</label>
						  </div>
						</div>
					</div>
					<div class="row">
						<div class='col-12'>
							<?php
								echo "<button class='btn btn-warning btn-sm' type='submit'>Guardar</button>";
								if($mi!=1){
	                echo "<button type='button' class='btn btn-warning btn-sm' id='lista_penarea' is='b-link' des='a_terapeutas/horarios' dix='trabajo' title='regresar' v_idusuario='$idusuario'>Regresar</button>";
								}
								else{
									echo "<button type='button' class='btn btn-warning btn-sm' id='lista_penarea' is='b-link' des='a_terapeutas/horarios' dix='contenido' title='regresar' v_idusuario='$idusuario' v_mi='1'>Regresar</button>";
								}
							?>
						</div>
					</div>

				</div>
			</div>
		</form>
</div>
