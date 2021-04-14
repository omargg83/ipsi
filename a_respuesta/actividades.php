<?php
	require_once("db_.php");
	$idmodulo=$_REQUEST['idmodulo'];
	$idpaciente=$_SESSION['idusuario'];

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

  ///////////////////////CODIGO


	echo "<nav aria-label='breadcrumb'>";
	 echo "<ol class='breadcrumb'>";
		 echo "<li class='breadcrumb-item' id='lista_track' is='li-link' des='a_respuesta/terapias'  dix='contenido'>Terapias</li>";
		 echo "<li class='breadcrumb-item' id='lista_track' is='li-link' des='a_respuesta/track' dix='contenido' v_idterapia='$terapia->id' >$terapia->nombre</li>";
		 echo "<li class='breadcrumb-item' id='lista_track' is='li-link' des='a_respuesta/modulos' dix='contenido' v_idtrack='$track->id' >$track->nombre</li>";
		 echo "<li class='breadcrumb-item active' id='lista_track' is='li-link' des='a_respuesta/actividades' dix='contenido' v_idmodulo='$idmodulo' >$modulo->nombre</li>";
		 echo "<button class='btn btn-warning btn-sm float-right' type='button' is='b-link' des='a_respuesta/modulos' dix='contenido' v_idtrack='$track->id'>Regresar</button>";
	 echo "</ol>";
	echo "</nav>";

	echo "<div class='alert alert-warning text-center tituloventana' role='alert'>";
		echo "Grupos";
	echo "</div>";

		$sql="select * from grupo_actividad
		left outer join grupo_actividad_pre on grupo_actividad_pre.idgrupo=grupo_actividad.idgrupo
		where grupo_actividad.idmodulo=$idmodulo and grupo_actividad_pre.idpaciente=$idpaciente order by grupo_actividad.orden asc";

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
									echo "<button class='btn btn-warning btn-block' type='button' is='b-link' des='a_respuesta/grupos' dix='contenido' v_idgrupo='$key->idgrupo'>Ver</button>";
								echo "</div>";
							echo "</div>";
						echo "</div>";
					echo "</div>";
				echo "</div>";
			}

		echo "</div>";
	echo "</div>";

?>
