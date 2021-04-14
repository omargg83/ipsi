<?php
	require_once("db_.php");

	$idhorario=$_REQUEST['idhorario'];

	if($idhorario>0){
		$pd=$db->horario_editar($idhorario);
		$desde_fecha = date ( 'H:i' , strtotime($pd->desde));
		$hasta_fecha = date ( 'H:i' , strtotime($pd->hasta));

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

		$desde_fecha=date("H").":00";
		$hasta_fecha = strtotime ( '+59 minute' , strtotime ($desde_fecha) ) ;
		$hasta_fecha = date ( 'H:i' , $hasta_fecha);
	}

	$desde="";
	if(isset($_REQUEST['desde'])){
		$desde=$_REQUEST['desde'];
	}


	$pd = $db->usuario_editar($idusuario);
	$nombre=$pd->nombre;
	$apellidop=$pd->apellidop;
	$apellidom=$pd->apellidom;

	if($desde=='contenido'){
		echo "<form is='f-submit' id='form_cliente' db='a_terapeutas/db_' fun='guardar_horario' des='a_usuarios/horarios' desid='idhorario' dix='modal_form' v_idusuario='$idusuario' v_desde='$desde'>";
	}
	else{
	
		echo "<nav aria-label='breadcrumb'>";
			echo "<ol class='breadcrumb'>";
				echo "<li class='breadcrumb-item' id='lista_track' is='li-link' des='a_terapeutas/index' dix='trabajo'>Terapeuta</li>";
				echo "<li class='breadcrumb-item active' id='lista_track' is='li-link' des='a_terapeutas/terapeuta' v_idusuario='$idusuario' dix='trabajo'>$nombre $apellidop $apellidom</li>";
				echo "<li class='breadcrumb-item active' id='lista_track' is='li-link' des='a_usuarios/editar_trabajo' v_idusuario='$idusuario' dix='trabajo' v_desde='$desde'>Editar</li>";
				echo "<li class='breadcrumb-item active' id='lista_track' is='li-link' des='a_usuarios/horarios' v_idusuario='$idusuario' dix='trabajo' v_desde='$desde'>Horarios</li>";
				echo "<li class='breadcrumb-item active' id='lista_track' is='li-link' des='a_usuarios/editar_horario' v_idusuario='$idusuario' v_idhorario='$idhorario' dix='trabajo' v_desde='$desde'>Editar horario</li>";

				echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_usuarios/horarios' v_idusuario='$idusuario' dix='trabajo' v_desde='$desde'>Regresar</button>";
			echo "</ol>";
		echo "</nav>";
		echo "<div class='container'>";

		echo "<form is='f-submit' id='form_cliente' db='a_terapeutas/db_' fun='guardar_horario' des='a_usuarios/horarios' desid='idhorario' dix='trabajo' v_idusuario='$idusuario' v_desde='$desde'>";
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
					<div class='col-4'>
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

					<div class='col-4'>
						<input type="time" class="form-control " name="desde_fecha" id="desde_fecha" value="<?php echo $desde_fecha;?>" placeholder="Desde" required>
					</div>

					<div class='col-4'>
						<input type="time" class="form-control " name="hasta_fecha" id="hasta_fecha" value="<?php echo $hasta_fecha;?>" placeholder="Hasta" required>
					</div>
				</div>
				
			</div>
			<div class='card-footer'>
				<div class="row">
					<div class='col-12'>
						<?php
							echo "<button class='btn btn-warning btn-sm ml-1' type='submit'>Guardar</button>";

							if($desde=='contenido'){
								echo "<button type='button' class='btn btn-warning btn-sm ml-1' id='lista_penarea' is='b-link'des='a_usuarios/horarios' dix='modal_form' title='regresar' v_idusuario='$idusuario' v_desde='$desde'>Regresar</button>";
								
							}
							if($desde=='trabajo'){
								echo "<button type='button' class='btn btn-warning btn-sm ml-1' id='lista_penarea' is='b-link' des='a_usuarios/horarios' dix='trabajo' title='regresar' v_idusuario='$idusuario' v_mi='1' v_desde='$desde'>Regresar</button>";
							}
						?>
					</div>
				</div>

			</div>
		</div>
	</form>
</div>
