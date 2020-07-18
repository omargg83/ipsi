<?php
	require_once("db_.php");

	$idactividad=clean_var($_REQUEST['idactividad']);
  $cuest=$db->actividad_editar($idactividad);
	$nombre=$cuest->nombre;
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
						</div>
					</div>

					<button type="button" class='btn btn-warning btn-sm' title="Editar Actividad" onclick='actividad_editar(<?php echo $idactividad; ?>)'><i class='fas fa-pencil-alt'></i></button>
					<button type="button" class='btn btn-warning btn-sm' title="Eliminar actividad" onclick='eliminar_act(<?php echo $idactividad; ?>)'><i class='far fa-trash-alt'></i></button>


					<div class="btn-group dropleft" role="group">
						<button type="button" class="btn btn-warning btn-sm dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fas fa-plus"></i> <span class="sr-only">Toggle Dropleft</span>
						</button>
						<div class="dropdown-menu">
							<a class="dropdown-item" href="#"><i class='fas fa-pencil-alt'></i>Editar</a>
							<a class="dropdown-item" href="#"><i class="fas fa-arrows-alt"></i>Mover</a>
							<a class="dropdown-item" href="#"><i class="far fa-trash-alt"></i>Eliminar</a>
							<a class="dropdown-item" href="#"><i class="far fa-copy"></i>Duplicar</a>
							<a class="dropdown-item" href="#"><i class="fas fa-project-diagram"></i>Condicional</a>
						</div>
					</div>


				</div>
			</div>
		</div>
	</div>
</div>

<div class="card mb-3" id='subactividad'>

</div>
