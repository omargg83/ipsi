<?php
  require_once("db_.php");
  $idsubactividad=$_REQUEST['idsubactividad'];
  $idactividad=$_REQUEST['idactividad'];
  $idrespuesta=$_REQUEST['idrespuesta'];

  //echo "$idrespuesta   $idactividad  $idactividad";
 ?>
<form>
 <div class="row">
   <div class="col-4">
     <label>Inciso</label>
     <input type="text" name="inciso" id="inciso" value="" class="form-control">
   </div>
   <div class="col-4">
     <label>Imagen</label>
     <div class="custom-file">
       <label class="custom-file-label" for="customFile">Imagen</label>
       <input type="file" name="imagen" id="imagen" value="" class="custom-file-input">
     </div>
   </div>
 </div>
 <div class="row">
   <div class="col-12">
     <button type='submit' class='btn btn-warning'><i class='far fa-save'></i> Guardar</button>
   </div>
 </div>
</form>
