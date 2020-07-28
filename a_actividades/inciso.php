<?php
	require_once("db_.php");


  $id1=clean_var($_REQUEST['id1']);
  $idactividad=clean_var($_REQUEST['id2']);
  $id3=clean_var($_REQUEST['id3']);

 ?>



<form is="f-submit" id="form_id" db="lugar/file" fun="funcion_procesar" lug="lugar/file">
  <input type="hidden" name="" id="" value="">
  <div class="card">
    <div class="card-header">
      Titulo
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-12">
          <label for="">Agregue texto descriptivo a la respuesta <small>(Deje en blanco en caso de no requerir)</small></label>
          <input type="text" id="pregunta" name="" value="pregunta" class="form-control">
        </div>
      </div>
    </div>
    <div class="card-footer">
      <button type='submit' class='btn btn-warning'> Guardar</button>
      <button class="btn btn-warning" type="button" is="b-link" des='a_actividades/actividad_ver' dix='trabajo' id1="<?php echo $idactividad; ?>" cmodal="1">Regresar</button>
    </div>
  </div>
</form>
