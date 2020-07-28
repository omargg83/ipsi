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
			<div class="col-6">
				Actividad: <?php echo $nombre; ?>
			</div>
			<div class="col-6">
				<button class="btn btn-warning float-right mr-1" type="button" is="b-link" des="a_actividades/lista" dix="trabajo" id1="">Regresar</button>
				<button class="btn btn-warning float-right mr-1" type="button" is="b-link" des="a_actividades/actividad_editar" dix="trabajo" id1="<?php echo $idactividad; ?>">Editar</button>
			</div>
		</div>
	</div>

	<div class='card-body'>
		<p>Indicaciones</p>
		<?php echo $indicaciones; ?>
	</div>
</div>

<div class="container-fluid mb-3 text-center" id='nueva_sub'>
	<button class='btn btn-warning' type="button" is="b-link" des='a_actividades/subactividad_editar' dix='trabajo' tp="edit" id1="0" id2='<?php echo $idactividad; ?>' title='editar'>Nueva Subactividad</button>
</div>

<?php
	foreach($subactividad as $key){
?>
<div class="card mb-4" id="sub_<?php echo $key->idsubactividad; ?>">
	<div class="card-header">
		<div class="row">
			<div class="col-6">
				<?php echo $key->orden; ?>- Subactividad: <?php echo $key->nombre; ?>
			</div>
			<div class="col-6">

				<button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_actividades/subactividad_editar" dix="trabajo" id1="<?php echo $key->idsubactividad; ?>" id2='<?php echo $idactividad; ?>'>Editar</button>
				<button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_actividades/contexto_editar" dix="trabajo" id1="0" id2="<?php echo $idactividad; ?>" id3="<?php echo $key->idsubactividad; ?>" id3="texto" params='tipo-imagen'>Imagen</button>
				<button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_actividades/contexto_editar" dix="trabajo" id1="0" id2="<?php echo $idactividad; ?>" id3="<?php echo $key->idsubactividad; ?>" id3="texto" params='tipo-texto'>Texto</button>
				<button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_actividades/contexto_editar" dix="trabajo" id1="0" id2="<?php echo $idactividad; ?>" id3="<?php echo $key->idsubactividad; ?>" id3="texto" params='tipo-video'>Video</button>
				<button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_actividades/contexto_editar" dix="trabajo" id1="0" id2="<?php echo $idactividad; ?>" id3="<?php echo $key->idsubactividad; ?>" id3="texto" params='tipo-archivo'>Archivo</button>
				<button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_actividades/contexto_editar" dix="trabajo" id1="0" id2="<?php echo $idactividad; ?>" id3="<?php echo $key->idsubactividad; ?>" id3="texto" params='tipo-pregunta'>Pregunta</button>

			</div>
		</div>
	</div>

	<div class="card-body" id='bloque'>
		<?php
			$bloq=$db->contexto_editar($key->idsubactividad);
			foreach($bloq as $row){
		?>
			<div class="card mb-4">
				<div class="card-header">
					<div class='row'>
						<div class="col-6 text-center">
							Actividad
						</div>
						<div class="col-6">
							<button class="btn btn-warning btn-sm" onclick="subactividad_ver(<?php echo $key->idsubactividad; ?>,0,0)"><i class="far fa-eye"></i>Ver</button>
							<button class="btn btn-warning btn-sm" onclick="subactividad_editar(<?php echo $key->idsubactividad; ?>,0,0)"><i class='fas fa-pencil-alt'></i>Editar</button>
							<button class="btn btn-warning btn-sm" ><i class="fas fa-arrows-alt"></i>Mover</button>
							<button class="btn btn-warning btn-sm" onclick='eliminar_subact(<?php echo $key->idsubactividad; ?>)' ><i class="far fa-trash-alt"></i>Eliminar</button>
							<button class="btn btn-warning btn-sm" ><i class="far fa-copy"></i>Duplicar</button>
							<button class="btn btn-warning btn-sm" ><i class="fas fa-project-diagram"></i>Condicional</button>
						</div>
					</div>
				</div>
				<div class="card-body">
					<?php	echo $row->texto; ?>
				</div>
				<div class="card-header">
						respuesta
				</div>
				<div class="card-body">
						<div class="card-body">
							<input type="radio" name="" value="">1
							<input type="radio" name="" value="">2
							<input type="radio" name="" value="">3
						</div>
				</div>
		</div>

		<?php
			}
		?>
	</div>
</div>

<?php
	}
 ?>
