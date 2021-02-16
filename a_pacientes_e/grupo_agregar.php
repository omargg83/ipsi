<?php
	require_once("../a_pacientes/db_.php");
	$idterapia="";
		
	$idpaciente=$_REQUEST['idpaciente'];


	$tipo="";
	if(isset($_REQUEST['idtrack'])){
		$tipo="track";
		$idtrack=$_REQUEST['idtrack'];
	}
	if(isset($_REQUEST['idmodulo'])){
		$tipo="modulo";
		$idmodulo=$_REQUEST['idmodulo'];

		$sql="select * from modulo where id=$idmodulo";
		$sth = $db->dbh->query($sql);
		$modulo=$sth->fetch(PDO::FETCH_OBJ);

		$idtrack=$modulo->idtrack;
	}

	/////////////////////breadcrumb
	$paciente = $db->cliente_editar($idpaciente);
	$nombre=$paciente->nombre." ".$paciente->apellidop." ".$paciente->apellidom;

	$sql="select * from track where id=$idtrack";
	$sth = $db->dbh->query($sql);
	$track=$sth->fetch(PDO::FETCH_OBJ);

	$sql="select * from terapias where id=$track->idterapia";
	$sth = $db->dbh->query($sql);
	$terapia=$sth->fetch(PDO::FETCH_OBJ);




  echo "<nav aria-label='breadcrumb'>";
   echo "<ol class='breadcrumb'>";
  	 echo "<li class='breadcrumb-item' id='lista_track' is='li-link' des='a_pacientes/lista' dix='trabajo'>Pacientes</li>";
  	 echo "<li class='breadcrumb-item' id='lista_track' is='li-link' des='a_pacientes/paciente' v_idpaciente='$idpaciente' dix='trabajo'>$nombre</li>";
  	 echo "<li class='breadcrumb-item' id='lista_track' is='li-link' des='a_pacientes/terapias' v_idpaciente='$idpaciente' dix='trabajo'>Terapias</li>";
  	 echo "<li class='breadcrumb-item' id='lista_track' is='li-link' des='a_pacientes/track' dix='trabajo' v_idterapia='$terapia->id' v_idpaciente='$idpaciente'>$terapia->nombre</li>";
  	 echo "<li class='breadcrumb-item active' id='lista_track' is='li-link' des='a_pacientes/modulos' dix='trabajo' v_idtrack='$idtrack' v_idpaciente='$idpaciente'>$track->nombre</li>";

     echo "<li class='breadcrumb-item active' id='lista_track' is='li-link' des='a_pacientes_e/grupo_agregar' dix='trabajo' v_idtrack='$idtrack' v_idpaciente='$idpaciente'>Agregar grupo</li>";

  	 echo "<button class='btn btn-warning btn-sm ' type='button' is='b-link' des='a_pacientes/modulos' dix='trabajo' v_idtrack='$idtrack' v_idpaciente='$idpaciente'>Regresar</button>";
   echo "</ol>";
  echo "</nav>";

  echo "<div class='alert alert-danger text-center' role='alert'>";
    echo "Agregar Grupo";
  echo "</div>";
  
  	if ($tipo=="track")
  	$sql="select * from grupo_actividad  where grupo_actividad.idtrack=$idtrack order by grupo_actividad.orden asc";

	if ($tipo=="modulo")
	$sql="select * from grupo_actividad  where grupo_actividad.idmodulo=$idmodulo order by grupo_actividad.orden asc";
	
	echo $sql;
  	$sth = $db->dbh->query($sql);
  	$grupos=$sth->fetchAll(PDO::FETCH_OBJ);
  	echo "<div class='container'>";
  		echo "<div class='row'>";
  		foreach($grupos as $key){
  			echo "<div class='col-4 p-2 w-50 actcard'>";
  				echo "<div class='card' style='height:400px'>";
  					echo "<div class='card-header'>";
  						echo "<div class='row'>";
  							echo "<div class='col-12'>";
  								echo $key->grupo;
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
  								echo "<button class='btn btn-warning btn-block' type='button' is='b-link' db='a_pacientes/db_' tp='¿Desea agregar el grupo?'fun='agregar_grupo' des='a_pacientes/modulos' dix='trabajo' v_idgrupo='$key->idgrupo' v_idpaciente='$idpaciente' v_idtrack='$idtrack'>Agregar</button>";
  							echo "</div>";
  						echo "</div>";
  					echo "</div>";
  				echo "</div>";
  			echo "</div>";
  		}

  			echo "<div id='' class='col-4 p-3 w-50'>";
  				echo "<div class='card' style='height:200px;'>";
  					echo "<div class='card-body text-center'>";
  						echo "<button class='btn btn-warning btn-block' type='button' is='b-link' des='a_pacientes_e/grupo_editar' dix='trabajo' v_idgrupo='0' v_idtrack='$idtrack' v_idpaciente='$idpaciente'>Nuevo grupo</button>";
  					echo "</div>";
  				echo "</div>";
  			echo "</div>";
  		echo "</div>";
  	echo "</div>";

  ?>
