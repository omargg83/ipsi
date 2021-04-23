<?php
	require_once("db_.php");

  	$idcita=$_REQUEST['idcita'];
	$nombresDias = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado" );

	$cita=$db->cita($idcita);

  

	$idsucursal=$cita->idsucursal;
	$idpaciente=$cita->idpaciente;
	$idusuario=$cita->idusuario;
	$estatus=$cita->estatus;
	$fecha_notif=fecha($cita->fecha_notif,2);
	$h_desde = new DateTime($cita->desde);
	$fecha_cita=$h_desde->format("Y-m-d");

	$dia_prog = $nombresDias[$h_desde->format("w")];

	$horad=$h_desde->format("h:i A");

	$horad = date ('h:i A' , strtotime($cita->desde));
	$horah = date ('h:i A' , strtotime($cita->hasta));


	$suc=$db->sucursal_($cita->idsucursal);
	$sucursal_nombre=$suc->nombre;

	$ter=$db->terapueuta_($cita->idusuario);
	$terapeuta_mail=$ter->correo;
	$terapeuta_nombre=$ter->nombre." ".$ter->apellidop." ".$ter->apellidom;

	$cli=$db->cliente_($cita->idpaciente);
	$cliente_nombre=$cli->nombre." ".$cli->apellidop." ".$cli->apellidom;
	$cli_correo=$cli->correo;
	
		
 ?>

 <nav aria-label='breadcrumb'>
 	<ol class='breadcrumb'>
 		<li class='breadcrumb-item' id='lista_track' is="li-link" des="a_agenda/index" dix="contenido">Citas</li>
 		<li class='breadcrumb-item active' id='lista_track' is="li-link" des="a_agenda/ver_cita" v_idcita="<?php echo $idcita; ?>" dix="contenido">Aprobar cita: <?php echo "#".$idcita;?></li>
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
 					<input type="date" name="fecha_cita" id="fecha_cita" value="<?php echo $fecha_cita;?>"  class='form-control' readonly>
 				</div>

 				<div class="col-3">
 					<label for="">Inicio</label>
 					<input type="text" name="horad" id="horad" value="<?php echo $horad;?>"  class='form-control' readonly>
 				</div>

 				<div class="col-3">
 					<label for="">Fin</label>
 					<input type="text" name="horah" id="horah" value="<?php echo $horah;?>"  class='form-control' readonly>
 				</div>

				<div class="col-3">
 					<label for="">Dia</label>
 					<input type="text" name="dia_prog" id="dia_prog" value="<?php echo $dia_prog;?>"  class='form-control' readonly>
 				</div>

				 <div class="col-3">
 					<label for="">Status</label>
 					<input type="text" name="estatus" id="estatus" value="<?php echo $estatus;?>"  class='form-control' readonly>
 				</div>
			
 				<div class="col-4">
 					<label for="">Sucursal</label>
 					<input type="text" name="sx" id="sx" value="<?php echo $sucursal_nombre;?>"  class='form-control' readonly>
 				</div>
			</div>
			<hr>
			<div class="row">
 				<div class="col-8">
 					<label for="">Terapeuta</label>
 					<input type="text" name="ter" id="ter" value="<?php echo $terapeuta_nombre;?>"  class='form-control' readonly>
 				</div>
				 <div class="col-4">
 					<label for="">Terapeuta Correo</label>
 					<input type="text" name="termail" id="termail" value="<?php echo $terapeuta_mail;?>"  class='form-control' readonly>
 				</div>
			</div>
			<div class="row">
 				<div class="col-8">
 					<label for="">Paciente</label>
 					<input type="text" name="cli" id="cli" value="<?php echo $cliente_nombre;?>"  class='form-control' readonly>
 				</div>

				 <div class="col-4">
 					<label for="">Paciente Correo</label>
 					<input type="text" name="cli_correo" id="cli_correo" value="<?php echo $cli_correo;?>"  class='form-control' readonly>
 				</div>				
			</div>
			<?php
				if($citas->notifica){
					echo "<div class='row'>";
						echo "<div class='col-12'>";
							echo "<label for=''>Notificación de confirmación al usuario</label>";
							echo "<input type='text' name='fecha_notif' id='fecha_notif' value='$fecha_notif'  class='form-control' readonly>";
						echo "</div>";
					echo "</div>";
				}
				
			?>
		</div>
	</div>
    <div class='card mt-3'>
        <div class="card-header">
            Detalles de la cita
        </div>
        <div class="card-body">
            <div class="row">
                <?php
                    echo "<div class='col-12'>";
                    if(strlen($cita->online)>0){
                        echo $cita->online;
                    }
                    else{
						if($cita->idconsultorio){
							$consultorio=$db->conss($cita->idconsultorio);
							echo "<label>Consultorio:</label><br>".$consultorio->nombre;
						}
                    }
                    echo "</div>";
                ?>
            </div>
        </div>
    </div>
  

</div>
