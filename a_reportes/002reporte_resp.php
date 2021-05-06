<?php
	require_once("db_.php");
	$nombresDias = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado" );

  $desde=$_REQUEST['desde'];
  $hasta=$_REQUEST['hasta'];

  $idusuario=$_REQUEST['idusuario'];

	$desde.=" 00:00:00";
	$hasta.=" 23:59:59";

	$sql="SELECT idcita, citas.desde, citas.hasta, citas.estatus, citas.estatus_paciente, sucursal.nombre as sucursalx, clientes.nombre, clientes.apellidop, clientes.apellidom, usuarios.nombre as usnombre, usuarios.apellidop as usapellidp, usuarios.apellidom as usapellidom, consultorio.nombre as consultorio, citas.ubicacion FROM citas";
	$sql.=" left outer join sucursal on sucursal.idsucursal=citas.idsucursal";
	$sql.=" left outer join clientes on clientes.id=citas.idpaciente";
	$sql.=" left outer join usuarios on usuarios.idusuario=citas.idusuario";
	$sql.=" left outer join consultorio on consultorio.idconsultorio=citas.idconsultorio";
	$sql.=" where citas.idusuario=$idusuario and (desde between '$desde' and '$hasta')";
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
				echo "<div class='cell' data-titulo='Sucursal'>";

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
