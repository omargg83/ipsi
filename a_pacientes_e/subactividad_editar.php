<?php
	require_once("../a_pacientes/db_.php");
  $idsubactividad=clean_var($_REQUEST['idsubactividad']);
  $idactividad=clean_var($_REQUEST['idactividad']);
  $idpaciente=clean_var($_REQUEST['idpaciente']);

	$nombre="";
	$orden="";
	$pagina="";
	if($idsubactividad){
		$res=$db->subactividad_editar($idsubactividad);
		$nombre=$res->nombre;
		$orden=$res->orden;
		$pagina=$res->pagina;
	}
?>

<form is="f-submit" id="form_sub" db="a_pacientes/db_" fun="subactividad_guardar" lug="a_pacientes/actividad_ver" v_idactividad="<?php echo $idactividad; ?>" v_idpaciente="<?php echo $idpaciente; ?>" dix="trabajo" cmodal="1">
  <input type="hidden" name="id1" id="id1" value="<?php  echo $idsubactividad; ?>">
  <input type="hidden" name="id2" id="id2" value="<?php  echo $idactividad; ?>">
	<div class="card">
	  <div class="card-header">
	    Nueva subactividad
	  </div>
	  <div class="card-body">
	    <div class="row">
	      <div class="col-8">
	        <label for="">Nombre</label>
	        <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>" class="form-control" required>
	      </div>
	      <div class="col-2">
	        <label for="">Orden</label>
	        <input type="text" id="orden" name="orden" value="<?php echo $orden; ?>" class="form-control">
	      </div>
	      <div class="col-2">
	        <label for="">Pagina</label>
	        <input type="text" id="pagina" name="pagina" value="<?php echo $pagina; ?>" class="form-control">
	      </div>
	    </div>
	  </div>
	  <div class="card-footer">
	    <button type='submit' class='btn btn-warning'> Guardar</button>
	    <button class="btn btn-warning" type="button" is="b-link" cmodal="1">Regresar</button>
	  </div>
  </div>
</form>
