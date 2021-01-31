<?php
	require_once("db_.php");

	$pag=0;
	$texto="";

	isset($_REQUEST['idsucursal']) ? $idsucursal=$_REQUEST['idsucursal'] : $idsucursal="";
	isset($_REQUEST['idusuario']) ? $idusuario=$_REQUEST['idusuario'] : $idusuario="";
	isset($_REQUEST['fecha_cita']) ? $fecha_cita=$_REQUEST['fecha_cita'] : $fecha_cita="";
	isset($_REQUEST['idpaciente']) ? $idpaciente=$_REQUEST['idpaciente'] : $idpaciente="";

	if($_SESSION['nivel']==666){
		$idpaciente=$_SESSION['idusuario'];
		$idsucursal=$_SESSION['idsucursal'];
	}

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
    echo "<div class='body-row'>";
      echo "<div class='cell'>";

				if($_SESSION['nivel']==1 or $_SESSION['nivel']==2 or $_SESSION['nivel']==3 or $_SESSION['nivel']==4){
					if($key->estatus=="Pendiente"){
		        echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_agenda/editar' dix='contenido' tp='edit' v_idcita='$key->idcita' title='editar'>Editar</button>";
					}
				}

        echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_agenda/lista' dix='trabajo' db='a_agenda/db_' fun='cita_quitar' v_idcita='$key->idcita' tp='¿Desea cancelar la cita seleccionada?' title='Borrar'>Cancelar</button>";
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
				if($key->estatus=="Pendiente"){
					if($_SESSION['nivel']==1 or $_SESSION['nivel']==3 or $_SESSION['nivel']==4){
						echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_agenda/aprobar' dix='contenido' tp='edit' v_idcita='$key->idcita' title='editar'>Aprobar</button>";
					}
					else{
						echo $key->estatus;
					}
				}
				else{
					echo $key->estatus;
				}

      echo "</div>";
    echo "</div>";
  }

	if(strlen($texto)==0 and (strlen($idusuario)==0 and strlen($fecha_cita)==0 and strlen($idsucursal)==0)){

		echo "<div class='footer-row'>";
			$sql="SELECT count(idcita) as total FROM citas";
			$sth = $db->dbh->query($sql);
			$contar=$sth->fetch(PDO::FETCH_OBJ);
			$paginas=ceil($contar->total/$_SESSION['pagina']);
			$pagx=$paginas-1;

			echo $db->paginar($paginas,$pag,$pagx,"a_agenda/resultado","resultado_sql");

		echo "</div>";
	}
?>
