<?php
	require_once("db_.php");
  $id1=clean_var($_REQUEST['id1']);
  $idactividad=clean_var($_REQUEST['id2']);

	$nombre="";
	$orden="";
	$pagina="";
	if($id1){
		$res=$db->subactividad_editar($id1);
		$nombre=$res->nombre;
		$orden=$res->orden;
		$pagina=$res->pagina;
	}
?>


<form is="f-submit" id="form_sub" db="a_actividades/db_" fun="subactividad_guardar" lug="a_actividades/editar">
  <input type="hidden" name="id1" id="id1" value="<?php  echo $id1; ?>">
  <input type="hidden" name="id2" id="id2" value="<?php  echo $idactividad; ?>">
	<div class="card">
	  <div class="card-header">
	    Nueva subactividad
	  </div>
	  <div class="card-body">
	    <div class="row">
	      <div class="col-4">
	        <label for="">Nombre</label>
	        <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>" class="form-control" required>
	      </div>
	      <div class="col-4">
	        <label for="">Orden</label>
	        <input type="text" id="orden" name="orden" value="<?php echo $orden; ?>" class="form-control">
	      </div>
	      <div class="col-4">
	        <label for="">Pagina</label>
	        <input type="text" id="nombre" name="nombre" value="<?php echo $pagina; ?>" class="form-control">
	      </div>
	    </div>
	  </div>
	  <div class="card-footer">
	    <button type='submit' class='btn btn-warning'> Guardar</button>
	    <button class="btn btn-warning" type="button" is="b-link" des='a_actividades/actividad_ver' dix='trabajo' id1="<?php echo $idactividad; ?>">Regresar</button>
	  </div>
  </div>
</form>
