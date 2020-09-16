<?php
	require_once("db_.php");

	$idactividad=clean_var($_REQUEST['idactividad']);

  $actividad = $db->actividad_editar($idactividad);
	$subactividad = $db->subactividad_ver($idactividad);

	$nombre=$actividad->nombre;
	$observaciones=$actividad->observaciones;
	$indicaciones=$actividad->indicaciones;
	$inicial=0;

	if($actividad->idtrack){
		$inicial=1;
		$idtrack=$actividad->idtrack;
	}
	else{
		$modulo = $db->modulo_editar($actividad->idmodulo);
		$idtrack=$modulo->idtrack;
	}
	$track=$db->track_editar($idtrack);
	$idterapia=$track->idterapia;
	$terapia=$db->terapia_editar($idterapia);
?>

<nav aria-label='breadcrumb'>
	<ol class='breadcrumb'>
		<li class="breadcrumb-item" is="li-link" des="a_actividades/terapias" dix="trabajo" id1="">Inicio</li>
		<li class="breadcrumb-item" is="li-link" des="a_actividades/track" dix="trabajo" title="Track" v_idterapia="<?php echo $terapia->id; ?>"><?php echo $terapia->nombre; ?></li>
		<li class="breadcrumb-item" is="li-link" des="a_actividades/modulos" dix="trabajo" v_idtrack="<?php echo $track->id; ?>" ><?php echo $track->nombre; ?></li>
		<?php
			if($inicial==0){
		?>
			<li class="breadcrumb-item" is="li-link" des="a_actividades/actividades" dix="trabajo" v_idmodulo="<?php echo $modulo->id; ?>" ><?php echo $modulo->nombre; ?></li>
		<?php
			}
		 ?>
		<li class="breadcrumb-item active" is="li-link" des="a_actividades/actividad_ver" dix="trabajo" v_idactividad="<?php echo $actividad->idactividad; ?>" ><?php echo $actividad->nombre; ?></li>
		<?php
		if($inicial==0){
			echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades/actividades' dix='trabajo' v_idmodulo='$modulo->id'>Regresar</button>";
		}
		else{
			echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades/track' dix='trabajo' v_idterapia='$idterapia' >Regresar</button>";
		}
		?>
	</ol>
</nav>

