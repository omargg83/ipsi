<?php
	require_once("db_.php");

  $id1=clean_var($_REQUEST['id1']);
  $buscar=clean_var($_REQUEST['terapia_b']);
  $buscar=$db->buscar_actividad($buscar);

  foreach($buscar as $key){
    echo "<div class='row'>";
    echo "<div class='col-2'>";
      echo "<div class='btn-group'>";
      echo "<button class='btn btn-warning' type='button' is='b-link' des='a_pacientes/paciente' tp='proceso' id1='$id1' id2='$key->idactividad' db='a_pacientes/db_' fun='agregar_actividad' cmodal='2'>Seleccionar</button>";
      echo  "</div>";
    echo "</div>";
    echo "<div class='col-8'>";
    echo $key->nombre;
    echo "</div>";
    echo "</div>";
  }

?>
