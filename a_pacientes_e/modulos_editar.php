<?php
	require_once("../a_actividades/db_.php");
  $idmodulo=$_REQUEST['id1'];
  $idtrack=$_REQUEST['id2'];

	$track=$db->track_editar($idtrack);
  $terapia=$db->terapia_editar($track->idterapia);
	$idterapia=$terapia->id;


  $nombre="Nuevo modulo";
	$descripcion="";
	if($idmodulo>0){
		$modulo=$db->modulo_editar($idmodulo);
		$nombre=$modulo->nombre;
		$descripcion=$modulo->descripcion;
	}
?>

<nav aria-label='breadcrumb'>
  <ol class='breadcrumb'>
    <li class="breadcrumb-item" type="button" is="li-link" des="a_actividades/terapias" dix="trabajo" title="Terapias" id1="">Terapias</li>
    <li class="breadcrumb-item" type="button" is="li-link" des="a_actividades/track" dix="trabajo" title="Track" id1="<?php echo $terapia->id; ?>"><?php echo $terapia->nombre; ?></li>
    <li class="breadcrumb-item" type="button" is="li-link" des="a_actividades/modulos" dix="trabajo" title="Modulos" id1="<?php echo $track->id; ?>"><?php echo $track->nombre; ?></li>
    <li class='breadcrumb-item active' aria-current='page'><?php echo $nombre; ?></li>
  </ol>
</nav>


<div class="container">
	<form is="f-submit" id="form_terapia" db="a_actividades/db_" fun="guardar_modulo">
    <input type="hidden" name="id1" id="id1" value="<?php echo $idmodulo;?>">
    <input type="hidden" name="idtrack" id="idtrack" value="<?php echo $idtrack;?>">
    <div class='card'>
			<div class='card-header'>
				Editar Modulo
			</div>
			<div class='card-body'>
				<div class='row'>
					<div class="col-12">
						<label>Nombre:</label>
						<input type="text" class="form-control form-control-sm" name="nombre" id="nombre" value="<?php echo $nombre;?>" placeholder="Nombre" maxlength="100" required >
					</div>
					<div class="col-12">
						<label>Descripción:</label>
						<textarea name="descripcion" id="descripcion" rows="8" cols="80" placeholder="Descripción" class="form-control"><?php echo $descripcion;?></textarea>
					</div>
			  </div>

			</div>
			<div class='card-footer'>
				<div class="row">
					<div class="col-sm-12">
						<button class="btn btn-warning" type="submit">Guardar</button>
						<button class="btn btn-warning" type="button" is="b-link" des='a_actividades/modulos' id1="<?php echo $idtrack; ?>" dix='trabajo'>Regresar</button>
					</div>
				</div>
			</div>
		</div>
  </form>
</div>