<div class='container'>
<!-- actividad  -->
	<div id="accordion">
		<div class="card mb-3">
			<div class="card-header" id="headingOne">
				<div class='row'>
					<div class="col-2">

						<!---Editar actividad -->
						<?php
						if($inicial==0){
							echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades_e/actividad_editar' dix='trabajo' v_idactividad='$idactividad' v_idmodulo='$actividad->idmodulo'><i class='fas fa-pencil-alt'></i></button>";
						}
						else{
							echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades_e/actividad_editar' dix='trabajo' v_idactividad='$idactividad' v_idterapia='$idterapia'><i class='fas fa-pencil-alt'></i></button>";
						}
					?>

					<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades_e/escala2' v_idactividad='<?php echo $idactividad; ?>' omodal='1' v_idescala='0'><i class="fas fa-file-medical-alt"></i></button>


					</div>
					<div class="col-9 text-left">
						<button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
							Actividad: <?php echo $nombre; ?> 	(<?php echo $actividad->tipo; ?>)
						</button>
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
				<div class="col-2">

					<!-- Editar subactividad --->
					<button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_actividades_e/subactividad_editar" v_idsubactividad="<?php echo $key->idsubactividad; ?>" v_idactividad='<?php echo $idactividad; ?>' omodal="1"><i class="fas fa-pencil-alt"></i></button>

					<button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_actividades/actividad_ver" dix="trabajo" db="a_actividades/db_" fun="subactividad_borrar" v_idactividad="<?php echo $idactividad; ?>" v_idsubactividad="<?php echo $key->idsubactividad; ?>" tp="¿Desea eliminar la subactividad?" title="Borrar"><i class="far fa-trash-alt"></i></button>

					<?php
						//if($actividad->tipo=="evaluacion"){
							echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades_e/escala' v_idactividad='$idactividad' omodal='1' v_idescala='0' v_idsubactividad='$key->idsubactividad'><i class='fas fa-chart-line'></i></button>";
						//}
					 ?>

				</div>
				<div class="col-10">
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
							<div class="col-2">

								<!-- Editar Contexto --->
								<button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_actividades_e/contexto_editar" v_idcontexto="<?php echo $row->id; ?>" omodal="1"><i class="fas fa-pencil-alt"></i></button>

								<button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_actividades/actividad_ver" dix="trabajo" db="a_actividades/db_" fun="contexto_duplicar" v_idactividad="<?php echo $idactividad; ?>" v_idcontexto="<?php echo $row->id; ?>" tp="¿Desea duplicar el bloque?" title="Borrar"><i class="far fa-copy"></i></button>

								<button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_actividades/actividad_ver" dix="trabajo" db="a_actividades/db_" fun="contexto_borrar" v_idactividad="<?php echo $idactividad; ?>" v_idcontexto="<?php echo $row->id; ?>" tp="¿Desea eliminar el bloque selecionado?" title="Borrar"><i class="far fa-trash-alt"></i></button>

								<button <?php if($row->idcond){ echo "class='btn btn-danger btn-sm'"; } else { echo "class='btn btn-warning btn-sm'"; } ?> type='button' is='b-link' des='a_actividades_e/condicional_editar' v_idactividad="<?php echo $idactividad; ?>" omodal='1' v_idcontexto="<?php echo $row->id; ?>"><i class='fas fa-project-diagram'></i></button>

							</div>
							<div class="col-10 text-center">
								<button class="btn btn-link" data-toggle="collapse" data-target="#collapsecon<?php echo $row->id; ?>" aria-expanded="true" aria-controls="collapsecon<?php echo $row->id; ?>">
									Contexto (<?php echo $row->tipo; ?>)
								</button>
							</div>
						</div>
					</div>

					<div id="collapsecon<?php echo $row->id; ?>" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
						<div class="card-body">
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
										echo "<textarea class='texto' id='texto' name='texto' rows=5 placeholder=''>$row->texto</textarea>";
									}
									else if($row->tipo=="textocorto"){
										echo "<input type='text' class='form-control' id='texto' name='texto' rows=5 placeholder=''>$row->texto</input>";
									}
									else if($row->tipo=="fecha"){
										echo "<input type='date' name='texto' id='texto' value='$row->texto' class='form-control'>";
									}
									else if($row->tipo=="archivores"){
										echo "<input type='file' name='texto' id='texto' class='form-control'>";
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
													<div class="col-2">
														<!--Editar respuesta-->
														<button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_actividades_e/inciso_editar" v_idrespuesta="<?php echo $respuesta->id; ?>" v_idcontexto="<?php echo $row->id; ?>" v_idactividad="<?php echo $idactividad; ?>" params='tipo-inciso' omodal="1" ><i class="fas fa-pencil-alt"></i></button>

														<button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_actividades/actividad_ver" dix="trabajo" db="a_actividades/db_" fun="respuesta_borrar" v_idactividad="<?php echo $idactividad; ?>" v_idrespuesta="<?php echo $respuesta->id; ?>" tp="¿Desea eliminar el inciso selecionado?" title="Borrar"><i class="far fa-trash-alt"></i></button>

													</div>
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
													<?php
														if (strlen($respuesta->imagen)>0){
															echo "<div class='col-1'>";
																echo "<img src='".$db->doc.$respuesta->imagen."' width='20px'>";
															echo "</div>";
														}
													?>
													<div class="col-3">
														<?php echo $respuesta->nombre;  ?>
													</div>
													<div class="col-3">
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
											echo "<div class='col-2'>";
											echo "</div>";
											echo "<div class='col-1'>";

												if($row->incisos==1){
													echo "<input type='checkbox' name='' value=''>";
												}
												else{
													echo "<input type='radio' id='resp_<?php echo $row->id; ?>' name='resp_<?php echo $row->id; ?>' value='1'>";
												}
											echo "</div>";
											//echo "<div class='col-1'>";
											//echo "</div>";

											echo "<div class='col-3'>";
												echo "<input type='text' class='form-control' name='' value=''>";
											echo "</div>";
										echo "</div>";
									}
								?>
							</div>
							<?php
								if($row->tipo=="pregunta"){
							?>
								<br>
								<div class="row">
									<div class="col-12">
										<button class="btn btn-warning" type="button" is="b-link" des="a_actividades_e/inciso_editar" v_idrespuesta="0" v_idcontexto="<?php echo $row->id; ?>" v_idactividad="<?php echo $idactividad; ?>" params='tipo-imagen' omodal="1" >Agregar inciso</button>
									</div>
								</div>
							<?php
								}
							?>
							<!-- Fin Preguntas  -->
					</div>
				</div>
			</div>
			<?php
				}
			?>
			<?php
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
									echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades_e/escala' v_idactividad='$idactividad' omodal='1' v_idescala='$exca->id' v_idsubactividad='$key->idsubactividad' >
									Editar</button>";

									echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades/actividad_ver' dix='trabajo' db='a_actividades/db_' fun='borrar_escala' v_idescala='$exca->id' v_idactividad='$idactividad' v_idsubactividad='$key->idsubactividad'  tp='¿Desea eliminar la escala?' title='Borrar'>Borrar</button>";

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
						}
						echo "</table>";
					}

				}
			 ?>
				 <div class="container-fluid mb-3 text-center">
		 				<button class="btn btn-warning" type="button" is="b-link" des="a_actividades_e/bloque" dix="sub_<?php echo $key->idsubactividad; ?>" v_idactividad="<?php echo $idactividad; ?>" v_idsubactividad="<?php echo $key->idsubactividad; ?>" v_tipo="<?php echo $actividad->tipo; ?>" omodal="1" >Nuevo Bloque</button>
	 			</div>

			</div>
		</div>
	</div>
	</div>

