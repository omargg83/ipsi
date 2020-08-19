<?php
	require_once("../a_actividades/db_.php");

	$idtrack=clean_var($_REQUEST['idtrack']);
	$idterapia=clean_var($_REQUEST['idterapia']);
  $terapia=$db->terapia_editar($idterapia);

  $nombre="Track nuevo";
	$video="";
	$descripcion="";

  if($idtrack>0){
		$pd = $db->track_editar($idtrack);
    $nombre=$pd->nombre;
    $video=$pd->video;
    $descripcion=$pd->descripcion;
  }


	echo "idterapia:".$idterapia;
?>

<nav aria-label='breadcrumb'>
  <ol class='breadcrumb'>
    <li class="breadcrumb-item" type="button" is="li-link" des="a_actividades/terapias" dix="trabajo" title="Terapias" id1="">Terapias</li>
    <li class="breadcrumb-item" type="button" is="li-link" des="a_actividades/track" dix="trabajo" title="Track" v_idterapia="<?php echo $idterapia; ?>"><?php echo $terapia->nombre; ?></li>
    <li class='breadcrumb-item active' is="li-link" des="a_actividades_e/track_editar" dix="trabajo" title="Track" v_idtrack="<?php echo $idtrack; ?>" v_idterapia="<?php echo $idterapia; ?>" ><?php echo $nombre; ?></li>
  </ol>
</nav>


<div class="container">
	<form is="f-submit" id="form_track" db="a_actividades/db_" fun="guardar_track">
    <input type="hidden" name="idtrack" id="idtrack" value="<?php echo $idtrack;?>">
    <input type="hidden" name="idterapia" id="idterapia" value="<?php echo $idterapia;?>">
    <div class='card'>
			<div class='card-header'>
				Editar Track
			</div>
			<div class='card-body'>
				<div class='row'>
					<div class="col-12">
						<label>Nombre:</label>
							<input type="text" class="form-control form-control-sm" name="nombre" id="nombre" value="<?php echo $nombre;?>" placeholder="Nombre" maxlength="100" required >
					</div>
					<div class="col-12">
						<label>Descripción:</label>
            <textarea rows="5" name='descripcion' id='descripcion' class="form-control form-control-sm"><?php echo $descripcion; ?></textarea>
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
						<button class="btn btn-warning" type="submit">Guardar</button>
            <button class="btn btn-warning" type="button" is="b-link" des='a_actividades/track' v_idterapia="<?php echo $idterapia; ?>" dix='trabajo'>Regresar</button>
					</div>
				</div>
			</div>
		</div>
  </form>
</div>
