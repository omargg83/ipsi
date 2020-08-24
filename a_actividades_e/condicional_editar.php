<?php
	require_once("../a_actividades/db_.php");
  $idactividad=$_REQUEST['idactividad'];
  echo $idactividad;
  $sql="select * from ";
 ?>
 <div class="card">
   <div class="card-header">
     Condicional
   </div>
   <div class="card-body">
   </div>
   <div class="card-footer">
     <button class="btn btn-warning" type="button" is="b-link" des='a_actividades/actividad_ver' dix='trabajo' id1="<?php echo $idactividad; ?>" cmodal="1">Regresar</button>
   </div>
 </div>
