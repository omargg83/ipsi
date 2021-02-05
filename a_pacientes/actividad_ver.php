<?php
	require_once("db_.php");

	$idactividad=$_REQUEST['idactividad'];
	$idpaciente=$_REQUEST['idpaciente'];

	/////////////////////breadcrumb
	$paciente = $db->cliente_editar($idpaciente);
	$nombre=$paciente->nombre." ".$paciente->apellidop." ".$paciente->apellidom;
	$gtotal=0;
	$sql="select * from actividad where idactividad=:idactividad";
	$sth = $db->dbh->prepare($sql);
	$sth->bindValue(":idactividad",$idactividad);
	$sth->execute();
	$actividad=$sth->fetch(PDO::FETCH_OBJ);

	$inicial=0;
	if($actividad->idtrack){
		$inicial=1;
		$idtrack=$actividad->idtrack;
	}
	else{
		$sql="select * from modulo where id=:idmodulo";
		$sth = $db->dbh->prepare($sql);
		$sth->bindValue(":idmodulo",$actividad->idmodulo);
		$sth->execute();
		$modulo=$sth->fetch(PDO::FETCH_OBJ);
		$idtrack=$modulo->idtrack;
	}
	$sql="select * from track where id=:idtrack";
	$sth = $db->dbh->prepare($sql);
	$sth->bindValue(":idtrack",$idtrack);
	$sth->execute();
	$track=$sth->fetch(PDO::FETCH_OBJ);
	$idterapia=$track->idterapia;

	$sql="select * from terapias where id=:idterapia";
	$sth = $db->dbh->prepare($sql);
	$sth->bindValue(":idterapia",$idterapia);
	$sth->execute();
	$terapia=$sth->fetch(PDO::FETCH_OBJ);

	$nombre_act=$actividad->nombre;
	$observaciones=$actividad->observaciones;
	$indicaciones=$actividad->indicaciones;
	$anotaciones=$actividad->anotaciones;

	$subactividad = $db->subactividad_ver($idactividad);
?>

<nav aria-label='breadcrumb'>
 <ol class='breadcrumb'>
	 <li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/lista" dix="trabajo">Pacientes</li>
	 <li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/paciente" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo"><?php echo $nombre; ?></li>
	 <li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/terapias" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo">Terapias</li>
	 <li class="breadcrumb-item" id='lista_track' is="li-link" des="a_pacientes/track" dix="trabajo" v_idterapia="<?php echo $terapia->id; ?>" v_idpaciente="<?php echo $idpaciente; ?>"><?php echo $terapia->nombre; ?></li>
	 <li class="breadcrumb-item" id='lista_track' is="li-link" des="a_pacientes/modulos" dix="trabajo" v_idtrack="<?php echo $track->id; ?>" v_idpaciente="<?php echo $idpaciente; ?>"><?php echo $track->nombre; ?></li>
	 <?php
	 if($inicial==0){
		 ?>
		 <li class="breadcrumb-item" id='lista_track' is="li-link" des="a_pacientes/actividades" dix="trabajo" v_idmodulo="<?php echo $modulo->id; ?>" v_idpaciente="<?php echo $idpaciente; ?>"><?php echo $modulo->nombre; ?></li>
		<?php
	 }
	 ?>
	 <li class="breadcrumb-item active" id='lista_track' is="li-link" des="a_pacientes/actividad_ver" dix="trabajo" v_idactividad="<?php echo $idactividad; ?>" v_idpaciente="<?php echo $idpaciente; ?>"><?php echo $nombre_act; ?></li>

	 <?php
	 if($inicial==0){
	 ?>
	 <button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_pacientes/actividades" dix="trabajo" v_idmodulo="<?php echo $modulo->id; ?>" v_idpaciente="<?php echo $idpaciente; ?>">Regresar</button>
	 <?php
	 }
	 else{
	 ?>
		 <button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_pacientes/modulos" dix="trabajo" v_idtrack="<?php echo $track->id; ?>" v_idpaciente="<?php echo $idpaciente; ?>">Regresar</button>
	 <?php
	 }
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
					<button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_pacientes_e/actividad_editar" dix="trabajo"
					v_idactividad="<?php echo $idactividad; ?>" v_idpaciente="<?php echo $idpaciente; ?>" v_idtrack="<?php echo $idtrack; ?>"><i class="fas fa-pencil-alt"></i></button>

					<button class="btn btn-warning btn-sm" type="button" is="b-link" db="a_actividades/db_" fun="publicar_actividad" v_idactividad="<?php echo $idactividad; ?>" tp="¿Desea publicar la actividad en el catalogo?" title="Catalogo"><i class='fas fa-cloud-upload-alt'></i></button>

					<?php
						if($actividad->tipo=="evaluacion"){
							echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades_e/escala2' v_idactividad='$idactividad' v_idpaciente='$idpaciente' omodal='1' v_idescala='0'><i class='fas fa-file-medical-alt'></i></button>";
						}
					?>
					<button class="btn btn-warning btn-sm" type="button" is="b-link" db="a_actividades/db_" fun="publicar_actividad" v_idactividad="<?php echo $idactividad; ?>" tp="¿Desea publicar la actividad en el catalogo?" title="Catalogo"><i class="fas fa-user-friends"></i></button>

				</div>
				<div class="col-10 text-center">
						Actividad: <?php echo $nombre_act; ?> 	(<?php echo $actividad->tipo; ?>)
					<?php
						$sql="SELECT count(contexto.id) as total from contexto
						left outer join subactividad on subactividad.idsubactividad=contexto.idsubactividad
						where subactividad.idactividad=:id and (contexto.tipo='pregunta' or contexto.tipo='textores'  or contexto.tipo='textocorto' or contexto.tipo='fecha'  or contexto.tipo='archivores')";
						$contx = $db->dbh->prepare($sql);
						$contx->bindValue(":id",$idactividad);
						$contx->execute();
						$bloques=$contx->fetch(PDO::FETCH_OBJ);

						$sql="SELECT count(contexto_resp.id) as total FROM	contexto
						right OUTER JOIN contexto_resp ON contexto_resp.idcontexto=contexto.id
						left outer join subactividad on subactividad.idsubactividad=contexto.idsubactividad
						where subactividad.idactividad=:id
						group by contexto.id";
						$contx = $db->dbh->prepare($sql);
						$contx->bindValue(":id",$idactividad);
						$contx->execute();
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
		</div>
	</div>
