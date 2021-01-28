<?php
	require_once("db_.php");

	$pag=0;
	$texto="";
	isset($_REQUEST['idsucursal']) ? $idsucursal=$_REQUEST['idsucursal'] : $idsucursal="";
	isset($_REQUEST['idusuario']) ? $idusuario=$_REQUEST['idusuario'] : $idusuario="";
	isset($_REQUEST['fecha_cita']) ? $fecha_cita=$_REQUEST['fecha_cita'] : $fecha_cita="";
	isset($_REQUEST['idpaciente']) ? $idpaciente=$_REQUEST['idpaciente'] : $idpaciente="";

	if(isset($_REQUEST['buscar'])){
		$texto=$_REQUEST['buscar'];
		$pd = $db->agenda_buscar($texto);
		$texto=1;
	}
	else{
		if(isset($_REQUEST['pag'])){
			$pag=$_REQUEST['pag'];
		}
		$pd = $db->agenda_lista($pag,$idsucursal,$idusuario,$fecha_cita,$idpaciente);
	}

  echo "<div class='header-row'>";
    echo "<div class='cell'>#</div>";
    echo "<div class='cell'>Sucursal</div>";
    echo "<div class='cell'>Paciente</div>";
    echo "<div class='cell'>Hora</div>";
    echo "<div class='cell'>Fecha</div>";
		echo "<div class='cell'>Terapeuta</div>";
    echo "<div class='cell'>status</div>";
  echo "</div>";

  foreach($pd as $key){
    echo "<div class='body-row' draggable='true'>";
      echo "<div class='cell'>";

        echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_agenda/editar' dix='trabajo' tp='edit' v_idcita='$key->idcita' title='editar'>Editar</button>";

        echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_agenda/lista' dix='trabajo' db='a_agenda/db_' fun='cita_quitar' v_idcita='$key->idcita' tp='¿Desea eliminar la cita seleccionada?' title='Borrar'>Eliminar</button>";
        echo $key->idcita;
      echo "</div>";

      echo "<div class='cell' data-titulo='Sucursal'>";
        echo $db->sucursal_($key->idsucursal)->nombre;
      echo "</div>";

			echo "<div class='cell' data-titulo='Paciente'>";
        $ter=$db->cliente_($key->idpaciente);
        echo $ter->nombre." ".$ter->apellidop." ".$ter->apellidom;
      echo "</div>";

      echo "<div class='cell' data-titulo='Hora'>";
        $hora = new DateTime($key->desde);
        echo $hora->format("h:i A")." - " ;
				$hora = new DateTime($key->hasta);
				echo $hora->format("h:i A");
      echo "</div>";

      echo "<div class='cell' data-titulo='Fecha'>";
        echo $hora->format("d-m-Y");
      echo "</div>";

			echo "<div class='cell' data-titulo='Terapeuta'>";
        $ter=$db->terapueuta_($key->idusuario);
        echo $ter->nombre." ".$ter->apellidop." ".$ter->apellidom;
      echo "</div>";



      echo "<div class='cell' data-titulo='Status'>";
        echo $key->estatus;
      echo "</div>";
    echo "</div>";
  }
?>
