<?php
	require_once("db_.php");

  $idactividad=$_REQUEST['id1'];
  $idsubactividad=$_REQUEST['id2'];

?>
<div class="container text-center">

  <p>
    Bloque contexto
  </p>
  <p>

    <button class="btn btn-warning btn-lg" type="button" is="b-link" des="a_actividades/contexto_editar" id1="0" id2="<?php echo $idactividad; ?>" id3="<?php echo $idsubactividad; ?>" params='tipo-imagen' omodal="1" >Imagen</button>
    <button class="btn btn-warning btn-lg" type="button" is="b-link" des="a_actividades/contexto_editar" id1="0" id2="<?php echo $idactividad; ?>" id3="<?php echo $idsubactividad; ?>" params='tipo-texto' omodal="1">Texto</button>
    <button class="btn btn-warning btn-lg" type="button" is="b-link" des="a_actividades/contexto_editar" id1="0" id2="<?php echo $idactividad; ?>" id3="<?php echo $idsubactividad; ?>" params='tipo-video' omodal="1">Video</button>
    <button class="btn btn-warning btn-lg" type="button" is="b-link" des="a_actividades/contexto_editar" id1="0" id2="<?php echo $idactividad; ?>" id3="<?php echo $idsubactividad; ?>" params='tipo-archivo' omodal="1">Archivo</button>
    <button class="btn btn-warning btn-lg" type="button" is="b-link" des="a_actividades/contexto_editar" id1="0" id2="<?php echo $idactividad; ?>" id3="<?php echo $idsubactividad; ?>" params='tipo-pregunta' omodal="1">Pregunta</button>
    <button class="btn btn-warning btn-lg" type="button" is="b-link" des="a_actividades/actividad_ver" cmodal="1">Regresar</button>
  </p>
</div>
