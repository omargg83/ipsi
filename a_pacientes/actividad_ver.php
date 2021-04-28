	<?php
	require_once("db_.php");

	$idactividad=$_REQUEST['idactividad'];
	$idpaciente=$_REQUEST['idpaciente'];
	if(isset($_REQUEST['pagina'])){
		$pagina=$_REQUEST['pagina'];
	}
	else{
		$pagina=0;
	}

	///////paginas
	$sql="SELECT contexto.pagina FROM contexto
	left outer join subactividad on subactividad.idsubactividad=contexto.idsubactividad
	left outer join actividad on actividad.idactividad=subactividad.idactividad
	where actividad.idactividad=$idactividad group by pagina";
	$sth = $db->dbh->query($sql);
	$no_paginas=$sth->rowCount();

	/////////////////ordenar subactividad
	$sql="SELECT * from subactividad where subactividad.idactividad=$idactividad order by subactividad.orden asc, subactividad.nombre asc";
	$sth = $db->dbh->query($sql);
	$respx=$sth->fetchAll(PDO::FETCH_OBJ);

	$orden=0;
	foreach($respx as $row){
		$arreglo =array();
		$arreglo+=array('orden'=>$orden);
		$x=$db->update('subactividad',array('idsubactividad'=>$row->idsubactividad), $arreglo);
		$orden++;
	}

	/////////////////////////////////////orden contexto
	$sql="SELECT contexto.* FROM contexto
	left outer join subactividad on subactividad.idsubactividad=contexto.idsubactividad
	left outer join actividad on actividad.idactividad=subactividad.idactividad
	where actividad.idactividad=$idactividad order by subactividad.orden asc, contexto.orden asc";
	$sth = $db->dbh->query($sql);
	$respx=$sth->fetchAll(PDO::FETCH_OBJ);
	$orden=0;
	$idsubx=0;
	foreach($respx as $row){
		if($idsubx!=$row->idsubactividad){
			$orden=0;
			$idsubx=$row->idsubactividad;
		}
		$arreglo =array();
		$arreglo+=array('orden'=>$orden);
		$x=$db->update('contexto',array('id'=>$row->id), $arreglo);
		$orden++;
	}

	/////////////////////breadcrumb
	$paciente = $db->cliente_editar($idpaciente);
	$nombre=$paciente->nombre." ".$paciente->apellidop." ".$paciente->apellidom;


	$gtotal=0;

	$sql="select * from actividad where idactividad=$idactividad";
	$sth = $db->dbh->query($sql);
	$actividad=$sth->fetch(PDO::FETCH_OBJ);
	$nombre_act=$actividad->nombre;
	$observaciones=$actividad->observaciones;
	$indicaciones=$actividad->indicaciones;
	$anotaciones=$actividad->anotaciones;

	$sql="select * from grupo_actividad where idgrupo=$actividad->idgrupo";
	$sth = $db->dbh->query($sql);
	$grupo=$sth->fetch(PDO::FETCH_OBJ);

	$inicial=0;

	if($grupo->idtrack){
		$inicial=1;
		$idtrack=$grupo->idtrack;
	}
	else{
		$sql="select * from modulo where id=$grupo->idmodulo";
		$sth = $db->dbh->query($sql);
		$modulo=$sth->fetch(PDO::FETCH_OBJ);
		$idtrack=$modulo->idtrack;
	}

	/////////////track
	$sql="select * from track where id=$idtrack";
	$sth = $db->dbh->query($sql);
	$track=$sth->fetch(PDO::FETCH_OBJ);
	$idterapia=$track->idterapia;

	///////////terapias
	$sql="select * from terapias where id=$idterapia";
	$sth = $db->dbh->query($sql);
	$terapia=$sth->fetch(PDO::FETCH_OBJ);

	/////////////////subactividades
	$sql="(SELECT subactividad.* FROM contexto
		left outer join subactividad on subactividad.idsubactividad=contexto.idsubactividad
		where subactividad.idactividad=$idactividad and contexto.pagina=$pagina group by idsubactividad order by subactividad.orden asc)";
		if($pagina==($no_paginas-1) or $pagina==$no_paginas){
			$sql.="UNION (
			SELECT subactividad.* FROM subactividad
			left outer join contexto on subactividad.idsubactividad=contexto.idsubactividad
			where subactividad.idactividad=$idactividad and contexto.id is null order by subactividad.orden asc
			) order by orden asc";
		}
		$sth = $db->dbh->query($sql);
		$subactividad=$sth->fetchAll(PDO::FETCH_OBJ);
