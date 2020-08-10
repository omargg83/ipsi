<?php
  require_once("../a_actividades/db_.php");
  $id=$_REQUEST['id'];
  $idactividad=$_REQUEST['idactividad'];
  $idsubactividad=$_REQUEST['idsubactividad'];
  $respuesta="";
  $orden="";

  if($id>0){
    $resp=$db->respuestas_editar($id);
    $respuesta=$resp->respuesta;
    $orden=$resp->orden;
  }
 ?>
<form id='form_res' action='' data-lugar='a_actividades/db_'  data-funcion='guarda_respuesta'>
  <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
  <input type="hidden" name="idactividad" id="idactividad" value="<?php echo $idactividad; ?>">
  <input type="hidden" name="idsubactividad" id="idsubactividad" value="<?php echo $idsubactividad; ?>">
 <div class="row">
   <div class="col-2">
     <label>Orden</label>
     <input type="text" name="orden" id="orden" value="<?php echo $orden; ?>" class="form-control">
   </div>

   <div class="col-4">
     <label>Inciso</label>
     <input type="text" name="respuesta" id="respuesta" value="<?php echo $respuesta; ?>" class="form-control">
   </div>

   <div class="col-4">
     <label>Imagen</label>
     <div class="custom-file">
       <input type="file" name="imagen" id="imagen" value="" class="custom-file-input">
       <label class="custom-file-label" for="imagen">Imagen</label>
     </div>
   </div>
 </div>
 <div class="row">
   <div class="col-12">
     <button type='submit' class='btn btn-warning'><i class='far fa-save'></i> Guardar</button>
     <button type='button' class='btn btn-warning' onclick="subactividad_ver(<?php echo $idsubactividad; ?>,0,0)"><i class="fas fa-undo-alt"></i> Regresar</button>
   </div>
 </div>
</form>
