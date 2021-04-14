<?php
	require_once("db_.php");
	$idtrack=$_REQUEST['idtrack'];
	$idpaciente=$_SESSION['idusuario'];

	/////////////////////breadcrumb
	$paciente = $db->cliente_editar($idpaciente);
	$nombre=$paciente->nombre." ".$paciente->apellidop." ".$paciente->apellidom;

	$sql="select * from track where id=$idtrack";
	$sth = $db->dbh->query($sql);
	$track=$sth->fetch(PDO::FETCH_OBJ);

	$sql="select * from terapias where id=$track->idterapia";
	$sth = $db->dbh->query($sql);
	$terapia=$sth->fetch(PDO::FETCH_OBJ);

	$continuar=1;
	if($track->inicial!=1){
		///////////////////////para evaluar
		$sql="select * from track where idterapia=$terapia->id and inicial=1";
		$track_c = $db->dbh->prepare($sql);
		$track_c->execute();
		$bloquef=0;
		$contarf=0;

		foreach($track_c->fetchAll(PDO::FETCH_OBJ) as $key){
			$sql="SELECT count(contexto.id) as total from contexto
			left outer join subactividad on subactividad.idsubactividad=contexto.idsubactividad
			left outer join actividad on actividad.idactividad=subactividad.idactividad
			where  actividad.idtrack=".$key->id." and actividad.idpaciente=".$_SESSION['idusuario']." and (contexto.tipo='pregunta' or contexto.tipo='textores'  or contexto.tipo='textocorto' or contexto.tipo='fecha' or contexto.tipo='archivores') and actividad.visible=1";

			$contx = $db->dbh->prepare($sql);
			$contx->execute();
			$bloques=$contx->fetch(PDO::FETCH_OBJ);
			$bloquef+=$bloques->total;
			/////////////////

			$sql="SELECT count(contexto_resp.id) as total FROM	contexto
			right OUTER JOIN contexto_resp ON contexto_resp.idcontexto=contexto.id
			left outer join subactividad on subactividad.idsubactividad=contexto.idsubactividad
			left outer join actividad on actividad.idactividad=subactividad.idactividad
			where actividad.idtrack=".$key->id." and actividad.idpaciente=".$_SESSION['idusuario']." and actividad.visible=1 group by contexto.id";
			$respx = $db->dbh->prepare($sql);
			$respx->execute();
			$respx->fetch(PDO::FETCH_OBJ);
			$contarf+=$respx->rowCount();
		}
		$continuar=1;
		$total=0;
		if($contarf>0 and $contarf>0){
			$total=(100*$contarf)/$bloquef;
		}
		if($total!=100){
			$continuar=0;
		}
		if($bloquef==0){
			$continuar=1;
		}
	}


	if($continuar==0){
		echo "Faltan actividades iniciales por concluir";
		return 0;
	}
?>

<nav aria-label='breadcrumb'>
 <ol class='breadcrumb'>
	 <li class='breadcrumb-item' id='lista_track' is="li-link" des="a_respuesta/terapias"  dix="contenido">Terapias</li>
	 <li class="breadcrumb-item" id='lista_track' is="li-link" des="a_respuesta/track" dix="contenido" v_idterapia="<?php echo $terapia->id; ?>" ><?php echo $terapia->nombre; ?></li>
	 <li class="breadcrumb-item active" id='lista_track' is="li-link" des="a_respuesta/modulos" dix="contenido" v_idtrack="<?php echo $idtrack; ?>" ><?php echo $track->nombre; ?></li>

	  <button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_respuesta/track" dix="contenido" v_idterapia="<?php echo $terapia->id; ?>">Regresar</button>
 </ol>
</nav>

<?php

	if($track->inicial==1){
		echo "<div class='alert alert-warning text-center tituloventana' role='alert'>";
		  echo "Grupos";
		echo "</div>";

		$sql="select * from grupo_actividad_pre left outer join grupo_actividad on grupo_actividad.idgrupo=grupo_actividad_pre.idgrupo where grupo_actividad.idtrack=$track->id and grupo_actividad_pre.idpaciente=$idpaciente order by grupo_actividad.orden asc";
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
									echo "<button class='btn btn-warning btn-block' type='button' is='b-link' des='a_respuesta/grupos' dix='contenido' v_idgrupo='$key->idgrupo' >Ver</button>";
								echo "</div>";
							echo "</div>";
						echo "</div>";
					echo "</div>";
				echo "</div>";
			}
			echo "</div>";
		echo "</div>";
	}
	else{
		echo "<div class='alert alert-warning text-center tituloventana' role='alert'>";
			echo "Mis Modulos";
		echo "</div>";

		echo "<div class='container'>";
		  echo "<div class='row'>";

			///////////////////////CODIGO
			$sql="SELECT * from modulo_per left outer join modulo on modulo.id=modulo_per.idmodulo where modulo_per.idpaciente=$idpaciente and modulo.idtrack=$idtrack";
			$sth = $db->dbh->query($sql);
			$modulos=$sth->fetchAll(PDO::FETCH_OBJ);
	  	foreach($modulos as $key){
	  		echo "<div class='col-4 p-3 w-50 actcard'>";
	  			echo "<div class='card'>";
						echo "<img style='vertical-align: bottom;border-radius: 10px;max-width: 70px;margin: 0 auto;padding: 10px;' src='img/lapiz.png'>";
						echo "<div class='card-header'>";
							echo $key->nombre;
						echo "</div>";
	  				echo "<div class='card-body'>";
	  					echo "<div class='row'>";
	  						echo "<div class='col-12'>";
	  							echo $key->descripcion;
	  						echo "</div>";
	  					echo "</div>";
	  				echo "</div>";
	  				echo "<div class='card-body'>";
	  					echo "<div class='row'>";
	  						echo "<div class='col-12'>";
	  							echo "<button class='btn btn-warning btn-block' type='button' is='b-link' des='a_respuesta/actividades' dix='contenido' v_idmodulo='$key->id'>Ver</button>";
	  						echo "</div>";
	  					echo "</div>";
	  				echo "</div>";
	  			echo "</div>";
	  		echo "</div>";
	  	}
			echo "</div>";
		echo "</div>";
	}

?>
