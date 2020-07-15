<?php
	require_once("db_.php");
	if (isset($_POST['id'])){$id=clean_var($_REQUEST['id']);} else{ $id=0;}

	$pd = $db->track_editar($id);
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
    <input type="hidden" name="id" id="id" value="<?php echo $id;?>">
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
            	<button class='btn btn-sm' id='lista_penarea' data-lugar='a_track/lista' title='regresar'><i class='fas fa-undo-alt'></i>Regresar</button>
						</div>
					</div>
				</div>
			</div>
		</div>
  </form>
</div>
