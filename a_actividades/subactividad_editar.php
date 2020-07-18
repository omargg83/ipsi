<?php
	require_once("db_.php");

  $id=clean_var($_REQUEST['id']);
  $idactividad=clean_var($_REQUEST['idactividad']);
  $tipo=clean_var($_REQUEST['tipo']);


?>
<div class="card">
  <div class="card-header">
    Subactividad
  </div>
  <div class="card-body">
    <?php
    if($tipo=="texto"){
    ?>
    <textarea>aqui va el texto</textarea>
    <?php
    }
    else if($tipo=="imagen"){
    ?>
    aqui va la imagen
    <?php
    }
    else if($tipo=="video"){
    ?>
    aqui va el video
    <?php
    }
    else if($tipo=="archivo"){
    ?>
    aqui va el archivo
    <?php
    }
    else{
    ?>

    aqui nada
    <?php
    }
    ?>
  </div>
  <div class="card-footer">
    <button type='submit' class='btn btn-warning '><i class='far fa-save'></i> Guardar</button>
  </div>

</div>
