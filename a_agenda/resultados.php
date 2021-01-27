<?php
	require_once("db_.php");
  $nombresDias = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado" );


  $fecha_cita=$_REQUEST['fecha_cita'];
  $idpaciente=$_REQUEST['idpaciente'];
  $idsucursal=$_REQUEST['idsucursal'];
  $idusuario=$_REQUEST['idusuario'];

  $fecha = new DateTime($fecha_cita);
  $nombreDia = $nombresDias[$fecha->format("w")];


  $sql="select * from usuarios_horarios where idusuario=$idusuario and desde_dia='$nombreDia'";
  $sth = $db->dbh->query($sql);
  $citas=$sth->fetchAll(PDO::FETCH_OBJ);


  echo "<div class='container'>";
  	echo "<div class='tabla_v' id='tabla_css'>";

  	echo "<div class='header-row'>";
  		echo "<div class='cell'>#</div>";
  		echo "<div class='cell'>Dia</div>";
  		echo "<div class='cell'>Horario</div>";
  	echo "</div>";

    foreach($citas as $key){
      $fdesde = new DateTime($key->desde);
      $fhasta = new DateTime($key->hasta);

      echo "<div class='body-row' draggable='true'>";
        echo "<div class='cell'>";

        	echo "<button class='btn btn-warning btn-sm' type='button' id='can_$key->idhorario' is='b-link'  db='a_agenda/db_' des='a_agenda/lista' dix='trabajo' fun='agregar_cita' tp='¿Desea solicitar cita la fecha seleccionada?' v_idpaciente='$idpaciente' v_idsucursal='$idsucursal' v_idusuario='$idusuario' v_fdesde='$key->desde' v_fhasta='$key->hasta' v_fecha='$fecha_cita' v_idcita='0'>Solicitar</button>";

        echo "</div>";

        echo "<div class='cell'>";
          echo $fecha->format("d-m-Y");
        echo "</div>";

        echo "<div class='cell'>";
          echo $fdesde->format("h:i");
          echo " - ";
          echo $fhasta->format("h:i");
        echo "</div>";
      echo "</div>";
    }
    echo "</div>";
 ?>
