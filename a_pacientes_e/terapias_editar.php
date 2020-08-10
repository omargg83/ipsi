<?php
	require_once("../a_actividades/db_.php");
	if (isset($_POST['id1'])){$id1=clean_var($_REQUEST['id1']);} else{ $id1=0;}
  $nombre="Terapia nueva";
  $descripcion="";
  if($id1>0){
		$pd = $db->terapia_editar($id1);
    $nombre=$pd->nombre;
    $descripcion=$pd->descripcion;
  }
?>

<nav aria-label='breadcrumb'>
  <ol class='breadcrumb'>
    <li class="breadcrumb-item" type="button" is="li-link" des="a_actividades/terapias" dix="trabajo" id1="">Terapias</li>
    <li class='breadcrumb-item active' aria-current='page'><?php echo $nombre; ?></li>
  </ol>
</nav>

<div class="container">
	<form is="f-submit" id="form_terapia" db="a_actividades/db_" fun="guardar_terapia">
    <input type="hidden" name="id1" id="id1" value="<?php echo $id1;?>">
    <div class='card'>
			<div class='card-header'>
				Editar Terapia
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
						<button class="btn btn-warning" type="button" is="b-link" des='a_actividades/terapias' dix='trabajo'>Regresar</button>
					</div>
				</div>
			</div>
		</div>
  </form>
</div>
