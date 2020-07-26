<?php
	require_once("db_.php");
  $id1=clean_var($_REQUEST['id1']);
?>

<form>
  <div class="card-header">
    Nueva subactividad
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-4">
        <label for="">Nombre</label>
        <input type="text" id="nombre" name="nombre" value="" class="form-control">
      </div>
      <div class="col-4">
        <label for="">Orden</label>
        <input type="text" id="nombre" name="nombre" value="" class="form-control">
      </div>
      <div class="col-4">
        <label for="">Pagina</label>
        <input type="text" id="nombre" name="nombre" value="" class="form-control">
      </div>
    </div>
  </div>
  <div class="card-footer">
    <button type='submit' class='btn btn-warning'> Guardar</button>
    <button type='button' class='btn btn-warning'> Regresar</button>

  </div>
</form>
