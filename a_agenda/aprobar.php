<?php
	require_once("db_.php");

  $idcita=$_REQUEST['idcita'];
	$nombresDias = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado" );

	$cita=$db->cita($idcita);
	$idsucursal=$cita->idsucursal;
	$idpaciente=$cita->idpaciente;
	$idusuario=$cita->idusuario;
	$estatus=$cita->estatus;

	$h_desde = new DateTime($cita->desde);
	$fecha=$h_desde->format("Y-m-d");

	$dia_prog = $nombresDias[$h_desde->format("w")];

	$horad=$h_desde->format("h:i A");

  $horad = date ('h:i A' , strtotime($cita->desde));
  $horah = date ('h:i A' , strtotime($cita->hasta));


	$suc=$db->sucursal_($cita->idsucursal);
	$sucursal_nombre=$suc->nombre;

	$ter=$db->terapueuta_($cita->idusuario);
	$terapeuta_nombre=$ter->nombre." ".$ter->apellidop." ".$ter->apellidom;

	$cli=$db->cliente_($cita->idpaciente);
	$cliente_nombre=$cli->nombre." ".$cli->apellidop." ".$cli->apellidom;

	///////////////////////////////////
	$nombreDia = $nombresDias[$h_desde->format("w")];
	$consultorios=$db->consultorios($cita->desde,$cita->hasta, $nombreDia);
 ?>

 <nav aria-label='breadcrumb'>
 	<ol class='breadcrumb'>
 		<li class='breadcrumb-item' id='lista_track' is="li-link" des="a_agenda/index" dix="contenido">Citas</li>
 		<li class='breadcrumb-item active' id='lista_track' is="li-link" des="a_agenda/aprobar" v_idcita="<?php echo $idcita; ?>" dix="contenido">Aprobar cita</li>
 		<button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_agenda/index" dix="contenido">Regresar</button>
 	</ol>
 </nav>

 <div class="container">
	<input type="hidden" name="idcita" id="idcita" value="<?php echo $idcita;?>">
 	<div class="card">
			<div class="card-body">
 			<div class="row">
 				<div class="col-3">
 					<label for="">Fecha</label>
 					<input type="date" name="fecha_cita" id="fecha_cita" value="<?php echo $fecha;?>"  class='form-control' readonly>
 				</div>

 				<div class="col-3">
 					<label for="">Inicio</label>
 					<input type="text" name="hora" id="hora" value="<?php echo $horad;?>"  class='form-control' readonly>
 				</div>

 				<div class="col-3">
 					<label for="">Fin</label>
 					<input type="text" name="hora" id="hora" value="<?php echo $horah;?>"  class='form-control' readonly>
 				</div>

				<div class="col-3">
 					<label for="">Dia</label>
 					<input type="text" name="dia_prog" id="dia_prog" value="<?php echo $dia_prog;?>"  class='form-control' readonly>
 				</div>

 				<div class="col-3">
 					<label for="">Sucursal</label>
 					<input type="text" name="sx" id="sx" value="<?php echo $sucursal_nombre;?>"  class='form-control' readonly>
 				</div>
 				<div class="col-3">
 					<label for="">Terapeuta</label>
 					<input type="text" name="ter" id="ter" value="<?php echo $terapeuta_nombre;?>"  class='form-control' readonly>
 				</div>
 				<div class="col-3">
 					<label for="">Paciente</label>
 					<input type="text" name="cli" id="cli" value="<?php echo $cliente_nombre;?>"  class='form-control' readonly>
 				</div>
 				<div class="col-3">
 					<label for="">Status</label>
 					<input type="text" name="cli" id="cli" value="<?php echo $estatus;?>"  class='form-control' readonly>
 				</div>
			</div>
		</div>
	</div>

	<div >
		<?php
		echo "<div class='tabla_v' id='tabla_css'>";

			echo "<div class='header-row'>";
				echo "<div class='cell'>Consultorio</div>";
				echo "<div class='cell'>Dia</div>";
				echo "<div class='cell'>Disponible</div>";
				echo "<div class='cell'>Fin</div>";
			echo "</div>";

			foreach($consultorios as $v2){
				echo "<div class='body-row'>";
					echo "<div class='cell'>";
						echo $v2->nombre;
					echo "</div>";
					echo "<div class='cell'>";
						echo $v2->desde_dia;
					echo "</div>";
					echo "<div class='cell'>";
						$fdesde = new DateTime($v2->desde);
						echo $fdesde->format("h:i A");
					echo "</div>";
					echo "<div class='cell'>";
						$fdesde = new DateTime($v2->hasta);
						echo $fdesde->format("h:i A");
					echo "</div>";
				echo "</div>";
			}
			echo "</div>";
		 ?>
	</div>


</div>
