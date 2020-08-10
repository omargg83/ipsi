<?php
	require_once("db_.php");
	$id1=clean_var($_REQUEST['id1']);
	$idactividad=clean_var($_REQUEST['id2']);

  $cliente = $db->cliente_editar($id1);


  $actividad=$db->actividad_editar($idactividad);
  $nombre=$actividad->nombre;
	$observaciones=$actividad->observaciones;
	$indicaciones=$actividad->indicaciones;
	$terapia=$actividad->terapia;
	$track=$actividad->track;

  $subactividad = $db->subactividad_ver($idactividad);
?>

<nav aria-label='breadcrumb'>
	<ol class='breadcrumb'>
		<li class='breadcrumb-item' id='lista_track' is="li-link" des="a_pacientes/lista" dix="trabajo">Pacientes</li>
		<li class='breadcrumb-item active' id='lista_track' is="li-link" des="a_pacientes/paciente" id1="<?php echo $id1; ?>" dix="trabajo"><?php echo $cliente->nombre." ".$cliente->apellidop." ".$cliente->apellidom; ?></li>
    <li class="breadcrumb-item" type="button" is="li-link" des="a_pacientes/actividad" dix="trabajo" id1="<?php echo $id1; ?>" id2="<?php echo $idactividad; ?>"><?php echo $actividad->nombre; ?></li>
	</ol>
</nav>

<!-- actividad  -->
<div id="accordion">
	<div class="card mb-3">
		<div class="card-header" id="headingOne">
			<div class='row'>
				<div class="col-2">
					<button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_pacientes_e/actividad_editar" dix="trabajo" id1="<?php echo $idactividad; ?>" id2="<?php echo $actividad->idmodulo; ?>">Editar</button>
				</div>
				<div class="col-9 text-left">
					<button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
						Actividad: <?php echo $nombre; ?>
					</button>
				</div>
				<div class="col-1">
					<button class="btn btn-warning btn-sm float-right" type="button" is="b-link" des="a_pacientes/paciente" dix="trabajo" id1="<?php echo $id1; ?>">Regresar</button>
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
	<button class='btn btn-warning' type="button" is="b-link" des='a_pacientes_e/subactividad_editar' dix='nueva_sub' tp="edit" id1="0" id2='<?php echo $idactividad; ?>' title='editar' omodal="1">Nueva Subactividad</button>
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
					<button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_pacientes_e/subactividad_editar" dix="sub_<?php echo $key->idsubactividad; ?>" id1="<?php echo $key->idsubactividad; ?>" id2='<?php echo $idactividad; ?>' omodal="1">Editar</button>
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
				<button class="btn btn-warning" type="button" is="b-link" des="a_actividades/bloque" dix="sub_<?php echo $key->idsubactividad; ?>" id1="<?php echo $idactividad; ?>" id2="<?php echo $key->idsubactividad; ?>" id3="texto" params='tipo-imagen' omodal="1" >Bloque</button>
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
								<button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_pacientes_e/contexto_editar" dix="sub_<?php echo $key->idsubactividad; ?>" id1="<?php echo $row->id; ?>" omodal="1">Editar</button>
							</div>
							<div class="col-4 text-center">
								<button class="btn btn-link" data-toggle="collapse" data-target="#collapsecon<?php echo $row->id; ?>" aria-expanded="true" aria-controls="collapsecon<?php echo $row->id; ?>">
									Contexto (<?php echo $row->tipo; ?>)
								</button>
							</div>
							<div class="col-4">
								<button class="btn btn-warning btn-sm" ><i class="fas fa-arrows-alt"></i>Mover</button>
								<button class="btn btn-warning btn-sm" onclick='eliminar_subact(<?php echo $key->idsubactividad; ?>)' ><i class="far fa-trash-alt"></i>Eliminar</button>
								<button class="btn btn-warning btn-sm" ><i class="far fa-copy"></i>Duplicar</button>
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
									if($row->tipo=="texto"){
										echo $row->texto;
									}
									if($row->tipo=="video"){
										echo $row->texto;
									}
									if($row->tipo=="archivo"){
										echo "<a href='".$db->doc.$row->texto."' download='$row->texto'>Descargar</a>";
									}
									if($row->tipo=="pregunta"){
										echo $row->texto;
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
													<button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_pacientes_e/inciso_editar" id1="<?php echo $respuesta->id; ?>" id2="<?php echo $row->id; ?>" id3="<?php echo $idactividad; ?>" params='tipo-inciso' omodal="1" >Editar</button>
												</div>
												<div class="col-10">
													<?php echo $respuesta->nombre;  ?>
												</div>
											</div>
									<?php
								}
								?>
							</div>
							<button class="btn btn-warning" type="button" is="b-link" des="a_pacientes_e/inciso_editar" id1="0" id2="<?php echo $row->id; ?>" id3="<?php echo $idactividad; ?>" params='tipo-imagen' omodal="1" >Agregar inciso</button>
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