?>

<nav aria-label='breadcrumb'>
 <ol class='breadcrumb'>
	 <li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/lista" dix="trabajo">Pacientes</li>
	 <li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/paciente" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo"><?php echo $nombre; ?></li>
	 <li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/terapias" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo">Terapias</li>
	 <li class="breadcrumb-item" id='lista_track' is="li-link" des="a_pacientes/track" dix="trabajo" v_idterapia="<?php echo $terapia->id; ?>" v_idpaciente="<?php echo $idpaciente; ?>"><?php echo $terapia->nombre; ?></li>
	 <li class="breadcrumb-item" id='lista_track' is="li-link" des="a_pacientes/modulos" dix="trabajo" v_idtrack="<?php echo $track->id; ?>" v_idpaciente="<?php echo $idpaciente; ?>"><?php echo $track->nombre; ?></li>
	<?php

	 echo "<li class='breadcrumb-item' is='li-link' des='a_pacientes/grupos' dix='trabajo' v_idgrupo='$grupo->idgrupo' v_idpaciente='$idpaciente'>$grupo->grupo</li>";


	if($inicial==0){
		echo "<li class='breadcrumb-item' id='lista_track' is='li-link' des='a_pacientes/grupos' dix='trabajo' v_idgrupo='$actividad->idgrupo' v_idpaciente='$idpaciente'>$modulo->nombre</li>";
	}

	echo "<li class='breadcrumb-item active' id='lista_track' is='li-link' des='a_pacientes/actividad_ver' dix='trabajo' v_idactividad='$idactividad' v_idpaciente='$idpaciente'>$nombre_act</li>";


	echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_pacientes/grupos' dix='trabajo' v_idgrupo='$actividad->idgrupo' v_idpaciente='$idpaciente'>Regresar </button>";

	 ?>
 </ol>
</nav>

