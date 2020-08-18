<?php
	require_once("db_.php");

	$idactividad=clean_var($_REQUEST['idactividad']);
  $actividad = $db->actividad_editar($idactividad);
	$subactividad = $db->subactividad_ver($idactividad);

	$nombre=$actividad->nombre;
	$observaciones=$actividad->observaciones;
	$indicaciones=$actividad->indicaciones;

	$modulo = $db->modulo_editar($actividad->idmodulo);
	$track=$db->track_editar($modulo->idtrack);
	$terapia=$db->terapia_editar($track->idterapia);
?>

<nav aria-label='breadcrumb'>
	<ol class='breadcrumb'>
		<li class="breadcrumb-item" type="button" is="li-link" des="a_actividades/terapias" dix="trabajo" id1="">Inicio</lis>
		<li class="breadcrumb-item" type="button" is="li-link" des="a_actividades/track" dix="trabajo" title="Track" v_idterapia="<?php echo $terapia->id; ?>"><?php echo $terapia->nombre; ?></li>
		<li class="breadcrumb-item" type="button" is="li-link" des="a_actividades/modulos" dix="trabajo" v_idtrack="<?php echo $track->id; ?>" ><?php echo $track->nombre; ?></li>
		<li class="breadcrumb-item" type="button" is="li-link" des="a_actividades/actividades" dix="trabajo" v_idmodulo="<?php echo $modulo->id; ?>" ><?php echo $modulo->nombre; ?></li>
		<li class="breadcrumb-item active" type="button" is="li-link" des="a_actividades/actividad_ver" dix="trabajo" v_idactividad="<?php echo $actividad->idactividad; ?>" ><?php echo $actividad->nombre; ?></li>
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
					<button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_actividades_e/actividad_editar" dix="trabajo" v_idactividad="<?php echo $idactividad; ?>" v_idmodulo="<?php echo $actividad->idmodulo; ?>"><i class="fas fa-pencil-alt"></i></button>


				</div>
				<div class="col-9 text-left">
					<button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
						Actividad: <?php echo $nombre; ?>
					</button>
				</div>
				<div class="col-1">



					<button class="btn btn-warning btn-sm float-right" type="button" is="b-link" des="a_actividades/actividades" dix="trabajo" v_idmodulo="<?php echo $modulo->id; ?>">Regresar</button>
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


<div class="container-fluid mb-3 text-center">
	<button class='btn btn-warning' type="button" is="b-link" des='a_actividades_e/subactividad_editar' dix='nueva_sub' v_idsubactividad="0" v_idactividad='<?php echo $idactividad; ?>' title='editar' omodal="1">Nueva Subactividad</button>
</div>

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
			<div class="container-fluid mb-3 text-center">
				<button class="btn btn-warning" type="button" is="b-link" des="a_actividades_e/bloque" dix="sub_<?php echo $key->idsubactividad; ?>" v_idactividad="<?php echo $idactividad; ?>" v_idsubactividad="<?php echo $key->idsubactividad; ?>" v_tipo="<?php echo $actividad->tipo; ?>" omodal="1" >Nuevo Bloque</button>
			</div>

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
							</div>
							<div class="col-4 text-center">
								<button class="btn btn-link" data-toggle="collapse" data-target="#collapsecon<?php echo $row->id; ?>" aria-expanded="true" aria-controls="collapsecon<?php echo $row->id; ?>">
									Contexto (<?php echo $row->tipo; ?>)
								</button>
							</div>
							<div class="col-4">
								<button class="btn btn-warning btn-sm" ><i class="fas fa-arrows-alt"></i>Mover</button>

								<button class="btn btn-warning btn-sm" ><i class="fas fa-project-diagram"></i>Condicional</button>
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
										echo "<textarea class='form-control' id='texto' name='texto' rows=5 placeholder=''>$row->texto</textarea>";
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
												<div class="col-1">
													<img src="<?php echo $db->doc.$respuesta->imagen; ?>" alt="" width="20px">
												</div>
												<div class="col-3">
													<?php echo $respuesta->nombre;  ?>
												</div>
												<div class="col-2">
													<?php
														if($row->usuario==1){
															echo "<input type='text' name='' value='' placeholder='Define..'>";
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
										echo "<div class='col-1'>";
										echo "</div>";

										echo "<div class='col-3'>";
											echo "<input type='text' name='' value=''>";
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
		</div>
		</div>
	</div>
	</div>

<?php
	}
 ?>
</div>
