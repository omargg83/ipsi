<?php
	require_once("db_.php");
	if (isset($_POST['id1'])){$id1=clean_var($_REQUEST['id1']);} else{ $id1=0;}

	$pd = $db->track_editar($id1);
  $nombre=$pd->nombre;
  $video=$pd->video;
  $terapia=$pd->terapia;
?>

<nav aria-label='breadcrumb'>
  <ol class='breadcrumb'>
    <li class='breadcrumb-item' id='lista_pacientes' data-lugar='a_track/lista'>Track</li>
    <li class='breadcrumb-item active' aria-current='page'><?php echo $nombre; ?></li>
  </ol>
</nav>

<div class="container">
	<form action="" id="form_terapia" data-lugar="a_track/db_" data-funcion="guardar_track" data-destino='a_track/editar'>
    <input type="hidden" name="id1" id="id1" value="<?php echo $id1;?>">
    <div class='card'>
			<div class='card-header'>
				<?php echo "Terapia ".$terapia."/".$nombre;?>
			</div>
			<div class='card-body'>
				<div class='row'>
					<div class="col-12 text-center">
						<?php echo $video; ?>
					</div>
			  </div>
			</div>
			<div class='card-footer'>
				<div class="row">
					<div class="col-sm-12">
						<div class="btn-group">
							<button class="btn btn-warning" type="button" is="b-link" des='a_track/lista' dix='trabajo'>Regresar</button>
						</div>
					</div>
				</div>
			</div>
		</div>
  </form>
</div>
