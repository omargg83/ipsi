<?php
	require_once("db_.php");

	$idactividad=$_REQUEST['idactividad'];
	$idpaciente=$_SESSION['idusuario'];

	/////////////////////breadcrumb
	$paciente = $db->cliente_editar($idpaciente);
	$nombre=$paciente->nombre." ".$paciente->apellidop." ".$paciente->apellidom;

	$sql="select * from actividad where idactividad=:idactividad";
	$sth = $db->dbh->prepare($sql);
	$sth->bindValue(":idactividad",$idactividad);
	$sth->execute();
	$actividad=$sth->fetch(PDO::FETCH_OBJ);

	$inicial=0;
	if($actividad->tipo=="inicial"){
		$inicial=1;
		$idterapia=$actividad->idterapia;
	}
	else{

		$sql="select * from modulo where id=:idmodulo";
		$sth = $db->dbh->prepare($sql);
		$sth->bindValue(":idmodulo",$actividad->idmodulo);
		$sth->execute();
		$modulo=$sth->fetch(PDO::FETCH_OBJ);

		$sql="select * from track where id=:idtrack";
		$sth = $db->dbh->prepare($sql);
		$sth->bindValue(":idtrack",$modulo->idtrack);
		$sth->execute();
		$track=$sth->fetch(PDO::FETCH_OBJ);
		$idterapia=$track->idterapia;
	}

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

	 <li class='breadcrumb-item' id='lista_track' is="li-link" des="a_respuesta/terapias"  dix="contenido">Terapias</li>
	 <li class="breadcrumb-item" id='lista_track' is="li-link" des="a_respuesta/track" dix="contenido" v_idterapia="<?php echo $terapia->id; ?>" ><?php echo $terapia->nombre; ?></li>
	 <?php
	 if($inicial==0){
	?>
		 <li class="breadcrumb-item" id='lista_track' is="li-link" des="a_respuesta/modulos" dix="contenido" v_idtrack="<?php echo $track->id; ?>" ><?php echo $track->nombre; ?></li>
		 <li class="breadcrumb-item" id='lista_track' is="li-link" des="a_respuesta/actividades" dix="contenido" v_idmodulo="<?php echo $modulo->id; ?>" ><?php echo $modulo->nombre; ?></li>
		<?php
	 }
	 ?>
	 <li class="breadcrumb-item active" id='lista_track' is="li-link" des="a_respuesta/actividad_ver" dix="contenido" v_idactividad="<?php echo $idactividad; ?>" ><?php echo $nombre_act; ?></li>
 </ol>
</nav>

<!-- actividad  -->
<div class="container">
<div id="accordion">
	<div class="card mb-3">
		<div class="card-header" id="headingOne">
			<div class='row'>
				<div class="col-11 text-center">
					<button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
						Actividad: <?php echo $nombre_act; ?>
						<?php
							$sql="SELECT count(contexto.id) as total from contexto
							left outer join subactividad on subactividad.idsubactividad=contexto.idsubactividad
							where subactividad.idactividad=:id";
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
							$total=(100*$contx->rowCount())/$bloques->total;

							echo "<br>(".$contx->rowCount()."/".$bloques->total.")<br>";
							echo "<progress id='file' value='$total' max='100'> $total %</progress>";
						?>

					</button>
				</div>
				<div class="col-1">
					<?php
					if($inicial==0){
					?>
					<button class="btn btn-warning btn-sm float-right" type="button" is="b-link" des="a_respuesta/actividades" dix="contenido" v_idmodulo="<?php echo $modulo->id; ?>" >Regresar</button>
					<?php
					}
					else{
					?>
						<button class="btn btn-warning btn-sm float-right" type="button" is="b-link" des="a_respuesta/track" dix="contenido" v_idterapia="<?php echo $idterapia; ?>" >Regresar</button>
					<?php
					}
					?>
				</div>
			</div>
		</div>

		<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
			<div class='card-body'>
				<p>Indicaciones</p>
				<?php echo $indicaciones; ?>
			</div>
		</div>
	</div>
</div>
<!-- Fin de actividad  -->


