<?php
	require_once("db_.php");
	$idmodulo=$_REQUEST['idmodulo'];

	$modulo=$db->modulo_editar($idmodulo);
	$track=$db->track_editar($modulo->idtrack);
	$terapia=$db->terapia_editar($track->idterapia);
	$pd = $db->actividad_lista($idmodulo);
?>

<nav aria-label='breadcrumb'>
	<ol class='breadcrumb'>
		<li class="breadcrumb-item" type="button" is="li-link" des="a_actividades/terapias" dix="trabajo" id1="">Inicio</lis>
		<li class="breadcrumb-item" type="button" is="li-link" des="a_actividades/track" dix="trabajo" title="Track" v_idterapia="<?php echo $terapia->id; ?>"><?php echo $terapia->nombre; ?></li>
		<li class="breadcrumb-item" type="button" is="li-link" des="a_actividades/modulos" dix="trabajo" v_idtrack="<?php echo $track->id; ?>" ><?php echo $track->nombre; ?></li>
		<li class="breadcrumb-item active" type="button" is="li-link" des="a_actividades/actividades" dix="trabajo" v_idmodulo="<?php echo $modulo->id; ?>" ><?php echo $modulo->nombre; ?></li>
		<button class="btn btn-warning btn-sm" type="button" is="b-link" des="a_actividades/modulos" dix="trabajo" v_idtrack="<?php echo $track->id; ?>">Regresar</button>
	</ol>
</nav>

<div class="alert alert-warning text-center tituloventana" role="alert">
	Actividades

</div>

<div class='container'>
	<div class='row'>


	<?php
		foreach($pd as $key){
	?>
<div id='<?php echo $key->idactividad; ?>' class='col-4 p-3 w-50 actcard'>
				<div class='card'>
				<img style="vertical-align: bottom;border-radius: 10px;max-width: 70px;margin: 0 auto;padding: 10px;" src="img/lapiz.png">
					<div class='card-header'>
						<?php
							echo "<div class='row'>";
								echo "<div class='col-12'>";
									echo $key->nombre;
								echo "</div>";
							echo "</div>";
							echo "<div class='row justify-content-end'>";
								echo "<div class='col-5'>";

									echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades_e/actividad_editar' dix='trabajo' v_idactividad='$key->idactividad' v_idmodulo='$idmodulo' v_origen='actividades'><i class='fas fa-pencil-alt'></i></button>";

									echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' db='a_actividades/db_' fun='actividad_duplicar' v_idactividad='$key->idactividad' v_idmodulo='$idmodulo' des='a_actividades/actividades' tp='¿Desea duplicar la actividad seleccionada?' title='Duplicar' dix='trabajo'><i class='far fa-clone'></i></button>";

									echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_actividades/actividades' dix='trabajo' db='a_actividades/db_' fun='borrar_actividad' v_idactividad='$key->idactividad' v_idmodulo='$idmodulo' tp='¿Desea eliminar la actividad seleccionada?' title='Borrar'><i class='far fa-trash-alt'></i></button>";

								echo "</div>";
							echo "</div>";
						?>
					</div>
					<div class='card-body'>
						<div class='row'>
							<div class='col-12'>
								<?php echo $key->observaciones; ?>
							</div>
						</div>
					</div>
					<div class='card-footer'>
						<div class='row'>
							<div class='col-12'>
								<button class="btn btn-warning btn-block" type="button" is="b-link" des="a_actividades/actividad_ver" dix="trabajo" v_idactividad="<?php echo $key->idactividad; ?>" >Ver</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php
		}
		?>
		<div id='' class='col-4 p-3 w-50'>
			<div class="card" style='height:200px;'>
				<div class='card-body text-center'>
					<button class="btn btn-warning btn-block" type="button" is="b-link" des="a_actividades_e/actividad_editar" dix="trabajo" v_idactividad="0" v_idmodulo="<?php echo $idmodulo; ?>" >Nueva actividad</button>
				</div>
			</div>
		</div>
	</div>
</div>
