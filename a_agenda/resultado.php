<?php
	require_once("db_.php");
	$nombresDias = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado" );

	$texto="";
	if(isset($_REQUEST['pagina'])){
		$pagina=$_REQUEST['pagina'];
	}
	else{
		$pagina=0;
	}

	isset($_REQUEST['idsucursal']) ? $idsucursal=$_REQUEST['idsucursal'] : $idsucursal="";
	isset($_REQUEST['idusuario']) ? $idusuario=$_REQUEST['idusuario'] : $idusuario="";
	isset($_REQUEST['fechacita']) ? $fechacita=$_REQUEST['fechacita'] : $fechacita="";
	isset($_REQUEST['idpaciente']) ? $idpaciente=$_REQUEST['idpaciente'] : $idpaciente="";
	isset($_REQUEST['orden']) ? $orden=$_REQUEST['orden'] : $orden="idcita";
	isset($_REQUEST['asc']) ? $asc=$_REQUEST['asc'] : $asc="";


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
		$pd = $db->agenda_lista($pagina,$idsucursal,$idusuario,$fechacita,$idpaciente,$orden,$asc);
	}

  echo "<div class='header-row'>";
    echo "<div class='cell'>#</div>";

    echo "<div class='cell'><a is='b-link' des='a_agenda/resultado' dix='resultado_sql' v_idsucursal='$idsucursal' v_idusuario='$idusuario' v_fechacita='$fechacita' $idpaciente='$idpaciente'"; if($orden=="idcita" and $asc=="desc") echo "v_asc='asc'"; else echo "v_asc='desc'"; echo "v_orden='idcita'>"; if($orden=="idcita"){ if($asc=="desc") echo "<i class='fas fa-arrow-down'></i>"; else echo "<i class='fas fa-arrow-up'></i>";} echo "#ID</a></div>";

    echo "<div class='cell'><a is='b-link' des='a_agenda/resultado' dix='resultado_sql' v_idsucursal='$idsucursal' v_idusuario='$idusuario' v_fechacita='$fechacita' $idpaciente='$idpaciente'"; if($orden=="idsucursal" and $asc=="desc") echo "v_asc='asc'"; else echo "v_asc='desc'"; echo "v_orden='idsucursal'>"; if($orden=="idsucursal"){ if($asc=="desc") echo "<i class='fas fa-arrow-down'></i>"; else echo "<i class='fas fa-arrow-up'></i>";} echo "Sucursal</a></div>";

    echo "<div class='cell'><a is='b-link' des='a_agenda/resultado' dix='resultado_sql' v_idsucursal='$idsucursal' v_idusuario='$idusuario' v_fechacita='$fechacita' $idpaciente='$idpaciente'"; if($orden=="idpaciente" and $asc=="desc") echo "v_asc='asc'"; else echo "v_asc='desc'"; echo "v_orden='idpaciente'>"; if($orden=="idpaciente"){ if($asc=="desc") echo "<i class='fas fa-arrow-down'></i>"; else echo "<i class='fas fa-arrow-up'></i>";} echo "Paciente</a></div>";

	echo "<div class='cell'><a is='b-link' des='a_agenda/resultado' dix='resultado_sql' v_idsucursal='$idsucursal' v_idusuario='$idusuario' v_fechacita='$fechacita' $idpaciente='$idpaciente'"; if($orden=="fecha" and $asc=="desc") echo "v_asc='asc'"; else echo "v_asc='desc'"; echo "v_orden='fecha'>"; if($orden=="fecha"){ if($asc=="desc") echo "<i class='fas fa-arrow-down'></i>"; else echo "<i class='fas fa-arrow-up'></i>";} echo "Fecha</a></div>";

    echo "<div class='cell'><a is='b-link' des='a_agenda/resultado' dix='resultado_sql' v_idsucursal='$idsucursal' v_idusuario='$idusuario' v_fechacita='$fechacita' $idpaciente='$idpaciente'"; if($orden=="desde" and $asc=="desc") echo "v_asc='asc'"; else echo "v_asc='desc'"; echo "v_orden='desde'>"; if($orden=="desde"){ if($asc=="desc") echo "<i class='fas fa-arrow-down'></i>"; else echo "<i class='fas fa-arrow-up'></i>";} echo "Hora</a></div>";

    echo "<div class='cell'><a is='b-link' des='a_agenda/resultado' dix='resultado_sql' v_idsucursal='$idsucursal' v_idusuario='$idusuario' v_fechacita='$fechacita' $idpaciente='$idpaciente'"; if($orden=="dia" and $asc=="desc") echo "v_asc='asc'"; else echo "v_asc='desc'"; echo " v_orden='dia'>"; if($orden=="dia"){ if($asc=="desc") echo "<i class='fas fa-arrow-down'></i>"; else echo "<i class='fas fa-arrow-up'></i>";} 
    echo "Dia</a></div>";

	echo "<div class='cell'><a is='b-link' des='a_agenda/resultado' dix='resultado_sql' v_idsucursal='$idsucursal' v_idusuario='$idusuario' v_fechacita='$fechacita' $idpaciente='$idpaciente'"; if($orden=="idterapeuta" and $asc=="desc") echo "v_asc='asc'"; else echo "v_asc='desc'"; echo " v_orden='idterapeuta'>"; if($orden=="idterapeuta"){ if($asc=="desc") echo "<i class='fas fa-arrow-down'></i>"; else echo "<i class='fas fa-arrow-up'></i>";} echo "Terapeuta</a></div>";


	echo "<div class='cell'><a is='b-link' des='a_agenda/resultado' dix='resultado_sql' v_idsucursal='$idsucursal' v_idusuario='$idusuario' v_fechacita='$fechacita' $idpaciente='$idpaciente'"; if($orden=="consultorio" and $asc=="desc") echo "v_asc='asc'"; else echo "v_asc='desc'"; echo " v_orden='consultorio'>"; if($orden=="consultorio"){ if($asc=="desc") echo "<i class='fas fa-arrow-down'></i>"; else echo "<i class='fas fa-arrow-up'></i>";} echo "Consultorio</a></div>";

    echo "<div class='cell'><a is='b-link' des='a_agenda/resultado' dix='resultado_sql' v_idsucursal='$idsucursal' v_idusuario='$idusuario' v_fechacita='$fechacita' $idpaciente='$idpaciente'"; if($orden=="estatus" and $asc=="desc") echo "v_asc='asc'"; else echo "v_asc='desc'"; echo " v_orden='estatus'>"; if($orden=="estatus"){ if($asc=="desc") echo "<i class='fas fa-arrow-down'></i>"; else echo "<i class='fas fa-arrow-up'></i>";} echo "Estatus</a></div>";

	echo "<div class='cell'><a is='b-link' des='a_agenda/resultado' dix='resultado_sql' v_idsucursal='$idsucursal' v_idusuario='$idusuario' v_fechacita='$fechacita' $idpaciente='$idpaciente'"; if($orden=="estatus_paciente" and $asc=="desc") echo "v_asc='asc'"; else echo "v_asc='desc'"; echo " v_orden='estatus_paciente'>"; if($orden=="estatus_paciente"){ if($asc=="desc") echo "<i class='fas fa-arrow-down'></i>"; else echo "<i class='fas fa-arrow-up'></i>";} echo "Estatus paciente</a></div>";

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
			if($diferencia<$_SESSION['horas_confirma'] and $diferencia>0 and strlen($key->estatus_paciente)==0){
				echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_agenda/lista' dix='trabajo' db='a_agenda/db_' fun='paciente_confirma' v_idcita='$key->idcita' tp='¿Desea confirmar la cita seleccionada?' title='Confirmar'>Confirmar</button>";				
			}
		}

		if($key->estatus!='Cancelada'){
			echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_agenda/lista' dix='trabajo' db='a_agenda/db_' fun='cita_quitar' v_idcita='$key->idcita' tp='¿Desea cancelar la cita seleccionada?' title='Borrar'>Cancelar</button>";
		}
		
        

		
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
			if(strlen($key->consultorio)>0 and $key->estatus=="Aprobada")
				echo $key->consultorio;
			else
				echo "Online";
		echo "</div>";

      	echo "<div class='cell' data-titulo='Status'>";
			echo $key->estatus;
      	echo "</div>";

		  echo "<div class='cell' data-titulo='Status'>";
			echo $key->estatus_paciente;
      	echo "</div>";
    echo "</div>";
  }

	if(strlen($texto)==0 and (strlen($idusuario)==0 and strlen($fechacita)==0 and strlen($idsucursal)==0)){

		echo "<div class='footer-row'>";
			$sql="SELECT count(idcita) as total FROM citas";
			$sth = $db->dbh->query($sql);
			$contar=$sth->fetch(PDO::FETCH_OBJ);
			$paginas=ceil($contar->total/$_SESSION['pagina']);
			$pagx=$paginas-1;

			$var=array();
			$var+=array("orden"=>$orden);
			$var+=array("asc"=>$asc);	

			echo $db->paginar_x($paginas,$pagina,"a_agenda/resultado","resultado_sql",$var);

		echo "</div>";
	}
?>


