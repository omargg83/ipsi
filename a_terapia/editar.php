<?php
	require_once("db_.php");
	if (isset($_POST['id'])){$id=clean_var($_REQUEST['id']);} else{ $id=0;}
  $nombre="Terapia nueva";
  if($id>0){
		$pd = $db->terapia_editar($id);
    $nombre=$pd->nombre;
  }
?>

<nav aria-label='breadcrumb'>
  <ol class='breadcrumb'>
    <li class='breadcrumb-item' id='lista_pacientes' data-lugar='a_terapia/lista'>Terapias</li>
    <li class='breadcrumb-item active' aria-current='page'><?php echo $nombre; ?></li>
  </ol>
</nav>

<div class="container">
	<form is="f-submit" id="form_terapia" lug="a_terapia/db_" fun="guardar_terapia" des='a_terapia/editar'>
    <input type="hidden" name="id" id="id" value="<?php echo $id;?>">
    <div class='card'>
			<div class='card-header'>
				Editar Terapia
			</div>
			<div class='card-body'>
				<div class='row'>
					<div class="col-6">
						<label>Nombre:</label>
							<input type="text" class="form-control form-control-sm" name="nombre" id="nombre" value="<?php echo $nombre;?>" placeholder="Nombre" maxlength="100" required >
					</div>
			  </div>

			</div>
			<div class='card-footer'>
				<div class="row">
					<div class="col-sm-12">

						<button class="btn btn-warning" type="submit">Guardar</button>
						<button class="btn btn-warning" type="button" is="b-link" lug='a_terapia/lista' des='trabajo' id="<?php echo $key->id; ?>" >Regresar</button>



					</div>
				</div>
			</div>
		</div>
  </form>
</div>
