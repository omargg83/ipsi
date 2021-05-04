<?php
	require_once("db_.php");
	$nombresDias = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado" );


	$idpaciente=$_REQUEST['idpaciente'];
	$idterapeuta=$_REQUEST['idterapeuta'];


	$paciente = $db->cliente_editar($idpaciente);
	$nombre=$paciente->nombre." ".$paciente->apellidop." ".$paciente->apellidom;
	$terapeuta=$db->terapeuta($idterapeuta);
	$nombre_t=$terapeuta->nombre." ".$terapeuta->apellidop." ".$terapeuta->apellidom;

	echo "<nav aria-label='breadcrumb'>";
	 echo "<ol class='breadcrumb'>";
		 echo "<li class='breadcrumb-item' id='lista_track' is='li-link' des='a_pacientes/terapeuta_paciente' dix='contenido'>Terapeutas</li>";
		 echo "<li class='breadcrumb-item active' id='lista_track' is='li-link' des='a_pacientes/citas_historico' dix='contenido' v_idpaciente='$idpaciente' v_idterapeuta='$idterapeuta'>$nombre_t</li>";


	 echo "</ol>";
	echo "</nav>";


	echo "<div class='alert alert-warning text-center tituloventana' role='alert'>";
	  echo "Historico de Citas";
	echo "</div>";


  $sql="SELECT idcita, citas.desde, citas.hasta, citas.estatus, citas.estatus_paciente, sucursal.nombre as sucursalx, clientes.nombre, clientes.apellidop, clientes.apellidom, usuarios.nombre as usnombre, usuarios.apellidop as usapellidp, usuarios.apellidom as usapellidom, consultorio.nombre as consultorio, citas.ubicacion FROM citas
	left outer join sucursal on sucursal.idsucursal=citas.idsucursal
	left outer join clientes on clientes.id=citas.idpaciente
	left outer join usuarios on usuarios.idusuario=citas.idusuario
	left outer join consultorio on consultorio.idconsultorio=citas.idconsultorio
	where citas.idpaciente='$idpaciente' and citas.idusuario='$idterapeuta'";


  $sth = $db->dbh->query($sql);
  $acinicial=$sth->fetchAll(PDO::FETCH_OBJ);

	echo "<div class='container'>";
		echo "<div class='tabla_v' id='tabla_css'>";
			echo "<div class='header-row'>";
				echo "<div class='cell' onclick='sortTable(0)'>#</div>";
				echo "<div class='cell' onclick='sortTable(1)'>Sucursal</div>";
				echo "<div class='cell' onclick='sortTable(2)'>Paciente</div>";
				echo "<div class='cell' onclick='sortTable(3)'>Fecha</div>";
				echo "<div class='cell' onclick='sortTable(4)'>Hora</div>";
				echo "<div class='cell' onclick='sortTable(5)'>Dia</div>";
				echo "<div class='cell' onclick='sortTable(6)'>Consultorio</div>";
				echo "<div class='cell' onclick='sortTable(7)'>Estatus</div>";
				echo "<div class='cell' onclick='sortTable(8)'>Estatus paciente</div>";
			echo "</div>";

			  foreach($acinicial as $key){
						$hora = new DateTime($key->desde);
					echo "<div class='body-row'>";
						echo "<div class='cell'>";
							  echo "#".$key->idcita;
						echo "</div>";
						echo "<div class='cell'>";
							 echo $key->sucursalx;;
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
