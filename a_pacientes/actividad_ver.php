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
<div id="accordion">
	<div class="card mb-3">
		<div class="card-header" id="headingOne">
			<div class='row'>
				<div class="col-2">

					<!---Editar actividad --->
					<button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_pacientes_e/actividad_editar" dix="trabajo"
					v_idactividad="<?php echo $idactividad; ?>" v_idpaciente="<?php echo $idpaciente; ?>" v_idtrack="<?php echo $idtrack; ?>"><i class="fas fa-pencil-alt"></i></button>

					<button class="btn btn-warning btn-sm" type="button" is="b-link" db="a_actividades/db_" fun="publicar_actividad" v_idactividad="<?php echo $idactividad; ?>" tp="¿Desea publicar la actividad en el catalogo?" title="Duplicar"><i class="far fa-copy"></i></button>

					<?php
						if($actividad->tipo=="evaluacion"){
							echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades_e/escala2' v_idactividad='$idactividad' v_idpaciente='$idpaciente' omodal='1' v_idescala='0'><i class='fas fa-file-medical-alt'></i></button>";
						}
					?>

				</div>
				<div class="col-10 text-center">
					<button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
						Actividad: <?php echo $nombre_act; ?> 	(<?php echo $actividad->tipo; ?>)
					</button>
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

		<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
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
	</div>
</div>

