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
				<div class="col-2">
				</div>
				<div class="col-9 text-left">
					<button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
						Actividad: <?php echo $nombre_act; ?>
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
				<div class="col-12">
					<button class="btn btn-link" data-toggle="collapse" data-target="#collapsesub<?php echo $key->idsubactividad; ?>" aria-expanded="true" aria-controls="collapsesub<?php echo $key->idsubactividad; ?>">
						<?php echo $key->orden; ?>- Subactividad: <?php echo $key->nombre; ?>
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
				?>

				<div class="card mb-4" draggable="true">
					<div class="card-header">
						<div class='row'>
							<div class="col-12 text-center">
								<button class="btn btn-link" data-toggle="collapse" data-target="#collapsecon<?php echo $row->id; ?>" aria-expanded="true" aria-controls="collapsecon<?php echo $row->id; ?>">
									Contexto (<?php echo $row->tipo; ?>)
								</button>
							</div>
						</div>
					</div>

					<div id="collapsecon<?php echo $row->id; ?>" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
						<div class="card-body">
							<?php
								echo "<form is='f-submit' id='form_g_".$row->id."' db='a_respuesta/db_' fun='guarda_respuesta' des='a_respuesta/actividad_ver' dix='contenido' msg='algo' v_idactividad='$idactividad' v_idpaciente='$idpaciente' v_idcontexto='$row->id'>";

								$sql="select * from contexto_resp where idcontexto=:id";
								$contx = $db->dbh->prepare($sql);
								$contx->bindValue(":id",$row->id);
								$contx->execute();
								$texto="";
								$fecha="";
								$archivo="";
								$valor="";
								if($contx->rowCount()>0){
									$contexto_resp=$contx->fetch(PDO::FETCH_OBJ);
									$texto=$contexto_resp->texto;
									$fecha=$contexto_resp->fecha;
									$archivo=$contexto_resp->archivo;
									$valor=$contexto_resp->valor;
								}
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
									else if($row->tipo=="pregunta"){
										echo $row->texto;
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
								?>
								<hr>

							</div>

							<!-- Fin de contexto  -->
							<!-- Preguntas  -->
							<div class="container-fluid">
								<?php
								$rx=$db->respuestas_ver($row->id);
								foreach ($rx as $respuesta) {


									?>
											<div class="row">
												<div class="col-1">
													<?php
														if($row->incisos==1){
															echo "<input type='checkbox' name='' value=''>";
														}
														else{
															echo "<input type='radio' id='resp_<?php echo $row->id; ?>' name='resp_<?php echo $row->id; ?>' value='1'>";
														}
													?>
												</div>
												<div class="col-1">
													<?php
														if(strlen($respuesta->imagen)>0){
															echo "<img src=".$db->doc.$respuesta->imagen." alt='' width='20px'>";
														}
													?>
												</div>
												<div class="col-3">
													<?php echo $respuesta->nombre;  ?>
												</div>
												<div class="col-1">
													<?php echo $respuesta->valor;  ?>
												</div>
												<div class="col-4">
													<?php
														if($row->usuario==1){
															echo "<input type='text' name='' value='' placeholder='Define..' class='form-control'>";
														}
													?>
												</div>
											</div>
									<?php
								}

								if($row->personalizado==1){
									echo "<div class='row'>";
										echo "<div class='col-1'>";
											if($row->incisos==1){
												echo "<input type='checkbox' name='' value=''>";
											}
											else{
												echo "<input type='radio' id='resp_<?php echo $row->id; ?>' name='resp_<?php echo $row->id; ?>' value='1'>";
											}
										echo "</div>";
										echo "<div class='col-1'>";
										echo "</div>";

										echo "<div class='col-3'>";
											echo "<input type='text' name='' value='' class='form-control'>";
										echo "</div>";
									echo "</div>";
								}

								?>

							</div>
							<!-- Fin Preguntas  -->
							<br>
							<?php
							if(strlen($valor)==0){
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