<!-- actividad  -->
<div class="container">
<div class="card mb-3">
		<div class="card-header" id="headingOne">
			<div class='row'>
				<div class="col-2">

					<!---Editar actividad --->
					<?php
						if($inicial==0){
							echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_pacientes_e/actividad_editar' dix='trabajo'
							v_idactividad='$idactividad' v_idpaciente='$idpaciente'  v_proviene='actividadver'><i class='fas fa-pencil-alt'></i></button>";
						}
						else{
							echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_pacientes_e/actividad_editar' dix='trabajo'
							v_idactividad='$idactividad' v_idpaciente='$idpaciente'  v_proviene='actividadver'><i class='fas fa-pencil-alt'></i></button>";
						}
					?>

					<button class="btn btn-warning btn-sm" type="button" is="b-link" db="a_actividades/db_" fun="publicar_actividad" v_idactividad="<?php echo $idactividad; ?>" tp="¿Desea publicar la actividad en el catalogo?" title="Catalogo"><i class='fas fa-cloud-upload-alt'></i></button>

					<?php
						if($actividad->tipo=="evaluacion"){
							echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades_e/escala2' v_idactividad='$idactividad' v_idpaciente='$idpaciente' omodal='1' v_idescala='0'><i class='fas fa-file-medical-alt'></i></button>";
						}

						echo "<button class='btn btn-warning btn-sm' type='button' is='b-link'  v_idactividad='$idactividad' v_idpaciente='$idpaciente' title='Familiar' des='a_pacientes/roles' omodal='1'><i class='fas fa-user-friends'></i></button>";
					?>
				</div>
				<div class="col-10 text-center">
						Actividad: <?php echo $nombre_act; ?> 	(<?php echo $actividad->tipo; ?>)
					<?php
						$sql="SELECT count(contexto.id) as total from contexto
						left outer join subactividad on subactividad.idsubactividad=contexto.idsubactividad
						where subactividad.idactividad=$idactividad and (contexto.tipo='pregunta' or contexto.tipo='textores'  or contexto.tipo='textocorto' or contexto.tipo='fecha'  or contexto.tipo='archivores')";
						$contx = $db->dbh->query($sql);
						$bloques=$contx->fetch(PDO::FETCH_OBJ);

						$sql="SELECT count(contexto_resp.id) as total FROM	contexto
						right OUTER JOIN contexto_resp ON contexto_resp.idcontexto=contexto.id
						left outer join subactividad on subactividad.idsubactividad=contexto.idsubactividad
						where subactividad.idactividad=$idactividad group by contexto.id";
						$contx = $db->dbh->query($sql);
						$total=0;
						if($contx->rowCount()){
							$total=(100*$contx->rowCount())/$bloques->total;
						}
						echo "<div id='prog_$idactividad'>";
							echo "(".$contx->rowCount()."/".$bloques->total.")<br>";
							echo "<progress id='file' value='$total' max='100'> $total %</progress>";
						echo "</div>";
					?>
				</div>
			</div>
		</div>

		<div class='card-body'>
			<p>Indicaciones</p>
			<?php echo $indicaciones; ?>
		</div>
		<div class='card-body mb-3'>
				<button class='btn btn-warning btn-sm' type="button" is="b-link" des='a_pacientes_e/anotaciones_editar' v_idactividad="<?php echo $idactividad; ?>" v_idpaciente='<?php echo $idpaciente; ?>' title='editar' omodal="1">Anotaciones</button>
				<div class="mb-3">
					<p>Anotaciones -Solo visible al terapéuta-</p>
					<?php echo $anotaciones; ?>
				</div>

				<?php
					$sql="SELECT * FROM actividad_per left outer join usuarios on usuarios.idusuario where idactividad=$idactividad";
					$sth = $db->dbh->query($sql);
					$asignado=$sth->fetch(PDO::FETCH_OBJ);

					echo "<div class='mb-3'>";
						echo "<p><b>Asignado por</b></p>";
						echo $asignado->nombre." ".$asignado->apellidop." ".$asignado->apellidop;
					echo "</div>";				
				?>

				
		</div>
	</div>