<?php
	/////////<!-- Fin de actividad  -->
	/////////<!-- Subactividades  -->
	echo "<section class='containerx' id='subactividades'>";
	echo "<ul>";
			$suma=0;
			$posicion=0;
			foreach($subactividad as $key){
				$posicion++;
				$suma=0;
				echo "<div class='container-fluid mb-1' id='sub_".$key->idsubactividad."'>";
					echo "<div class='card' >";
						echo "<div class='card-header'>";
							echo "<div class='row'>";
								echo "<div class='col-2'>";
									/////////////////////////////////////////////<!-- Editar subactividad --->
									echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades_e/subactividad_editar' v_idsubactividad='$key->idsubactividad' v_idactividad='$idactividad' v_idpaciente='$idpaciente' omodal='1'><i class='fas fa-pencil-alt'></i></button>";

									echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_pacientes/actividad_ver' dix='trabajo' db='a_actividades/db_' fun='subactividad_borrar' v_idactividad='$idactividad' v_idsubactividad='$key->idsubactividad' v_idpaciente='$idpaciente' tp='¿Desea eliminar la subactividad?' title='Borrar'><i class='far fa-trash-alt'></i></button>";

									if($actividad->tipo=="evaluacion"){
										echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades_e/escala' v_idactividad='$idactividad' v_idpaciente='$idpaciente' omodal='1' v_idescala='0' v_idsubactividad='$key->idsubactividad'><i class='fas fa-chart-line'></i></button>";
									}
								echo "</div>";

								echo "<div class='col-10 text-center'>";
									echo "<button class='btn btn-link' data-toggle='collapse' data-target='#collapsesub_".$key->idsubactividad."' aria-expanded='true' aria-controls='collapsesub_".$key->idsubactividad."'>";
										echo $key->orden." - ".$key->nombre;
									echo "</button>";
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

						/////////////////contexto
						echo "<div id='collapsesub_".$key->idsubactividad."' class='collapse show' aria-labelledby='headingOne' data-parent='#accordion'>";
							echo "<div class='card-body' id='bloque'>";

								$bloq=$db->contexto_ver($key->idsubactividad);
								foreach($bloq as $row){



									echo "<div class='card mt-4' style='border:1px solid silver'>";
										echo "<div class='card-header'>";
											echo "<div class='row'>";
												echo "<div class='col-4'>";
													///////////////editar contexto
													echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades_e/contexto_editar' v_idcontexto='$row->id' v_idactividad='$idactividad' v_idpaciente='$idpaciente' omodal='1'><i class='fas fa-pencil-alt'></i></button>";

													///////////////editar incisos
													if($row->tipo=="pregunta"){
														echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades_e/incisos_lista' v_idcontexto='$row->id' v_idactividad='$idactividad' v_idpaciente='$idpaciente' omodal='1'><i class='fas fa-tasks'></i></button>";
													}

													////////////////copiar
													echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_pacientes/actividad_ver' dix='trabajo' db='a_actividades/db_' fun='contexto_duplicar' v_idactividad='$idactividad' v_idcontexto='$row->id' v_idpaciente='$idpaciente' tp='¿Desea duplicar el bloque?' title='Duplicar'><i class='far fa-copy'></i></button>";

													////////////////eliminar bloque
													echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_pacientes/actividad_ver' dix='trabajo' db='a_actividades/db_' fun='contexto_borrar' v_idactividad='$idactividad' v_idcontexto='$row->id' v_idpaciente='$idpaciente' tp='¿Desea eliminar el bloque selecionado?' title='Borrar'><i class='far fa-trash-alt'></i></button>";

													////////////////condiciones
													echo "<button "; if($row->idcond){ echo "class='btn btn-danger btn-sm' "; } else { echo "class='btn btn-warning btn-sm'"; } echo " type='button' is='b-link' des='a_actividades_e/condicional_editar' v_idactividad='$idactividad' v_idpaciente='$idpaciente' omodal='1' v_idcontexto='$row->id'><i class='fas fa-project-diagram'></i></button>";

												echo "</div>";
												echo "<div class='col-8'>";
													echo "<button class='btn btn-link' data-toggle='collapse' data-target='#collapsecon_".$row->id."' aria-expanded='true' aria-controls='collapsecon_".$row->id."'>";
														echo "Contexto ";
													echo "</button>";
												echo "</div>";
											echo "</div>";
										echo "</div>";

										echo "<div id='collapsecon_".$row->id." class='collapse show' aria-labelledby='headingOne' data-parent='#accordion'>";
											echo "<div class='card-body'>";

												echo "<form is='resp-submit' id='form_g_".$row->id."' db='a_respuesta/db_' fun='guarda_respuesta' v_idactividad='$idactividad' v_idpaciente='$idpaciente' v_idcontexto='$row->id'>";
													$db->contexto_carga($row->id, $actividad);
													
													/*
														echo "<div class='mb-3'>";
															echo $row->observaciones;
														echo "</div>";
														echo "<div class='mb-3'>";

															if($row->tipo=="imagen"){
																echo "<img src='".$db->doc.$row->texto."'/>";
															}
															else if($row->tipo=="texto"){
																echo $row->texto;
															}
															else if($row->tipo=="video"){
																echo $row->texto;
															}
															else if($row->tipo=="archivo"){
																echo "<a href='".$db->doc.$row->texto."' download='$row->texto'>Descargar</a>";
															}
															else if($row->tipo=="textores"){
																echo "<div id='div_$row->id' name='div_$row->id' onclick='editable(this)' style='width:100%; height: 200px; border:1px solid silver'>$texto</div>";
																echo "<small>De clic para editar</small>";

																//echo "<textarea class='texto' id='texto_$row->id' name='texto_$row->id' rows=5 placeholder=''>$texto</textarea>";
															}
															else if($row->tipo=="textocorto"){
																echo "<textarea class='form-control' id='texto_$row->id' name='texto_$row->id' rows=5 placeholder=''>$texto</textarea>";
															}
															else if($row->tipo=="fecha"){
																echo "<input type='date' name='texto' id='texto' value='$fecha' class='form-control'>";
															}
															else if($row->tipo=="archivores"){
																if(strlen($archivo)>0){
																	echo "<a href='".$db->resp.$archivo."' download='$archivo'>Ver</a>";
																}
																echo "<input type='file' name='archivo' id='archivo' class='form-control'>";
															}
															else if($row->tipo=="pregunta"){
																echo $row->texto;

																///////////<!-- Respuestas  -->
																echo "<div class='container-fluid'>";
																	$rx=$db->respuestas_ver($row->id);
																	foreach ($rx as $respuesta) {
																		$texto_resp="";
																		$valor_resp="";
																		$resp_idrespuesta="";

																		echo "<div class='row'>";

																			//////////////////para obtener Respuestas
																			$sql="select * from contexto_resp where idcontexto=:id and idrespuesta=:idrespuesta";
																			$contx = $db->dbh->prepare($sql);
																			$contx->bindValue(":id",$row->id);
																			$contx->bindValue(":idrespuesta",$respuesta->id);
																			$contx->execute();
																			$resp=$contx->fetch(PDO::FETCH_OBJ);
																			$correcta=0;
																			$texto_resp="";
																			if($contx->rowCount()>0){
																				$correcta=1;
																				$texto_resp=$resp->texto;
																				$valor_resp=$resp->valor;
																			}

																			echo "<div class='col-1'>";
																				if($row->incisos==1){
																					$idx="";
																					echo "<input type='checkbox' name='checkbox_".$respuesta->id."' value='$respuesta->id' ";
																					if($correcta){ echo " checked";}
																					echo ">";
																				}
																				else{
																					$idx=$row->id;
																					echo "<input type='radio' name='radio_".$idx."' value='$respuesta->id' ";
																						if($correcta){
																							echo " checked";
																						}
																					echo ">";
																				}
																			echo "</div>";

																			if(strlen($respuesta->imagen)>0){
																				echo "<div class='col-1'>";
																						echo "<img src=".$db->doc.$respuesta->imagen." alt='' width='20px'>";
																				echo "</div>";
																			}

																			echo "<div class='col-6'>";
																				echo $respuesta->nombre;
																			echo "</div>";

																			///////////////////////////////////aca el valor
																			if($actividad->tipo=="evaluacion"){
																				echo "<div class='col-1'>";
																					echo $respuesta->valor;
																				echo "</div>";
																			}

																			echo "<div class='col-3'>";
																				if($row->usuario==1){
																					echo "<input type='text' name='resp_".$respuesta->id."' id='resp_".$respuesta->id."' value='$texto_resp' placeholder='Define..' class='form-control form-control-sm'>";
																				}
																			echo "</div>";
																		echo "</div>";
																	}


																	if($row->personalizado==1){
																		$texto="";
																		$otro=0;

																		$sql="select * from contexto_resp where idcontexto=$row->id and valor='OTRO'";
																		$contx = $db->dbh->prepare($sql);
																		$contx->execute();
																		if($contx->rowCount()>0){
																			$resp=$contx->fetch(PDO::FETCH_OBJ);
																			$texto=$resp->texto;
																			$otro=1;
																		}

																		echo "<div class='row'>";
																			echo "<div class='col-3'>";
																			echo "</div>";
																			if($row->incisos==1){
																					echo "<div class='col-1'>";
																						echo "<input type='checkbox' name='checkbox_otro'";
																						if($otro==1){
																							echo " checked";
																						}
																						echo " value='otro'>";
																					echo "</div>";
																					echo "<div class='col-6'>";
																						echo "<input type='text' name='resp_otro' id='resp_otro' value='$texto' class='form-control form-control-sm' placeholder='Otro'>";
																					echo "</div>";
																				}
																				else{
																					echo "<div class='col-1'>";
																						echo "<input type='radio' name='radio_".$idx."' value='otro'";
																						if($otro==1){
																							echo " checked";
																						}
																						echo ">";
																					echo "</div>";
																					echo "<div class='col-6'>";
																						echo "<input type='text' name='resp_otro' id='per_".$row->id."' value='$texto' class='form-control form-control-sm' placeholder='otro'>";
																					echo "</div>";
																			}
																		echo "</div>";
																	}
																echo "</div>";

																echo "<div class='row mb-3'>";
																	echo "<div class='col-12'>";
																		echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades_e/inciso_editar' v_idrespuesta='0' v_idcontexto='$row->id' v_idactividad='$idactividad' v_idpaciente='$idpaciente' omodal='1' >Agregar inciso</button>";
																	echo "</div>";
																echo "</div>";
															}
														echo "</div>";
														//////////<!-- Fin Preguntas  -->
														if($row->tipo=="textocorto" or $row->tipo=="textores" or $row->tipo=="fecha" or $row->tipo=="archivores" or $row->tipo=="pregunta"){
															if(strlen($marca)==0){
																echo "<button class='btn btn-danger btn-sm' type='submit'><i class='far fa-check-circle'></i>Responder</button>";
															}
															else{
																echo "<button class='btn btn-warning btn-sm' type='submit'><i class='fas fa-check-double'></i>Actualizar respuesta</button>";
															}
														}
													*/
													//////////<!-- Fin Preguntas  -->
														echo "<div class='row mb-3'>";
															echo "<div class='col-12'>";
															if($row->tipo=="pregunta"){
																echo "<button class='btn btn-warning btn-sm mx-2' type='button' is='b-link' des='a_actividades_e/inciso_editar' v_idrespuesta='0' v_idcontexto='$row->id' v_idactividad='$idactividad' v_idpaciente='$idpaciente' omodal='1' ><i class='fas fa-plus mx-2'></i>Agregar inciso</button>";
															}

																if($row->tipo=="textocorto" or $row->tipo=="textores" or $row->tipo=="fecha" or $row->tipo=="archivores" or $row->tipo=="pregunta"){
																	//if(strlen($marca)==0){
																		//echo "<button class='btn btn-danger btn-sm' type='submit'><i class='far fa-check-circle'></i>Responder</button>";
																	//}
																	//else{
																		echo "<button class='btn btn-warning btn-sm mx-2' type='submit'><i class='far fa-save mx-2'></i>Responder</button>";
																	//}
																}
															echo "</div>";
														echo "</div>";

												echo "</form>";



											echo "</div>";
										echo "</div>";
									echo "</div>";

									//////////////para obtener el valor de lo respondido
									$sql="select sum(valor) as total from contexto_resp where idcontexto='$row->id'";
									$suma_r = $db->dbh->prepare($sql);
									$suma_r->execute();
									if($suma_r->rowCount()>0){
										$resp_r=$suma_r->fetch(PDO::FETCH_OBJ);
										$suma+=$resp_r->total;
									}
								}

								echo "<div class='container-fluid mb-3 text-center'>";
									echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades_e/bloque' v_idactividad='$idactividad' v_idsubactividad='$key->idsubactividad' v_idpaciente='$idpaciente' v_tipo='$actividad->tipo' omodal='1' >Nuevo bloque</button>";
								echo "</div>";
							echo "</div>";
							echo "<div class='card-body'>";
								if($actividad->tipo=="evaluacion"){
									$sql="select * from escala_sub where idsubactividad='$key->idsubactividad'";
									$escala = $db->dbh->prepare($sql);
									$escala->execute();
									$texto_resp="";
									if($escala->rowCount()>0){
										echo "Escala";
										echo "<table class='table'>";
										echo "<tr><td>-</td><td>Descripcion</td><td>Minimo</td><td>Maximo</td></tr>";
										foreach($escala->fetchAll(PDO::FETCH_OBJ) as $exca){
											echo "<tr>";
												echo "<td>";
													echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades_e/escala' v_idactividad='$idactividad' v_idpaciente='$idpaciente' omodal='1' v_idescala='$exca->id' v_idsubactividad='$key->idsubactividad' >
													Editar</button>";

													echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_pacientes/actividad_ver' dix='trabajo' db='a_actividades/db_' fun='borrar_escala' v_idescala='$exca->id' v_idactividad='$idactividad' v_idsubactividad='$key->idsubactividad' v_idpaciente='$idpaciente' tp='¿Desea eliminar la escala?' title='Borrar'>Borrar</button>";

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
									}
									echo "<br>Resultados:";
									$gtotal+=$suma;
									echo "<br>Suma de respuestas: ".$suma;
									echo "<br>Resultado: ".$texto_resp;
								}
							echo "</div>";
						echo "</div>";
					echo "</div>";
				echo "</div>";
		}
	echo "</ul>";
echo "</section>";


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

				echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_pacientes/actividad_ver' dix='trabajo' db='a_actividades/db_' fun='borrar_escalaactitivdad' v_idactividad='$idactividad' v_idsubactividad='$key->idsubactividad' v_idpaciente='$idpaciente' tp='¿Desea eliminar la variable?' v_id='$escala->id' title='Borrar'><i class='far fa-trash-alt'></i></button>";

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

						echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_pacientes/actividad_ver' dix='trabajo' db='a_actividades/db_' fun='borrar_escalacont' v_idactividad='$idactividad' v_idsubactividad='$key->idsubactividad' v_idpaciente='$idpaciente' tp='¿Desea eliminar la variable?' v_id='$v2->id' title='Borrar'><i class='far fa-trash-alt'></i></button>";
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

						echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_pacientes/actividad_ver' dix='trabajo' db='a_actividades/db_' fun='borrar_escalaact' v_idactividad='$idactividad' v_idsubactividad='$key->idsubactividad' v_idpaciente='$idpaciente' tp='¿Desea eliminar la escala?' v_id='$v2->id' title='Borrar'><i class='far fa-trash-alt'></i></button>";

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
	<div class="container-fluid mb-3 text-center">
		<button class='btn btn-warning btn-sm' type="button" is="b-link" des='a_actividades_e/subactividad_editar' v_idsubactividad="0" v_idactividad="<?php echo $idactividad; ?>" v_idpaciente='<?php echo $idpaciente; ?>' title='editar' omodal="1">Nueva Subactividad</button>
	</div>
</div>


<script type="text/javascript">
	$(function() {
		/*
		setTimeout(function(){ carga_acted(); }, 1000);
		function carga_acted(){
			$('.texto').summernote({
				lang: 'es-ES',
				placeholder: 'Texto',
				tabsize: 5,
				height: 250,
				toolbar: [
					// [groupName, [list of button]]
					['style', ['bold', 'italic', 'underline', 'clear']],
					['font', ['strikethrough', 'superscript', 'subscript']],
					['fontsize', ['fontsize']],
					['color', ['color']],
					['para', ['ul', 'ol', 'paragraph']],
					['height', ['height']]
				]
			});
		}
		*/
	});
</script>
