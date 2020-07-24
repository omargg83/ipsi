<?php
	require_once("db_.php");
	if (isset($_POST['id'])){$id=clean_var($_REQUEST['id']);} else{ $id=0;}
  $nombre="Track nuevo";
	$video="";
	$terapia="";
	$terapia_list=$db->terapias_lista();

  if($id>0){
		$pd = $db->track_editar($id);
    $nombre=$pd->nombre;
    $video=$pd->video;
    $terapia=$pd->terapia;
  }
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
				Editar Track
			</div>
			<div class='card-body'>
				<div class='row'>
					<div class="col-6">
						<label>Nombre:</label>
							<input type="text" class="form-control form-control-sm" name="nombre" id="nombre" value="<?php echo $nombre;?>" placeholder="Nombre" maxlength="100" required >
					</div>
					<div class="col-6">
						<label>Terapia:</label>
						<select name='terapia' id='terapia' class='form-control form-control-sm'>
						<?php
							foreach($terapia_list as $key){
								echo  "<option value=".$key->nombre;
								if ($key->nombre==$terapia){
									echo  " selected ";
								}
								echo  ">".$key->nombre."</option>";
							}
						?>
						</select>
					</div>
			  </div>
				<div class='row'>
					<div class="col-12">
						<label>Video:</label>
						<textarea rows="5" name='video' id='video' class="form-control form-control-sm"><?php echo $video; ?></textarea>
					</div>
			  </div>
			</div>
			<div class='card-footer'>
				<div class="row">
					<div class="col-sm-12">
						<div class="btn-group">
						<button class="btn btn-warning btn-sm" type="submit"><i class='far fa-save'></i>Guardar</button>
            <button class='btn btn-warning btn-sm' id='lista_penarea' data-lugar='a_track/lista' title='regresar'><i class='fas fa-undo-alt'></i>Regresar</button>
						</div>
					</div>
				</div>
			</div>
		</div>
  </form>
</div>
