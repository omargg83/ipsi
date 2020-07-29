<?php
	require_once("db_.php");
  $id1=clean_var($_REQUEST['id1']);
  $idactividad=clean_var($_REQUEST['id2']);
  $idsubactividad=clean_var($_REQUEST['id3']);
	$tipo=clean_var($_REQUEST['tipo']);

	echo "<br>id1:".$id1;
	echo "<br>idactividad:".$idactividad;
	echo "<br>idsubactividad:".$idsubactividad;
	echo "<br>tipo:".$tipo;

?>


<form is="f-submit" id="form_inciso" db="a_actividades/db_" fun="guarda_inciso" lug="a_actividades/actividad_ver" iddest="<?php echo $idactividad; ?>" cmodal="1">
  <input type="text" name="id1" id="id1" value="<?php echo $id1; ?>">
  <input type="text" name="tipo" id="tipo" value="<?php echo $tipo; ?>">
  <input type="text" name="idsubactividad" id="idsubactividad" value="<?php echo $idsubactividad; ?>">

  <div class="card">
    <div class="card-header">
      Titulo
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-12">
          <label for="">Agregue texto descriptivo a la respuesta <small>(Deje en blanco en caso de no requerir)</small></label>
          <input type="text" id="pregunta" name="pregunta" value="" class="form-control">
        </div>
      </div>
    </div>
    <div class="card-footer">
      <button type='submit' class='btn btn-warning'> Guardar</button>
      <button class="btn btn-warning" type="button" is="b-link" des='a_actividades/actividad_ver' dix='trabajo' id1="<?php echo $idactividad; ?>" cmodal="1">Regresar</button>
    </div>
  </div>
</form>
