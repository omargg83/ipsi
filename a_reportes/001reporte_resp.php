<?php
	require_once("db_.php");
	$nombresDias = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado" );

  $desde=$_REQUEST['desde'];
  $hasta=$_REQUEST['hasta'];
  $idpaciente=$_REQUEST['idpaciente'];
	
	$desde.=" 00:00:00";
	$hasta.=" 23:59:59";

	$sql="SELECT idcita, citas.desde, citas.hasta, citas.estatus, citas.estatus_paciente, sucursal.nombre as sucursalx, clientes.nombre, clientes.apellidop, clientes.apellidom, usuarios.nombre as usnombre, usuarios.apellidop as usapellidp, usuarios.apellidom as usapellidom, consultorio.nombre as consultorio, citas.ubicacion FROM citas";
	$sql.=" left outer join sucursal on sucursal.idsucursal=citas.idsucursal";
	$sql.=" left outer join clientes on clientes.id=citas.idpaciente";
	$sql.=" left outer join usuarios on usuarios.idusuario=citas.idusuario";
	$sql.=" left outer join consultorio on consultorio.idconsultorio=citas.idconsultorio";
	$sql.=" where idpaciente=$idpaciente and (desde between '$desde' and '$hasta')";
	$sth = $db->dbh->prepare($sql);
	$sth->execute();
	$pd=$sth->fetchAll(PDO::FETCH_OBJ);

	echo "<div class='tabla_v' id='tabla_css'>";
		echo "<div class='header-row'>";
			echo "<div class='cell' onclick='sortTable(0)'>#</div>";
			echo "<div class='cell' onclick='sortTable(1)'>#ID</a></div>";
			echo "<div class='cell' onclick='sortTable(2)'>Sucursal</a></div>";
			echo "<div class='cell' onclick='sortTable(3)'>Paciente</a></div>";
			echo "<div class='cell' onclick='sortTable(4)'>Fecha</a></div>";
			echo "<div class='cell' onclick='sortTable(5)'>Hora</a></div>";
			echo "<div class='cell' onclick='sortTable(6)'>Dia</a></div>";
			echo "<div class='cell' onclick='sortTable(7)'>Terapeuta</a></div>";
			echo "<div class='cell' onclick='sortTable(8)'>Consultorio</a></div>";
			echo "<div class='cell' onclick='sortTable(9)'>Estatus</a></div>";
			echo "<div class='cell' onclick='sortTable(10)'>Estatus paciente</a></div>";
		echo "</div>";

		foreach($pd as $key){
			$hora = new DateTime($key->desde);

			echo "<div class='body-row'>";
				echo "<div class='cell'>";

				if($key->estatus=="Pendiente"){
				if($_SESSION['nivel']==1 or $_SESSION['nivel']==3 or $_SESSION['nivel']==4){
					echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_agenda/aprobar' dix='contenido' tp='edit' v_idcita='$key->idcita' title='editar'>Aprobar</button>";
				}
			}

			if($_SESSION['nivel']==1 or $_SESSION['nivel']==2 or $_SESSION['nivel']==3 or $_SESSION['nivel']==4){
				if($key->estatus=="Pendiente"){
							echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_agenda/editar' dix='contenido' tp='edit' v_idcita='$key->idcita' title='editar'>Editar</button>";
				}
			}
			if($key->estatus=="Aprobada" or $key->estatus=="Cancelada"){
				echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_agenda/ver_cita' dix='contenido' tp='edit' v_idcita='$key->idcita' title='editar'>Ver</button>";
			}

			if($_SESSION['nivel']==666 and $key->estatus=='Aprobada'){
				$ts_fin = strtotime(date("Y-m-d H:m:i"));
				$ts_ini = strtotime($key->desde);

				$diferencia=($ts_ini-$ts_fin)/3600;

				//echo "<br>dif:".$diferencia;
				//echo "<br>confirma:".$_SESSION['horas_confirma'];
				if($diferencia>$_SESSION['horas_confirma'] and strlen($key->estatus_paciente)==0){
					echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_agenda/lista' dix='trabajo' db='a_agenda/db_' fun='paciente_confirma' v_idcita='$key->idcita' tp='¿Desea confirmar la cita seleccionada?' title='Confirmar'>Confirmar</button>";
				}
			}
			/*
			if($key->estatus!='Cancelada'){
				echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_agenda/lista' dix='trabajo' db='a_agenda/db_' fun='cita_quitar' v_idcita='$key->idcita' tp='¿Desea cancelar la cita seleccionada?' title='Borrar'>Cancelar</button>";
			}
			*/


				echo "</div>";

				echo "<div class='cell' data-titulo='Sucursal'>";
					echo "#".$key->idcita;
				echo "</div>";

				echo "<div class='cell' data-titulo='Sucursal'>";
					echo $key->sucursalx;
				echo "</div>";

			echo "<div class='cell' data-titulo='Paciente'>";
					echo $key->nombre." ".$key->apellidop." ".$key->apellidom;
				echo "</div>";

				echo "<div class='cell' data-titulo='Fecha'>";
					echo $hora->format("d-m-Y");
				echo "</div>";

				echo "<div class='cell' data-titulo='Hora'>";
					echo $hora->format("h:i A")." - " ;
					$hora = new DateTime($key->hasta);
					echo $hora->format("h:i A");
				echo "</div>";

			echo "<div class='cell' data-titulo='Dia'>";
				$dia_prog = $nombresDias[$hora->format("w")];
				echo $dia_prog;
					echo "</div>";

			echo "<div class='cell' data-titulo='Terapeuta'>";
				echo $key->usnombre." ".$key->usapellidp." ".$key->usapellidom;
			echo "</div>";

			echo "<div class='cell' data-titulo='Consultorio'>";
				if($key->ubicacion=="Fisica"){
					if(strlen($key->consultorio)>0 and $key->estatus=="Aprobada" )
						echo $key->consultorio;
				}
				if($key->ubicacion=="En linea"){
					echo "Online";
				}
			echo "</div>";

					echo "<div class='cell' data-titulo='Status'>";
						echo $key->estatus;
					echo "</div>";

				echo "<div class='cell' data-titulo='Status'>";
					if($key->estatus_paciente=="Confirmar"){
						echo "Cita confirmada por el paciente";
					}
				echo "</div>";
			echo "</div>";
		}
		echo "</div>";
	echo "</div>";
?>