<?php

		$sql="select actividad_per.*,clientes.nombre, clientes.apellidop, clientes.apellidom from actividad_per left outer join clientes on clientes.id=actividad_per.idpaciente where idactividad='$idactividad' order by actividad_per.id asc";
		$permis = $db->dbh->query($sql);
		if($permis->rowCount()>1){
			echo "<div class='card mb-1 ml-3'>";
				$orden=0;
				echo "<table class='table table-sm'>";
				foreach($permis->fetchAll(PDO::FETCH_OBJ) as $key){
					echo "<tr>";
					echo "<td>";
						if($orden!=0){
							echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_pacientes/actividad_ver' dix='trabajo' db='a_pacientes/db_' fun='eliminar_pareja' v_idactividad='$idactividad' v_idpaciente='$idpaciente' v_idper='$key->id' tp='¿Desea eliminar la relación?' tt='Ya no podrá deshacer el cambio' title='Borrar'><i class='far fa-trash-alt'></i></button>";
						}
					echo "</td>";
					echo "<td>";
					echo "$key->nombre $key->apellidop $key->apellidom";
					echo "</td>";
					echo "</tr>";
					$orden++;
				}
				echo "</table>";
			echo "</div>";
		}
	/////////<!-- Fin de actividad  -->

	/////////<!-- Subactividades  -->
	$suma=0;
	$posicion=0;
	foreach($subactividad as $key){
		$posicion++;
		$suma=0;
		echo "<div class='card mb-1 ml-3'>";
			echo "<div class='card-header' style='background-color:#f9eec1;'>";
				echo "<div class='row'>";
					echo "<div class='col-3'>";
						/////////////////////////////////////////////<!-- Editar subactividad --->
						echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades_e/subactividad_editar' v_idsubactividad='$key->idsubactividad' v_idactividad='$idactividad' v_idpaciente='$idpaciente' omodal='1' ><i class='fas fa-pencil-alt'></i></button>";

						echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_pacientes/actividad_ver' dix='trabajo' db='a_actividades/db_' fun='subactividad_duplicar' v_idactividad='$idactividad' v_idsubactividad='$key->idsubactividad' v_idpaciente='$idpaciente' tp='¿Desea duplicar la subactividad?' title='Duplicar'><i class='far fa-clone'></i></button>";

						echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_pacientes/actividad_ver' dix='trabajo' db='a_actividades/db_' fun='subactividad_borrar' v_idactividad='$idactividad' v_idsubactividad='$key->idsubactividad' v_idpaciente='$idpaciente' tp='¿Desea eliminar la subactividad?' tt='Ya no podrá deshacer el cambio' title='Borrar'><i class='far fa-trash-alt'></i></button>";

						if($actividad->tipo=="evaluacion"){
							echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades_e/escala' v_idactividad='$idactividad' v_idpaciente='$idpaciente' omodal='1' v_idescala='0' v_idsubactividad='$key->idsubactividad'><i class='fas fa-chart-line'></i></button>";
						}

						echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' db='a_pacientes/db_' fun='subactividad_mover' v_dir='0' des='a_pacientes/actividad_ver' v_idactividad='$idactividad' v_idsubactividad='$key->idsubactividad' v_idpaciente='$idpaciente' dix='trabajo'><i class='fas fa-sort-up'></i></button>";

						echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' db='a_pacientes/db_' fun='subactividad_mover' v_dir='1' des='a_pacientes/actividad_ver' v_idactividad='$idactividad' v_idsubactividad='$key->idsubactividad' v_idpaciente='$idpaciente' dix='trabajo'><i class='fas fa-sort-down'></i></button>";

					echo "</div>";
					echo "<div class='col-7'>";
						echo $key->nombre;
					echo "</div>";
					//if($actividad->tipo=="evaluacion"){
						$total=0;
						$sql="SELECT count(contexto.id) as total from contexto where idsubactividad = $key->idsubactividad and (contexto.tipo='pregunta' or contexto.tipo='textores'  or contexto.tipo='textocorto' or contexto.tipo='fecha'  or contexto.tipo='archivores')";
						$contx = $db->dbh->query($sql);
						$bloques=$contx->fetch(PDO::FETCH_OBJ);

						$sql="SELECT count(contexto_resp.id) as total FROM	contexto right OUTER JOIN contexto_resp ON contexto_resp.idcontexto=contexto.id WHERE idsubactividad = $key->idsubactividad group by contexto.id";
						$contx = $db->dbh->query($sql);
						if($contx->rowCount()>0 and $bloques->total>0){
							$total=(100*$contx->rowCount())/$bloques->total;
						}
						echo "<div class='col-2' id='progreso_$key->idsubactividad'>";
							echo "".$contx->rowCount()."/".$bloques->total."";
							echo "<progress id='file' value='$total' max='100'> $total %</progress>";
						echo "</div>";
					//}
				echo "</div>";
			echo "</div>";
		echo "</div>";
		echo "<div id='subactividad_$key->idsubactividad'>";
			/////////////////contexto
			$sql="select * from contexto where idsubactividad=$key->idsubactividad and pagina=$pagina order by orden asc";
			$sth = $db->dbh->query($sql);
			$bloq=$sth->fetchAll(PDO::FETCH_OBJ);
			foreach($bloq as $row){
				/////////////////esta en control_db.php
				echo "<div id='con_$row->id'>";
					$db->contexto_pacientes($row->id, $idactividad, $idpaciente);
				echo "</div>";
			}
		echo "</div>";
		echo "<div class='container-fluid mb-5 mt-5 text-center'>";
			echo "<button class='btn btn-warning btn-sm mb-3' type='button' is='b-link' des='a_actividades_e/bloque' v_idactividad='$idactividad' v_idsubactividad='$key->idsubactividad' v_idpaciente='$idpaciente' v_tipo='$actividad->tipo' omodal='1' >Nuevo bloque de contexto</button>";
		echo "</div>";

		if($actividad->tipo=="evaluacion"){
			$sql="select * from contexto where idsubactividad=$key->idsubactividad order by orden asc";
			$sth = $db->dbh->query($sql);
			$bloq=$sth->fetchAll(PDO::FETCH_OBJ);
			foreach($bloq as $row){
				$sql="select sum(valor) as total from contexto_resp where idcontexto='$row->id'";
				$suma_r = $db->dbh->prepare($sql);
				$suma_r->execute();
				if($suma_r->rowCount()>0){
					$resp_r=$suma_r->fetch(PDO::FETCH_OBJ);
					$suma+=$resp_r->total;
				}
			}

			$sql="select * from escala_sub where idsubactividad='$key->idsubactividad'";
			$escala = $db->dbh->query($sql);
			$texto_resp="";
			if($escala->rowCount()>0){
				echo "<div class='container-fluid mb-5'>";
					echo "<div class='card'>";
						echo "<div class='card-body'>";
							echo "Escala:".$key->nombre;;
							echo "<table class='table table-sm'>";
							echo "<tr><td>-</td><td>Descripcion</td><td>Minimo</td><td>Maximo</td></tr>";
							foreach($escala->fetchAll(PDO::FETCH_OBJ) as $exca){
								echo "<tr>";
									echo "<td>";
										echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades_e/escala' v_idactividad='$idactividad' v_idpaciente='$idpaciente' omodal='1' v_idescala='$exca->id' v_idsubactividad='$key->idsubactividad' >
										Editar</button>";

										echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_pacientes/actividad_ver' dix='trabajo' db='a_actividades/db_' fun='borrar_escala' v_idescala='$exca->id' v_idactividad='$idactividad' v_idsubactividad='$key->idsubactividad' v_idpaciente='$idpaciente' tp='¿Desea eliminar la escala?' tt='Ya no podrá deshacer el cambio' title='Borrar'>Borrar</button>";

									echo "</td>";
									echo "<td>";
										echo $exca->descripcion;
									echo "</td>";
									echo "<td>";
										echo $exca->minimo;
									echo "</td>";
									echo "<td>";
										echo $exca->maximo;
									echo "</td>";
								echo "</tr>";
								if($suma>=$exca->minimo and $suma<=$exca->maximo){
									$texto_resp=$exca->descripcion;
								}
							}
							echo "</table>";
						echo "</div>";
					echo "</div>";
				echo "</div>";
			}
			echo "<br><b>Resultados</b>";
			$gtotal+=$suma;
			echo "<br>Suma de respuestas: ".$suma;
			echo "<br>Resultado: ".$texto_resp;
			echo "<hr>";
		}
	}

	echo "<div class='card'>";
	echo "Suma total:".$gtotal;
	echo "</div>";

	echo "<div class='container-fluid mb-5 mt-5 text-center'>";
		echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades_e/subactividad_editar' v_idsubactividad='0' v_idactividad='$idactividad' v_idpaciente='$idpaciente' title='editar' omodal='1'>Nueva Subactividad</button>";
	echo "</div>";

	//////////////////escalas
	$sql="select * from escala_actividad where idactividad=$idactividad";
 	$sth = $db->dbh->prepare($sql);
 	$sth->execute();
 	if($sth->rowCount()){
 		$v1=$sth->fetchAll(PDO::FETCH_OBJ);
 		foreach($v1 as $escala){
			$gparcial=0;
			$reexp="";
 			echo "<div class='card'>";
 				echo "<div class='card-header'>";

				echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades_e/escala2' v_idactividad='$idactividad' v_idpaciente='$idpaciente' omodal='1' v_idescala='$escala->id'><i class='fas fa-file-medical-alt'></i></button>";

				echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_pacientes/actividad_ver' dix='trabajo' db='a_actividades/db_' fun='borrar_escalaactitivdad' v_idactividad='$idactividad' v_idsubactividad='$key->idsubactividad' v_idpaciente='$idpaciente' tp='¿Desea eliminar la variable?' tt='Ya no podrá deshacer el cambio' v_id='$escala->id' title='Borrar'><i class='far fa-trash-alt'></i></button>";
 					echo "Escala:".$escala->nombre;
 				echo "</div>";
				echo "<div class='card-body'>";

	 				$sql="SELECT escala_contexto.*, contexto.id AS idcontex, contexto.texto FROM escala_contexto LEFT OUTER JOIN contexto ON contexto.id = escala_contexto.idcontexto WHERE escala_contexto.idescala='$escala->id'";
	 				$sth = $db->dbh->query($sql);
	 				$es=$sth->fetchAll(PDO::FETCH_OBJ);
	 				echo "<table class='table tabe-sm'>";
	 				echo "<tr><th>-</th><th>Descripcion</th></tr>";
	 				foreach($es as $v2){
	 					echo "<tr>";

	 					echo "<td>";
	 					echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades_e/contexto_escala' v_id='$v2->id' v_idescala='$escala->id' v_idactividad='$idactividad' v_idpaciente='$idpaciente' omodal='1' ><i class='fas fa-list-ul'></i></button>";

						echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_pacientes/actividad_ver' dix='trabajo' db='a_actividades/db_' fun='borrar_escalacont' v_idactividad='$idactividad' v_idsubactividad='$key->idsubactividad' v_idpaciente='$idpaciente' tp='¿Desea eliminar la variable?' tt='Ya no podrá deshacer el cambio' v_id='$v2->id' title='Borrar'><i class='far fa-trash-alt'></i></button>";
	 					echo "</td>";

	 					echo "<td>";
	 					echo $v2->texto;

						$sql="select sum(valor) as total from contexto_resp where idcontexto='$v2->idcontex'";
						$xsth = $db->dbh->query($sql);
						if($xsth->rowCount()){
							$tabparc=$xsth->fetch(PDO::FETCH_OBJ);
							if(is_numeric($tabparc->total)){
								$gparcial+=$tabparc->total;
							}
						}
	 					echo "</td>";
	 					echo "</tr>";
	 				}
	 				echo "</table>";
 				echo "</div>";

 				echo "<div class='card-body'>";
 					$sql="select * from escala_act where idescala=$escala->id";
 					$sth = $db->dbh->query($sql);
 					$es=$sth->fetchAll(PDO::FETCH_OBJ);
 					echo "<table class='table tabe-sm'>";
 					echo "<tr><th>Descripcion</th><th>Minimo</th><th>Maximo</th></tr>";
 					foreach($es as $v2){
 						echo "<tr>";

 						echo "<td>";
 						echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades_e/escala3' v_id='$v2->id' v_idescala='$escala->id' v_idactividad='$idactividad' v_idpaciente='$idpaciente' omodal='1' v_idescala='0'><i class='fas fa-file-medical-alt'></i></button>";

						echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_pacientes/actividad_ver' dix='trabajo' db='a_actividades/db_' fun='borrar_escalaact' v_idactividad='$idactividad' v_idsubactividad='$key->idsubactividad' v_idpaciente='$idpaciente' tp='¿Desea eliminar la escala?' tt='Ya no podrá deshacer el cambio' v_id='$v2->id' title='Borrar'><i class='far fa-trash-alt'></i></button>";

 						echo "</td>";
 						echo "<td>";

 						echo $v2->descripcion;
 						echo "</td>";
 						echo "<td>";
 						echo $v2->minimo;
 						echo "</td>";
 						echo "<td>";
 						echo $v2->maximo;
 						echo "</td>";
 						echo "</tr>";
						if($v2->minimo<=$gparcial and $gparcial<=$v2->maximo){
							$reexp=$v2->descripcion;
						}
 					}
 					echo "</table>";
 				echo "</div>";

 				echo "<div class='card-body'>";
 					echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades_e/escala3' v_id='0' v_idescala='$escala->id' v_idactividad='$idactividad' v_idpaciente='$idpaciente' omodal='1' ><i class='fas fa-file-medical-alt'></i></button>";

 					echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades_e/contexto_escala' v_id='0' v_idescala='$escala->id' v_idactividad='$idactividad' v_idpaciente='$idpaciente' omodal='1' ><i class='fas fa-list-ul'></i></button>";
 				echo "</div>";

				echo "<div class='card-body'>";
					echo "Suma:$gparcial";
					echo "<br>Resultado:$reexp";
 				echo "</div>";
 			echo "</div>";
 		}
 	}
echo "</div>";

	//////////////////////////////paginacion
	$variables['idactividad']=$idactividad;
	$variables['idpaciente']=$idpaciente;
	echo $db->paginar_x($no_paginas,$pagina,"a_pacientes/actividad_ver","trabajo",$variables);
?>
