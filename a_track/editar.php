<?php
	require_once("db_.php");
	if (isset($_POST['id1'])){$id1=clean_var($_REQUEST['id1']);} else{ $id1=0;}
  $nombre="Track nuevo";
	$video="";
	$terapia="";
	$terapia_list=$db->terapias_lista();

  if($id1>0){
		$pd = $db->track_editar($id1);
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
	<form is="f-submit" id="form_track" db="a_track/db_" fun="guardar_track" lug='a_track/editar'>
    <input type="hidden" name="id1" id="id1" value="<?php echo $id1;?>">
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
						<button class="btn btn-warning" type="submit">Guardar</button>
						<button class="btn btn-warning" type="button" is="b-link" des='a_track/lista' dix='trabajo'>Regresar</button>
						</div>
					</div>
				</div>
			</div>
		</div>
  </form>
</div>
