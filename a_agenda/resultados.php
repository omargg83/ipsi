<?php
	require_once("db_.php");
  $nombresDias = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado" );


  $idcita=$_REQUEST['idcita'];	//////////fecha

	$fecha_cita=$_REQUEST['fecha_cita'];	//////////fecha
	if (isset($_REQUEST['idpaciente'])){
		$idpaciente=$_REQUEST['idpaciente'];	//////////paciente
	}
	else{
		$idpaciente=$_SESSION['idusuario'];
	}

	if (isset($_REQUEST['idsucursal'])){
		$idsucursal=$_REQUEST['idsucursal']; //////////sucursal
	}
	else{
		$idsucursal=$_SESSION['idsucursal'];
	}

	if (isset($_REQUEST['idusuario'])){
		$idusuario=$_REQUEST['idusuario']; //////////TERAPEUTA
	}
	else{
		$idusuario=$_SESSION['idusuario'];
	}

  $fecha = new DateTime($fecha_cita);
  $nombreDia = $nombresDias[$fecha->format("w")];


  $sql="select * from usuarios_horarios where idusuario=$idusuario and desde_dia='$nombreDia'";
  $sth = $db->dbh->query($sql);
  $citas=$sth->fetchAll(PDO::FETCH_OBJ);

  echo "<div class='container'>";
  	echo "<div class='tabla_v' id='tabla_css'>";

  	echo "<div class='header-row'>";
  		echo "<div class='cell'>#</div>";
  		echo "<div class='cell'>Terapeuta</div>";
  		echo "<div class='cell'>Dia</div>";
  		echo "<div class='cell'>Fecha</div>";
  		echo "<div class='cell'>Horario</div>";
  	echo "</div>";

    foreach($citas as $key){
			$fdesde = new DateTime($key->desde);
      $fhasta = new DateTime($key->hasta);

			$sql="select * from citas where idusuario=$idusuario and desde='$fecha_cita ".$fdesde->format("H:i:s")."'";
			$ver = $db->dbh->query($sql);
			if($ver->rowCount()==0){
      	echo "<div class='body-row'>";

	        echo "<div class='cell'>";
	        	echo "<button class='btn btn-warning btn-sm' type='button' id='can_$key->idhorario' is='b-link'  db='a_agenda/db_' des='a_agenda/index' dix='contenido' fun='agregar_cita' tp='¿Desea solicitar cita la fecha seleccionada?' v_idpacienten='$idpaciente' v_idsucursaln='$idsucursal' v_idusuarion='$idusuario' v_fdesden='$key->desde' v_fhastan='$key->hasta' v_fechan='$fecha_cita' v_idcita='$idcita'>";
							if($idcita>0){
								echo "Reprogramar";
							}
							else{
								echo "Solicitar";
							}
						echo "</button>";
	        echo "</div>";

					echo "<div class='cell text-center'>";
					 $ter=$db->terapueuta_($key->idusuario);
					 echo "$ter->nombre $ter->apellidop $ter->apellidom";
				 	echo "</div>";

					echo "<div class='cell text-center'>";
					 echo $key->desde_dia;
				 	echo "</div>";

	        echo "<div class='cell text-center'>";
	          echo $fecha->format("d-m-Y");
	        echo "</div>";

	        echo "<div class='cell text-center'>";
	          echo $fdesde->format("h:i A");
	          echo " - ";
	          echo $fhasta->format("h:i A");
	        echo "</div>";
	      echo "</div>";
			}
    }
    echo "</div>";
 ?>
