<?php
	require_once("db_.php");
	$idmodulo=$_REQUEST['idmodulo'];
	$idpaciente=$_REQUEST['idpaciente'];

/////////////////////breadcrumb
	$paciente = $db->cliente_editar($idpaciente);
	$nombre=$paciente->nombre." ".$paciente->apellidop." ".$paciente->apellidom;

	$sql="select * from modulo where id=$idmodulo";
	$sth = $db->dbh->query($sql);
	$modulo=$sth->fetch(PDO::FETCH_OBJ);

	$sql="select * from track where id=$modulo->idtrack";
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
		echo "<li class='breadcrumb-item active' id='lista_track' is='li-link' des='a_pacientes/modulos' dix='trabajo' v_idtrack='$modulo->idtrack' v_idpaciente='$idpaciente'>$track->nombre</li>";
		echo "<li class='breadcrumb-item active' id='lista_track' is='li-link' des='a_pacientes/actividades' dix='trabajo' v_idmodulo='$modulo->id' v_idpaciente='$idpaciente'>$modulo->nombre</li>";

		echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_pacientes/modulos' dix='trabajo' v_idterapia='$terapia->id' v_idpaciente='$idpaciente' v_idtrack='$modulo->idtrack'>Regresar</button>";
	echo "</ol>";
	echo "</nav>";


	echo "<div class='alert alert-warning text-center tituloventana' role='alert'>";
		echo "Grupos";
	echo "</div>";


	$sql="select * from grupo_actividad
	left outer join grupo_actividad_pre on grupo_actividad_pre.idgrupo=grupo_actividad.idgrupo
	where grupo_actividad.idmodulo=$modulo->id and grupo_actividad_pre.idpaciente=$idpaciente order by grupo_actividad.orden asc";

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
						echo "<div class='row'>";
							echo "<div class='col-12'>";

								echo "<button class='btn btn-warning btn-sm float-right' type='button' is='b-link' des='a_pacientes/actividades' dix='trabajo' db='a_pacientes/db_' fun='borrar_grupo' v_idmodulo='$key->idmodulo' v_idgrupo='$key->idgrupo' v_idpaciente='$idpaciente' v_idper='$key->idper' tp='¿Desea eliminar el grupo seleccionado?' tt='Ya no podrá deshacer el cambio' title='Borrar'><i class='far fa-trash-alt'></i></button>";

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
								echo "<button class='btn btn-warning btn-block' type='button' is='b-link' des='a_pacientes/grupos' dix='trabajo' v_idgrupo='$key->idgrupo' v_idpaciente='$idpaciente'>Ver</button>";
							echo "</div>";
						echo "</div>";
					echo "</div>";
				echo "</div>";
			echo "</div>";
		}
			echo "<div id='' class='col-4 p-3 w-50'>";
				echo "<div class='card' style='height:200px;'>";
					echo "<div class='card-body text-center'>";
						echo "<button class='btn btn-warning btn-block' type='button' is='b-link' des='a_pacientes_e/grupo_agregar' dix='trabajo' v_idgrupo='0' v_idmodulo='$idmodulo' v_idpaciente='$idpaciente'>Agregar grupo</button>";
					echo "</div>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
	echo "</div>";

?>
