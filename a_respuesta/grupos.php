<?php
	require_once("db_.php");
	$idgrupo=$_REQUEST['idgrupo'];
	$idpaciente=$_SESSION['idusuario'];

	$visible="-1";
	if(isset($_REQUEST['visible'])){
		$visible=$_REQUEST['visible'];
	}

	$paciente = $db->cliente_editar($idpaciente);
	$nombre=$paciente->nombre." ".$paciente->apellidop." ".$paciente->apellidom;

	$tipo="";
	$sql="SELECT * from grupo_actividad where idgrupo=$idgrupo";
	$sth = $db->dbh->query($sql);
	$grupo=$sth->fetch(PDO::FETCH_OBJ);
	if(strlen($grupo->idtrack)){
		$tipo="track";
		$idtrack=$grupo->idtrack;
	}
	else{
		$tipo="modulo";
		$sql="select * from modulo where id=$grupo->idmodulo";
		$sth = $db->dbh->query($sql);
		$modulo=$sth->fetch(PDO::FETCH_OBJ);

		$idtrack=$modulo->idtrack;
	}

	$sql="select * from track where id=$idtrack";
	$sth = $db->dbh->query($sql);
	$track=$sth->fetch(PDO::FETCH_OBJ);
	$inicial=$track->inicial;

	$sql="select * from terapias where id=$track->idterapia";
	$sth = $db->dbh->query($sql);
	$terapia=$sth->fetch(PDO::FETCH_OBJ);


	echo "<nav aria-label='breadcrumb'>";
	 echo "<ol class='breadcrumb'>";
		 echo "<li class='breadcrumb-item' id='lista_track' is='li-link' des='a_respuesta/terapias' dix='contenido'>Terapias</li>";
		 echo "<li class='breadcrumb-item' id='lista_track' is='li-link' des='a_respuesta/track' dix='contenido' v_idterapia='$terapia->id'>$terapia->nombre</li>";
		  echo "<li class='breadcrumb-item active' id='lista_track' is='li-link' des='a_respuesta/modulos' dix='contenido' v_idtrack='$idtrack'>$track->nombre</li>";

		if($tipo=="modulo"){
			echo "<li class='breadcrumb-item active' id='lista_track' is='li-link' des='a_respuesta/actividades' dix='contenido' v_idmodulo='$modulo->id'>$modulo->nombre</li>";
		}


		 echo "<li class='breadcrumb-item active' is='li-link' des='a_respuesta/grupos' dix='contenido' title='Grupo' v_idgrupo='$idgrupo'>$grupo->grupo</li>";

		 if($tipo=="track"){
			  echo "<button class='btn btn-warning btn-sm ' type='button' is='b-link' des='a_respuesta/modulos' dix='contenido' v_idterapia='$terapia->id'  v_idtrack='$grupo->idtrack' >Regresar</button>";
		 }

		 if($tipo=="modulo"){
			echo "<button class='btn btn-warning btn-sm ' type='button' is='b-link' des='a_respuesta/actividades' dix='contenido' v_idterapia='$terapia->id'  v_idmodulo='$grupo->idmodulo'  >Regresar</button>";
		 }


	 echo "</ol>";
	echo "</nav>";


	echo "<div class='alert alert-warning text-center tituloventana' role='alert'>";
	  echo "Actividad";
	echo "</div>";

  //////////////////////CODIGO
  $sql="SELECT * from actividad_per
  left outer join actividad on actividad.idactividad=actividad_per.idactividad where actividad_per.idpaciente=$idpaciente and actividad.idgrupo=$idgrupo order by actividad.orden asc ";
  $sth = $db->dbh->query($sql);
  $orden=0;
  foreach($sth->fetchAll(PDO::FETCH_OBJ) as $key){
    $arreglo =array();
    $arreglo+=array('orden'=>$orden);
    $x=$db->update('actividad',array('idactividad'=>$key->idactividad), $arreglo);
    $orden++;
  }

  $sql="SELECT * from actividad_per left outer join actividad on actividad.idactividad=actividad_per.idactividad where actividad_per.idpaciente=$idpaciente and actividad.idgrupo=$idgrupo";
  if($visible>=0)
  $sql.=" and actividad.visible=$visible";

$sql.=" order by actividad.orden asc ";
  $sth = $db->dbh->query($sql);
  $acinicial=$sth->fetchAll(PDO::FETCH_OBJ);

	echo "<div class='container'>";
		echo "<div class='row'>";

		  foreach($acinicial as $key){
		    echo "<div class='col-4 p-2 w-50 actcard'>";
		      echo "<div class='card' style='height:400px'>";
		        echo "<img style='vertical-align: bottom;border-radius: 10px;max-width: 70px;margin: 0 auto;padding: 10px;' src='img/lapiz.png'>";
		        echo "<div class='card-header'>";

	            echo "<div class='row'>";
	              echo "<div class='col-12'>";
	                echo $key->nombre;
	              echo "</div>";
	            echo "</div>";

		        echo "</div>";
		        echo "<div class='card-body' style='overflow:auto; height:220px'>";
		          echo "<div class='row'>";
		            echo "<div class='col-12'>";
		              echo $key->observaciones;
		            echo "</div>";
		          echo "</div>";
		        echo "</div>";
		        echo "<div class='card-body'>";
		          echo "<div class='row'>";
		            echo "<div class='col-12'>";
		              echo "<button class='btn btn-warning btn-block' type='button' is='b-link' des='a_respuesta/actividad_ver' dix='contenido' v_idactividad='$key->idactividad' v_proviene='moduloscatalogo'>Ver actividad</button>";
		            echo "</div>";
		          echo "</div>";
		        echo "</div>";
		      echo "</div>";
		    echo "</div>";
		  }


	echo "</div>";
echo "</div>";


?>
