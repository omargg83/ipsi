<?php
	require_once("db_.php");
	$idgrupo=$_REQUEST['idgrupo'];
	$idpaciente=$_REQUEST['idpaciente'];

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

		$sql="select * from track where id=$grupo->idtrack";
		$sth = $db->dbh->query($sql);
		$track=$sth->fetch(PDO::FETCH_OBJ);
		$inicial=$track->inicial;

		$sql="select * from terapias where id=$track->idterapia";
		$sth = $db->dbh->query($sql);
		$terapia=$sth->fetch(PDO::FETCH_OBJ);
	}
	else{
		$tipo="modulos";
	}


	echo "<nav aria-label='breadcrumb'>";
	 echo "<ol class='breadcrumb'>";
		 echo "<li class='breadcrumb-item' id='lista_track' is='li-link' des='a_pacientes/lista' dix='trabajo'>Pacientes</li>";
		 echo "<li class='breadcrumb-item' id='lista_track' is='li-link' des='a_pacientes/paciente' v_idpaciente='$idpaciente' dix='trabajo'>$nombre</li>";
		 echo "<li class='breadcrumb-item' id='lista_track' is='li-link' des='a_pacientes/terapias' v_idpaciente='$idpaciente' dix='trabajo'>Terapias</li>";
		 echo "<li class='breadcrumb-item' id='lista_track' is='li-link' des='a_pacientes/track' dix='trabajo' v_idterapia='$terapia->id' v_idpaciente='$idpaciente'>$terapia->nombre</li>";

		 if($tipo=="track"){
			  echo "<li class='breadcrumb-item active' id='lista_track' is='li-link' des='a_pacientes/modulos' dix='trabajo' v_idtrack='$grupo->idtrack' v_idpaciente='$idpaciente' >$track->nombre</li>";
		 }

		 echo "<li class='breadcrumb-item active' is='li-link' des='a_pacientes/grupos' dix='trabajo' title='Grupo' v_idgrupo='$idgrupo' v_idpaciente='$idpaciente'>$grupo->grupo</li>";

		 if($tipo=="track"){
			  echo "<button class='btn btn-warning btn-sm ' type='button' is='b-link' des='a_pacientes/modulos' dix='trabajo' v_idterapia='$terapia->id'  v_idtrack='$grupo->idtrack' v_idpaciente='$idpaciente' >Regresar</button>";
		 }


	 echo "</ol>";
	echo "</nav>";

	echo "$tipo";


	echo "<div class='alert alert-warning text-center tituloventana' role='alert'>";
	  echo "Actividad inicial";
	echo "</div>";


	echo "<div class='container' id='filtro'>";
		echo "<form id='filtro_form' des='a_pacientes/grupos'>";
		echo "<input type='hidden' name='idgrupo' id='idgrupo' value='$grupo->idgrupo'>";
			echo "<input type='hidden' name='idpaciente' id='idpaciente' value='$idpaciente'>";
				echo "<div class='row justify-content-end'>";
					echo "<div class='col-2'>";
						echo "<select name='visible' id='visible' class='form-control form-control-sm filter_x' >";
							echo "<option value='-1' "; if($visible=="-1"){ echo "selected"; } echo ">Todas</option>";
							echo "<option value='1' "; if($visible==1){ echo "selected"; } echo ">Visibles</option>";
							echo "<option value='0' "; if($visible==0){ echo "selected"; } echo ">Ocultas</option>";
						echo "</select>";
				echo "</div>";
		echo "</form>";
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
		            echo "<div class='row justify-content-end'>";
		              echo "<div class='col-12'>";

					
		                echo "<button class='btn btn-warning btn-sm float-right' type='button' is='b-link' db='a_pacientes/db_' fun='actividad_mover' des='a_pacientes/grupos' v_idactividad='$key->idactividad' v_idpaciente='$idpaciente' v_idgrupo='$idgrupo' v_dir='1' dix='trabajo' title='Abajo'><i class='fas fa-chevron-down'></i></button>";

		                echo "<button class='btn btn-warning btn-sm float-right' type='button' is='b-link' db='a_pacientes/db_' fun='actividad_mover' des='a_pacientes/grupos' v_idactividad='$key->idactividad' v_idpaciente='$idpaciente' v_idgrupo='$idgrupo' v_dir='0' dix='trabajo' title='Arriba'><i class='fas fa-chevron-up'></i></button>";

		                echo "<button class='btn btn-warning btn-sm float-right' type='button' is='b-link' des='a_pacientes/grupos' dix='trabajo' db='a_pacientes/db_' fun='quitar_actividad' v_idactividad='$key->idactividad' v_idpaciente='$idpaciente' v_idgrupo='$idgrupo' tp='¿Desea eliminar la actividad seleccionada?' tt='Ya no se podrá deshacer' title='Borrar'><i class='far fa-trash-alt'></i></button>";

		                echo "<button class='btn btn-warning btn-sm float-right' type='button' is='b-link' db='a_actividades/db_' fun='actividad_duplicar' v_idactividad='$key->idactividad' v_idpaciente='$idpaciente' v_idgrupo='$idgrupo' des='a_pacientes/grupos' tp='¿Desea duplicar la actividad seleccionada?' title='Duplicar' dix='trabajo'><i class='far fa-clone'></i></button>";

		                echo "<button class='btn btn-warning btn-sm float-right' type='button' is='b-link' des='a_pacientes_e/actividad_editar' dix='trabajo' v_idactividad='$key->idactividad' v_idpaciente='$idpaciente' v_idgrupo='$idgrupo' v_proviene='moduloscatalogo'><i class='fas fa-pencil-alt'></i></button>";
					

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
		              echo "<button class='btn btn-warning btn-block' type='button' is='b-link' des='a_pacientes/actividad_ver' dix='trabajo' v_idactividad='$key->idactividad' v_idpaciente='$idpaciente' v_proviene='moduloscatalogo'>Ver inicial</button>";
		            echo "</div>";
		          echo "</div>";
		        echo "</div>";
		      echo "</div>";
		    echo "</div>";
		  }

		echo "<div id='' class='col-4 p-3 w-50'>";
		  echo "<div class='card' style='height:200px;'>";
		    echo "<div class='card-body text-center'>";
		      echo "<button class='btn btn-warning btn-block' type='button' is='b-link' des='a_pacientes_e/inicial_agregar' dix='trabajo' v_idgrupo='$idgrupo' v_idpaciente='$idpaciente'>Agregar Actividad</button>";
		    echo "</div>";
		  echo "</div>";
		echo "</div>";

	echo "</div>";
echo "</div>";


?>
