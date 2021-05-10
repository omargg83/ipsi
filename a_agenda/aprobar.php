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

	///////////////////////////////////
	$nombreDia = $nombresDias[$h_desde->format("w")];

	$consultorios=$db->consultorios($cita->desde,$cita->hasta, $nombreDia);


	$consultorios_sug=$db->consultorios_sug($cita->desde,$cita->hasta, $nombreDia, $cita->idusuario);
 ?>

 <nav aria-label='breadcrumb'>
 	<ol class='breadcrumb'>
 		<li class='breadcrumb-item' id='lista_track' is="li-link" des="a_agenda/index" dix="contenido">Citas</li>
 		<li class='breadcrumb-item active' id='lista_track' is="li-link" des="a_agenda/aprobar" v_idcita="<?php echo $idcita; ?>" dix="contenido">Aprobar cita: <?php echo "#".$idcita;?></li>
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
		</div>
	</div>


		<?php
			echo "<div class='card mt-3'>";
				echo "<div class='card-header'>";
					echo "Consultorios disponibles";
				echo "</div>";

				echo "<div class='tabla_v' id='tabla_css'>";

					echo "<div class='header-row'>";
						echo "<div class='cell'>#</div>";
						echo "<div class='cell'>Consultorio</div>";
						echo "<div class='cell'>Dia</div>";
						echo "<div class='cell'>Disponible</div>";
						echo "<div class='cell'>Fin</div>";
					echo "</div>";

					foreach($consultorios as $v2){
						$fdesde = new DateTime($v2->desde);
						$fhasta = new DateTime($v2->hasta);

						$sql="select * from citas where idconsultorio=$v2->idconsultorio and desde='$cita->desde'";
						$ver = $db->dbh->query($sql);
						if($ver->rowCount()==0){
							echo "<div class='body-row'>";
								echo "<div class='cell'>";
									echo "<button class='btn btn-warning btn-sm' type='button' id='can_$v2->idhorario' is='b-link'  db='a_agenda/db_' des='a_agenda/index' dix='contenido' fun='agregar_consultorio' tp='¿Desea aprobar la cita en el consultorio seleccionado?' v_idcita='$idcita' v_idconsultorio='$v2->idconsultorio' v_condesde='$v2->desde' v_conhasta='$v2->hasta' v_desdedia='$v2->desde_dia' v_fechan='$cita->desde'>Asignar</button>";
								echo "</div>";

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
					}
				echo "</div>";
			echo "</div>";


			echo "<div class='card mt-3'>";
				echo "<div class='card-header'>";
					echo "Consultorios Sugeridos";
				echo "</div>";

				echo "<div class='tabla_v' id='tabla_css'>";

					echo "<div class='header-row'>";
						echo "<div class='cell'>#</div>";
						echo "<div class='cell'>Consultorio</div>";
						echo "<div class='cell'>Dia</div>";
						echo "<div class='cell'>Disponible</div>";
						echo "<div class='cell'>Fin</div>";
					echo "</div>";

					foreach($consultorios_sug as $v2){
						$fdesde = new DateTime($v2->desde);
						$fhasta = new DateTime($v2->hasta);

						$sql="select * from citas where idconsultorio=$v2->idconsultorio and desde='$cita->desde'";
						$ver = $db->dbh->query($sql);
						if($ver->rowCount()==0){
							echo "<div class='body-row'>";
								echo "<div class='cell'>";
									echo "<button class='btn btn-warning btn-sm' type='button' id='can_$v2->idhorario' is='b-link'  db='a_agenda/db_' des='a_agenda/index' dix='contenido' fun='agregar_consultorio' tp='¿Desea aprobar la cita en el consultorio seleccionado?' v_idcita='$idcita' v_idconsultorio='$v2->idconsultorio' v_condesde='$v2->desde' v_conhasta='$v2->hasta' v_desdedia='$v2->desde_dia' v_fechan='$cita->desde'>Asignar</button>";
								echo "</div>";

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
					}
				echo "</div>";
			echo "</div>";




			echo "<hr>";

			echo "<form is='f-submit' id='formonline' db='a_agenda/db_' fun='agregar_online' des='a_agenda/index' dix='contenido'>";
				echo "<input type='hidden' name='idcita' id='idcita' value='$idcita'>";
				echo "<div class='card'>";
					echo "<div class='card-header'>";
						echo "Cita en linea";
					echo "</div>";
					echo "<div class='card-body'>";

						echo "<div class='row'>";
							echo "<div class='col-12'>";
								echo "<label>En linea</label>";
								echo "<div id='div_linea' name='div_linea' onclick='editable(this)' style='width:100%; height: 200px; border:1px solid silver'></div>";
								echo "<small>De clic para editar</small>";
							echo "</div>";
						echo "</div>";

						echo "<div class='row'>";
							echo "<div class='col-12'>";
								echo "<button type='submit' class='btn btn-warning btn-sm' >Online</button>";
							echo "</div>";
						echo "</div>";
					echo "</div>";
				echo "</div>";
			echo "</form>";

		 ?>
	</div>


</div>
