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
			<div class="col-2">
				<button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_actividades/actividad_editar" dix="trabajo" id1="<?php echo $idactividad; ?>">Editar</button>
			</div>
			<div class="col-9 text-left">Actividad: <?php echo $nombre; ?>
			</div>
			<div class="col-1">
				<button class="btn btn-warning float-right mr-1" type="button" is="b-link" des="a_actividades/lista" dix="trabajo" id1="">Regresar</button>
			</div>
		</div>
	</div>

	<div class='card-body'>
		<p>Indicaciones</p>
		<?php echo $indicaciones; ?>
	</div>
</div>

<div class="container-fluid mb-3 text-center">
	<button class='btn btn-warning' type="button" is="b-link" des='a_actividades/subactividad_editar' dix='nueva_sub' tp="edit" id1="0" id2='<?php echo $idactividad; ?>' title='editar' omodal="1">Nueva Subactividad</button>
</div>

<?php
	foreach($subactividad as $key){
?>
	<div class="container-fluid mb-4" id="sub_<?php echo $key->idsubactividad; ?>">
		<div class="card" >
		<div class="card-header">
			<div class="row">
				<div class="col-2">
					<button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_actividades/subactividad_editar" dix="sub_<?php echo $key->idsubactividad; ?>" id1="<?php echo $key->idsubactividad; ?>" id2='<?php echo $idactividad; ?>' omodal="1">Editar</button>
				</div>
				<div class="col-10">
					<?php echo $key->orden; ?>- Subactividad: <?php echo $key->nombre; ?>
				</div>
			</div>
		</div>

		<div class="card-body" id='bloque'>
			<div class="container-fluid mb-3 text-center">
				<button class="btn btn-warning" type="button" is="b-link" des="a_actividades/bloque" dix="sub_<?php echo $key->idsubactividad; ?>" id1="<?php echo $idactividad; ?>" id2="<?php echo $key->idsubactividad; ?>" id3="texto" params='tipo-imagen' omodal="1" >Bloque de contexto</button>
			</div>
			<?php
				$bloq=$db->contexto_ver($key->idsubactividad);
				foreach($bloq as $row){
			?>
				<div class="card mb-4">
					<div class="card-header">
						<div class='row'>
							<div class="col-6 text-center">
								Contexto
							</div>
							<div class="col-6">
								<button class="btn btn-warning" type="button" is="b-link" des="a_actividades/contexto_editar" dix="sub_<?php echo $key->idsubactividad; ?>" id1="<?php echo $row->id; ?>" omodal="1">Editar</button>

								<button class="btn btn-warning btn-sm" ><i class="fas fa-arrows-alt"></i>Mover</button>
								<button class="btn btn-warning btn-sm" onclick='eliminar_subact(<?php echo $key->idsubactividad; ?>)' ><i class="far fa-trash-alt"></i>Eliminar</button>
								<button class="btn btn-warning btn-sm" ><i class="far fa-copy"></i>Duplicar</button>
								<button class="btn btn-warning btn-sm" ><i class="fas fa-project-diagram"></i>Condicional</button>
							</div>
						</div>
					</div>
					<div class="card-body">
						<div>
							<?php	echo $row->observaciones; ?>
						</div>
						<div>
							<?php	echo $row->texto; ?>
						</div>

						<hr>
						<div class="container-fluid mb-3 text-center">
							<button class="btn btn-warning" type="button" is="b-link" des="a_actividades/bloque_r" id1="" id2="<?php echo $row->id; ?>" id2="<?php echo $row->id; ?>" id3="<?php echo $idactividad; ?>" params='tipo-imagen' omodal="1" >Bloque de respuesta</button>
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


			</div>

			<?php
				}
			?>
		</div>
	</div>
	</div>

<?php
	}
 ?>
