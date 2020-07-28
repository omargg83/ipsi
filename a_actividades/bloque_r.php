<?php
	require_once("db_.php");

  $idactividad=$_REQUEST['id1'];
  $idsubactividad=$_REQUEST['id2'];

?>
<div class="container text-center">

  <p>
    Bloque respuesta
  </p>
  <p>


    <button class="btn btn-warning" type="button" is="b-link" des="a_actividades/inciso" id1="0" id2="<?php echo $idactividad; ?>" id3="<?php echo $idsubactividad; ?>" params='tipo-imagen' omodal="1" >Inciso</button>

    <button class="btn btn-warning" type="button" is="b-link" des="a_actividades/inciso" id1="0" id2="<?php echo $idactividad; ?>" id3="<?php echo $idsubactividad; ?>" params='tipo-texto' omodal="1">Texto</button>

    <button class="btn btn-warning" type="button" is="b-link" des="a_actividades/inciso" id1="0" id2="<?php echo $idactividad; ?>" id3="<?php echo $idsubactividad; ?>" params='tipo-video' omodal="1">Fecha</button>

    <button class="btn btn-warning" type="button" is="b-link" des="a_actividades/inciso" id1="0" id2="<?php echo $idactividad; ?>" id3="<?php echo $idsubactividad; ?>" params='tipo-archivo' omodal="1">Archivo</button>



    <button class='btn btn-warning' type='button' is='b-link' des='a_actividades/actividad_ver' cmodal="1">Regresar</button>
  </p>
</div>