<?php
	foreach($subactividad as $key){
?>
	<!-- Subactividad  -->
	<div class="container-fluid mb-4" id="sub_<?php echo $key->idsubactividad; ?>">
		<div class="card" >
		<div class="card-header">
			<div class="row">
				<div class="col-12 text-center">
					<button class="btn btn-link" data-toggle="collapse" data-target="#collapsesub<?php echo $key->idsubactividad; ?>" aria-expanded="true" aria-controls="collapsesub<?php echo $key->idsubactividad; ?>">
						<?php echo $key->orden; ?>- Subactividad: <?php echo $key->nombre; ?>
						<?php

							$sql="SELECT count(contexto.id) as total from contexto where idsubactividad = :id";
							$contx = $db->dbh->prepare($sql);
							$contx->bindValue(":id",$key->idsubactividad);
							$contx->execute();
							$bloques=$contx->fetch(PDO::FETCH_OBJ);

							$sql="SELECT count(contexto_resp.id) as total FROM	contexto right OUTER JOIN contexto_resp ON contexto_resp.idcontexto=contexto.id WHERE	idsubactividad = :id	group by contexto.id";
							$contx = $db->dbh->prepare($sql);
							$contx->bindValue(":id",$key->idsubactividad);
							$contx->execute();
							$total=(100*$contx->rowCount())/$bloques->total;

							echo "<br>(".$contx->rowCount()."/".$bloques->total.")<br>";
							echo "<progress id='file' value='$total' max='100'> $total %</progress>";
						 ?>
					</button>
				</div>
			</div>
		</div>

	<!-- fin de Subactividad  -->

		<!-- Contexto  -->
		<div id="collapsesub<?php echo $key->idsubactividad; ?>" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
			<div class="card-body" id='bloque'>
				<?php
				$bloq=$db->contexto_ver($key->idsubactividad);
				foreach($bloq as $row){
					echo "idcontexto:".$row->id;
					$sql="select * from contexto_resp where idcontexto=:id";
					$contx = $db->dbh->prepare($sql);
					$contx->bindValue(":id",$row->id);
					$contx->execute();
					$texto="";
					$fecha="";
					$archivo="";
					$marca="";
					if($contx->rowCount()>0){
						$contexto_resp=$contx->fetch(PDO::FETCH_OBJ);
						$texto=$contexto_resp->texto;
						$fecha=$contexto_resp->fecha;
						$archivo=$contexto_resp->archivo;
						$marca=$contexto_resp->marca;
					}
				?>


				<div class="card mb-4">
					<div class="card-header">
						<div class='row'>
							<div class="col-12 text-center">
								<button class="btn btn-link" data-toggle="collapse" data-target="#collapsecon<?php echo $row->id; ?>" aria-expanded="true" aria-controls="collapsecon<?php echo $row->id; ?>">
									Contexto (<?php echo $row->tipo; ?>)<br>
									<?php
										if(strlen($marca)>0){
											echo "<i class='fas fa-user-check'></i>(1/1)<br>";
											echo "<progress id='file' value='100' max='100'> 100 %</progress>";
										}
										else{
											echo "(0/1)<br>";
											echo "<progress id='file' value='0' max='100'> 0 %</progress>";
										}
									 ?>
								</button>
							</div>
						</div>
					</div>
					<div id="collapsecon<?php echo $row->id; ?>" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
						<div class="card-body">
							<?php
								echo "<form is='f-submit' id='form_g_".$row->id."' db='a_respuesta/db_' fun='guarda_respuesta' des='a_respuesta/actividad_ver' dix='contenido' msg='algo' v_idactividad='$idactividad' v_idpaciente='$idpaciente' v_idcontexto='$row->id'>";
							?>
							<div>
								<?php	echo $row->observaciones; ?>
							</div>
							<hr>
							<div>
								<?php
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
										echo "<textarea class='texto' id='texto' name='texto' rows=5 placeholder=''>$texto</textarea>";
									}
									else if($row->tipo=="fecha"){
										echo "<input type='date' name='fecha' id='fecha' value='$fecha' class='form-control'>";
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

												if($row->incisos==1){
													$sql="select * from contexto_resp where idcontexto=:id and idrespuesta=:idrespuesta";
													$contx = $db->dbh->prepare($sql);
													$contx->bindValue(":id",$row->id);
													$contx->bindValue(":idrespuesta",$respuesta->id);
													$contx->execute();
													$resp=$contx->fetch(PDO::FETCH_OBJ);

													if($contx->rowCount()>0){
														$texto_resp=$resp->texto;
														$valor_resp=$resp->valor;
													}
												}
												else{
													$sql="select * from contexto_resp where idcontexto=:id";
													$contx = $db->dbh->prepare($sql);
													$contx->bindValue(":id",$row->id);
													$contx->execute();
													if($contx->rowCount()>0){
														$resp=$contx->fetch(PDO::FETCH_OBJ);
														$resp_idrespuesta=$resp->idrespuesta;
													}
												}
												echo "<div class='row'>";
													echo "<div class='col-1'>";
														if($row->incisos==1){
															$idx="";
															echo "<input type='checkbox' name='checkbox_".$respuesta->id."' value='$respuesta->valor' ";
															if($respuesta->valor==$valor_resp){ echo " checked";}
															echo ">";
														}
														else{
															$idx=$row->id;
															echo "<input type='radio' name='radio_".$idx."' value='$respuesta->valor' ";
																if($respuesta->id==$resp_idrespuesta){
																	echo " checked";
																	$texto_resp=$resp->texto;
																}
															echo ">";
														}
													echo "</div>";

													echo "<div class='col-1'>";
														if(strlen($respuesta->imagen)>0){
															echo "<img src=".$db->doc.$respuesta->imagen." alt='' width='20px'>";
														}
													echo "</div>";

													echo "<div class='col-3'>";
														echo $respuesta->nombre;
													echo "</div>";

													echo "<div class='col-7'>";
														if($row->usuario==1){
															echo "<input type='text' name='resp_".$respuesta->id."' id='resp_".$respuesta->id."' value='$texto_resp' placeholder='Define..' class='form-control form-control-sm'>";
														}
														echo "</div>";
													echo "</div>";
											}
											if($row->personalizado==1){
												$texto="";
												$otro=0;
												$sql="select * from contexto_resp where idcontexto=:id and otraresp='OTRO'";
												$contx = $db->dbh->prepare($sql);
												$contx->bindValue(":id",$row->id);
												$contx->execute();
												if($contx->rowCount()>0){
													$resp=$contx->fetch(PDO::FETCH_OBJ);
													$texto=$resp->texto;
													$otro=1;
												}

												echo "<div class='row'>";
													if($row->incisos==1){
															echo "<div class='col-1'>";
																echo "<input type='checkbox' name='datacheck_".$row->id."'";
																if($otro==1){
																	echo " checked";
																}
																echo " value='1'>";
															echo "</div>";
															echo "<div class='col-1'>";
															echo "</div>";
															echo "<div class='col-10'>";
																echo "<input type='text' name='otroche_".$row->id."' id='per_".$row->id."' value='$texto' class='form-control form-control-sm' placeholder='otro'>";
															echo "</div>";
														}
														else{
															echo "<div class='col-1'>";
																echo "<input type='radio' name='radio_".$idx."' value='otra'";
																if($otro==1){
																	echo " checked";
																}
																echo " value='1'>";
															echo "</div>";
															echo "<div class='col-1'>";
															echo "</div>";
															echo "<div class='col-10'>";
																echo "<input type='text' name='otrorad_".$row->id."' id='per_".$row->id."' value='$texto' class='form-control form-control-sm' placeholder='otro'>";
															echo "</div>";
													}
												echo "</div>";
											}
										echo "</div>";
									}
							?>
							</div>
							<!-- Fin Preguntas  -->
							<br>
							<?php
							if(strlen($marca)==0){
								echo "<button class='btn btn-danger btn-sm' type='submit'><i class='far fa-check-circle'></i>Contestar</button>";
							}
							else{
								echo "<button class='btn btn-warning btn-sm' type='submit'><i class='fas fa-check-double'></i>Actualizar</button>";
							}
							?>
							</form>
						</div>
					</div>
				</div>


			<?php
				}
			?>
		</div>
		</div>
	</div>
	</div>

<?php
	}
 ?>
</div>


<script type="text/javascript">
	$(function() {
		$('.texto').summernote({
			lang: 'es-ES',
			placeholder: 'Texto',
			tabsize: 5,
			height: 250
		});
	});
</script>