<?php
	}
 ?>

 <?php

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

			 echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades_e/escala2' v_idactividad='$idactividad' omodal='1' v_idescala='$escala->id'><i class='fas fa-file-medical-alt'></i></button>";

			 echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades/actividad_ver' dix='trabajo' db='a_actividades/db_' fun='borrar_escalaactitivdad' v_idactividad='$idactividad' v_idsubactividad='$key->idsubactividad' tp='¿Desea eliminar la variable?' v_id='$escala->id' title='Borrar'><i class='far fa-trash-alt'></i></button>";

					 echo "Escala:".$escala->nombre;

				 echo "</div>";
			 echo "<div class='card-body'>";

				 $sql="select escala_contexto.*, respuestas.id as idresp, respuestas.nombre from escala_contexto left outer join respuestas on respuestas.id=escala_contexto.idrespuesta where escala_contexto.idescala='$escala->id'";
				 $sth = $db->dbh->prepare($sql);
				 $sth->execute();
				 $es=$sth->fetchAll(PDO::FETCH_OBJ);
				 echo "<table class='table tabe-sm'>";
				 echo "<tr><th>-</th><th>Descripcion</th></tr>";
				 foreach($es as $v2){
					 echo "<tr>";

					 echo "<td>";
					 echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades_e/contexto_escala' v_id='$v2->id' v_idescala='$escala->id' v_idactividad='$idactividad' omodal='1' ><i class='fas fa-list-ul'></i></button>";

					 echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades/actividad_ver' dix='trabajo' db='a_actividades/db_' fun='borrar_escalacont' v_idactividad='$idactividad' v_idsubactividad='$key->idsubactividad' tp='¿Desea eliminar la variable?' v_id='$v2->id' title='Borrar'><i class='far fa-trash-alt'></i></button>";
					 echo "</td>";

					 echo "<td>";
					 echo $v2->nombre;

					 $sql="select * from contexto_resp where idrespuesta='$v2->idresp'";
					 $xsth = $db->dbh->prepare($sql);
					 $xsth->execute();
					 if($xsth->rowCount()){
						 $tabparc=$xsth->fetch(PDO::FETCH_OBJ);
						 if(is_numeric($tabparc->valor)){
							 $gparcial+=$tabparc->valor;
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
						 echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades_e/escala3' v_id='$v2->id' v_idescala='$escala->id' v_idactividad='$idactividad' omodal='1' v_idescala='0'><i class='fas fa-file-medical-alt'></i></button>";

					 	echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades/actividad_ver' dix='trabajo' db='a_actividades/db_' fun='borrar_escalaact' v_idactividad='$idactividad' v_idsubactividad='$key->idsubactividad' tp='¿Desea eliminar la escala?' v_id='$v2->id' title='Borrar'><i class='far fa-trash-alt'></i></button>";

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
					 echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades_e/escala3' v_id='0' v_idescala='$escala->id' v_idactividad='$idactividad' omodal='1' ><i class='fas fa-file-medical-alt'></i></button>";

					 echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades_e/contexto_escala' v_id='0' v_idescala='$escala->id' v_idactividad='$idactividad' omodal='1' ><i class='fas fa-list-ul'></i></button>";
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
 	<button class='btn btn-warning' type="button" is="b-link" des='a_actividades_e/subactividad_editar' dix='nueva_sub' v_idsubactividad="0" v_idactividad='<?php echo $idactividad; ?>' title='editar' omodal="1">Nueva Subactividad</button>
 </div>

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
