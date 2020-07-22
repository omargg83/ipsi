<?php
	require_once("db_.php");

	$idactividad=clean_var($_REQUEST['idactividad']);
  $actividad=$db->actividad_editar($idactividad);
	$subactividad=$db->subactividad_ver($idactividad);
	$nombre=$actividad->nombre;
	$observaciones=$actividad->observaciones;
	$indicaciones=$actividad->indicaciones;
?>
<nav aria-label='breadcrumb'>
  <ol class='breadcrumb'>
    <li class='breadcrumb-item' id='lista_act' data-lugar='a_actividades/lista'>Actividades</li>
    <li class='breadcrumb-item active' aria-current='page'>Actividad</li>
  </ol>
</nav>

<div class="card mb-3">
	<div class="card-header">
		<div class='row'>
			<div class="col-8 text-center">
				<?php echo $nombre; ?>
			</div>
			<div class="col-4 text-right">
				<div class="btn-group">
					<div class="btn-group dropleft" role="group">
						<button type="button" class="btn btn-warning btn-sm dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Agregar subactividad
						</button>
						<div class="dropdown-menu">
							<button class="dropdown-item" onclick="subactividad_editar(0,<?php echo $idactividad; ?>,'texto')"><i class='fas fa-pencil-alt'></i>Texto</button>
							<button class="dropdown-item" onclick="subactividad_editar(0,<?php echo $idactividad; ?>,'imagen')"><i class="fas fa-arrows-alt"></i>Imagen</button>
							<button class="dropdown-item" onclick="subactividad_editar(0,<?php echo $idactividad; ?>,'video')"><i class="far fa-trash-alt"></i>Video</button>
							<button class="dropdown-item" onclick="subactividad_editar(0,<?php echo $idactividad; ?>,'archivo')"><i class="far fa-copy"></i>Archivo</button>
							<button class="dropdown-item" onclick="subactividad_editar(0,<?php echo $idactividad; ?>,'pregunta')"><i class="fas fa-question"></i>Pregunta</button>
						</div>
					</div>

					<button type="button" class='btn btn-warning btn-sm' title="Editar Actividad" onclick='actividad_editar(<?php echo $idactividad; ?>)'><i class='fas fa-pencil-alt'></i></button>
					<button type="button" class='btn btn-warning btn-sm' title="Eliminar actividad" onclick='eliminar_act(<?php echo $idactividad; ?>)'><i class='far fa-trash-alt'></i></button>

				</div>
			</div>
		</div>
	</div>
	<div class='card-body'>
		<p>Indicaciones</p>
		<?php echo $indicaciones; ?>

		<p>Observaciones</p>
		<?php echo $observaciones; ?>
	</div>
</div>

<div class="container-fluid" id='subactividad'>
	<?php
		foreach($subactividad as $key){
	?>
		<div class="card mb-3">
			<div class="card-header">
				<div class='row'>
					<div class="col-8 text-center">
						Actividad
					</div>
					<div class="col-4 text-right">
						<div class="btn-group dropleft" role="group">
							<button type="button" class="btn btn-warning btn-sm dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="fas fa-plus"></i> <span class="sr-only">Toggle Dropleft</span>
							</button>
							<div class="dropdown-menu">
								<button class="dropdown-item" onclick="subactividad_ver(<?php echo $key->idsubactividad; ?>,0,0)"><i class="far fa-eye"></i>Ver</button>
								<button class="dropdown-item" onclick="subactividad_editar(<?php echo $key->idsubactividad; ?>,0,0)"><i class='fas fa-pencil-alt'></i>Editar</button>
								<button class="dropdown-item" ><i class="fas fa-arrows-alt"></i>Mover</button>
								<button class="dropdown-item" onclick='eliminar_subact(<?php echo $key->idsubactividad; ?>)' ><i class="far fa-trash-alt"></i>Eliminar</button>
								<button class="dropdown-item" ><i class="far fa-copy"></i>Duplicar</button>
								<button class="dropdown-item" ><i class="fas fa-project-diagram"></i>Condicional</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card-body">
				<?php	echo $key->texto; ?>
			</div>
		</div>
	<?php
		}
	 ?>
</div>