<?php
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
							echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades_e/subactividad_editar' v_idsubactividad='$key->idsubactividad' v_idactividad='$idactividad' v_idpaciente='$idpaciente' omodal='1'><i class='fas fa-pencil-alt'></i></button>";

							echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_pacientes/actividad_ver' dix='trabajo' db='a_actividades/db_' fun='subactividad_duplicar' v_idactividad='$idactividad' v_idsubactividad='$key->idsubactividad' v_idpaciente='$idpaciente' tp='¿Desea duplicar la subactividad?' title='Duplicar'><i class='far fa-clone'></i></button>";

							echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_pacientes/actividad_ver' dix='trabajo' db='a_actividades/db_' fun='subactividad_borrar' v_idactividad='$idactividad' v_idsubactividad='$key->idsubactividad' v_idpaciente='$idpaciente' tp='¿Desea eliminar la subactividad?' tt='Ya no podrá deshacer el cambio' title='Borrar'><i class='far fa-trash-alt'></i></button>";

							if($actividad->tipo=="evaluacion"){
								echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades_e/escala' v_idactividad='$idactividad' v_idpaciente='$idpaciente' omodal='1' v_idescala='0' v_idsubactividad='$key->idsubactividad'><i class='fas fa-chart-line'></i></button>";
							}


						echo "</div>";
						echo "<div class='col-9 text-center'>";
							echo $key->orden." - ".$key->nombre;

							echo "<br>";
							if($actividad->tipo=="evaluacion"){
								$total=0;

								$sql="SELECT count(contexto.id) as total from contexto where idsubactividad = $key->idsubactividad and (contexto.tipo='pregunta' or contexto.tipo='textores'  or contexto.tipo='textocorto' or contexto.tipo='fecha'  or contexto.tipo='archivores')";
								$contx = $db->dbh->prepare($sql);
								$contx->execute();
								$bloques=$contx->fetch(PDO::FETCH_OBJ);

								$sql="SELECT count(contexto_resp.id) as total FROM	contexto right OUTER JOIN contexto_resp ON contexto_resp.idcontexto=contexto.id WHERE	idsubactividad = :id	group by contexto.id";
								$contx = $db->dbh->prepare($sql);
								$contx->bindValue(':id',$key->idsubactividad);
								$contx->execute();
								if($contx->rowCount()>0 and $bloques->total>0){
									$total=(100*$contx->rowCount())/$bloques->total;
								}

								echo "<div id='progreso_$key->idsubactividad'>";
									echo "(".$contx->rowCount()."/".$bloques->total.")<br>";
									echo "<progress id='file' value='$total' max='100'> $total %</progress>";
								echo "</div>";
							}
						echo "</div>";
					echo "</div>";
				echo "</div>";
			echo "</div>";

			/////////////////contexto
				$bloq=$db->contexto_ver($key->idsubactividad);
				foreach($bloq as $row){
					/////////////////esta en control_db.php
					echo "<div id='con_$row->id'>";
						$db->contexto_pacientes($row->id, $idactividad, $idpaciente);
					echo "</div>";

					$sql="select sum(valor) as total from contexto_resp where idcontexto='$row->id'";
					$suma_r = $db->dbh->prepare($sql);
					$suma_r->execute();
					if($suma_r->rowCount()>0){
						$resp_r=$suma_r->fetch(PDO::FETCH_OBJ);
						$suma+=$resp_r->total;
					}
				}
				echo "<div class='container-fluid mb-5 mt-5 text-center'>";
					echo "<button class='btn btn-warning btn-sm mb-3' type='button' is='b-link' des='a_actividades_e/bloque' v_idactividad='$idactividad' v_idsubactividad='$key->idsubactividad' v_idpaciente='$idpaciente' v_tipo='$actividad->tipo' omodal='1' >Nuevo bloque de contexto</button>";
				echo "</div>";

			echo "<div >";

			if($actividad->tipo=="evaluacion"){
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
				echo "<br>Resultados:";
				$gtotal+=$suma;
				echo "<br>Suma de respuestas: ".$suma;
				echo "<br>Resultado: ".$texto_resp;
				echo "<hr>";
			}
			echo "</div>";
	}

	echo "<div class='card'>";
	echo "Suma total:".$gtotal;
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

	 				$sth = $db->dbh->prepare($sql);
	 				$sth->execute();
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
						$xsth = $db->dbh->prepare($sql);
						$xsth->execute();
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
 					$sth = $db->dbh->prepare($sql);
 					$sth->execute();
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

 ?>
	<div class="container-fluid mb-5 mt-5 text-center">
		<button class='btn btn-warning btn-sm' type="button" is="b-link" des='a_actividades_e/subactividad_editar' v_idsubactividad="0" v_idactividad="<?php echo $idactividad; ?>" v_idpaciente='<?php echo $idpaciente; ?>' title='editar' omodal="1">Nueva Subactividad</button>
	</div>
</div>
