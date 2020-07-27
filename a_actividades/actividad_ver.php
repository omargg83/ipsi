<?php
	require_once("db_.php");

	$idactividad=clean_var($_REQUEST['id1']);
  $actividad=$db->actividad_editar($idactividad);
	$subactividad=$db->subactividad_ver($idactividad);
	$nombre=$actividad->nombre;
	$observaciones=$actividad->observaciones;
	$indicaciones=$actividad->indicaciones;

?>
<nav aria-label='breadcrumb'>
  <ol class='breadcrumb'>
		<li class="breadcrumb-item" type="button" is="li-link" des="a_actividades/lista" dix="trabajo" id1="">Actividades</lis>
    <li class='breadcrumb-item active' aria-current='page'>Actividad</li>
  </ol>
</nav>

<div class="card mb-3">
	<div class="card-header">
		<div class='row'>
			<div class="col-8 text-center">
				<?php echo $nombre; ?>
			</div>
			<div class="col-4">
				<div class="btn-group">
					<button class="btn btn-warning" type="button" is="b-link" des="a_actividades/actividad_editar" dix="trabajo" id1="<?php echo $idactividad; ?>">Editar</button>
					<button class="btn btn-warning" type="button" is="b-link" des="a_actividades/lista" dix="trabajo" id1="">Regresar</button>
					<button type="button" class='btn btn-warning btn-sm' title="Eliminar actividad" onclick='eliminar_act(<?php echo $idactividad; ?>)'><i class='far fa-trash-alt'></i></button>
				</div>
			</div>
		</div>
	</div>
	<!--
	<div class='card-body'>
		<p>Indicaciones</p>
		<?php echo $indicaciones; ?>

		<p>Observaciones</p>
		<?php echo $observaciones; ?>
	</div>
-->
</div>

<div class="container-fluid mb-3 text-center" id='nueva_sub'>


	<button class='btn btn-warning' type="button" is="b-link" des='a_actividades/subactividad_editar' dix='nueva_sub' tp="edit" id1="0" id2='<?php echo $idactividad; ?>' title='editar'>Nueva Subactividad</button>

</div>

<?php
	foreach($subactividad as $key){
?>
<div class="card">
	<div class="card-header">
		subactividad
									<button class="btn btn-warning" onclick="subactividad_editar(0,<?php echo $idactividad; ?>,'texto')"><i class='fas fa-pencil-alt'></i>Texto</button>
									<button class="btn btn-warning" onclick="subactividad_editar(0,<?php echo $idactividad; ?>,'imagen')"><i class="fas fa-arrows-alt"></i>Imagen</button>
									<button class="btn btn-warning" onclick="subactividad_editar(0,<?php echo $idactividad; ?>,'video')"><i class="far fa-trash-alt"></i>Video</button>
									<button class="btn btn-warning" onclick="subactividad_editar(0,<?php echo $idactividad; ?>,'archivo')"><i class="far fa-copy"></i>Archivo</button>
									<button class="btn btn-warning" onclick="subactividad_editar(0,<?php echo $idactividad; ?>,'pregunta')"><i class="fas fa-question"></i>Pregunta</button>
	</div>
	<div class="container-fluid" id='subactividad'>
		<div class="card mb-3">
			<div class="card-header">
				<div class='row'>
					<div class="col-2 text-center">
						Actividad
					</div>
					<div class="col-10">

								<button class="btn" onclick="subactividad_ver(<?php echo $key->idsubactividad; ?>,0,0)"><i class="far fa-eye"></i>Ver</button>
								<button class="btn" onclick="subactividad_editar(<?php echo $key->idsubactividad; ?>,0,0)"><i class='fas fa-pencil-alt'></i>Editar</button>
								<button class="btn" ><i class="fas fa-arrows-alt"></i>Mover</button>
								<button class="btn" onclick='eliminar_subact(<?php echo $key->idsubactividad; ?>)' ><i class="far fa-trash-alt"></i>Eliminar</button>
								<button class="btn" ><i class="far fa-copy"></i>Duplicar</button>
								<button class="btn" ><i class="fas fa-project-diagram"></i>Condicional</button>

					</div>
				</div>
			</div>
			<div class="card-body">

				<?php	echo $key->texto; ?>
				<hr>
				<div class="card">
					<div class="card-header">
						respuesta
					</div>
					<div class="card-body">
						<input type="radio" name="" value="">1
						<input type="radio" name="" value="">2
						<input type="radio" name="" value="">3

					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
	}
 ?>

<div class="card">
	<div class="card-header">
		subactividad

		<button class="dropdown-item" onclick="subactividad_editar(0,<?php echo $idactividad; ?>,'texto')"><i class='fas fa-pencil-alt'></i>Texto</button>
		<button class="dropdown-item" onclick="subactividad_editar(0,<?php echo $idactividad; ?>,'imagen')"><i class="fas fa-arrows-alt"></i>Imagen</button>
		<button class="dropdown-item" onclick="subactividad_editar(0,<?php echo $idactividad; ?>,'video')"><i class="far fa-trash-alt"></i>Video</button>
		<button class="dropdown-item" onclick="subactividad_editar(0,<?php echo $idactividad; ?>,'archivo')"><i class="far fa-copy"></i>Archivo</button>
		<button class="dropdown-item" onclick="subactividad_editar(0,<?php echo $idactividad; ?>,'pregunta')"><i class="fas fa-question"></i>Pregunta</button>
	</div>
	<div class="card-body">
		agregar bloques texto context, bla
	</div>
</div>
