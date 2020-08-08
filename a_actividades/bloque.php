<?php
  $idactividad=$_REQUEST['id1'];
  $idsubactividad=$_REQUEST['id2'];
?>

  <div class="card">
    <div class="card-header">
      Bloque contexto
    </div>
    <div class="card-body text-center">
      <button class="btn btn-warning btn-lg" type="button" is="b-link" des="a_actividades_e/contexto_editar" id1="0" id2="<?php echo $idactividad; ?>" id3="<?php echo $idsubactividad; ?>" params='tipo-imagen' omodal="1" >Imagen</button>
      <button class="btn btn-warning btn-lg" type="button" is="b-link" des="a_actividades_e/contexto_editar" id1="0" id2="<?php echo $idactividad; ?>" id3="<?php echo $idsubactividad; ?>" params='tipo-texto' omodal="1">Texto</button>
      <button class="btn btn-warning btn-lg" type="button" is="b-link" des="a_actividades_e/contexto_editar" id1="0" id2="<?php echo $idactividad; ?>" id3="<?php echo $idsubactividad; ?>" params='tipo-video' omodal="1">Video</button>
      <button class="btn btn-warning btn-lg" type="button" is="b-link" des="a_actividades_e/contexto_editar" id1="0" id2="<?php echo $idactividad; ?>" id3="<?php echo $idsubactividad; ?>" params='tipo-archivo' omodal="1">Archivo</button>
    </div>
    <div class="card-header">
      Bloque Respuesta
    </div>
    <div class="card-body text-center">
      <button class="btn btn-warning btn-lg" type="button" is="b-link" des="a_actividades_e/contexto_editar" id1="0" id2="<?php echo $idactividad; ?>" id3="<?php echo $idsubactividad; ?>" params='tipo-pregunta' omodal="1">Inciso</button>
      <button class="btn btn-warning btn-lg" type="button" is="b-link" des="a_actividades_e/contexto_editar" id1="0" id2="<?php echo $idactividad; ?>" id3="<?php echo $idsubactividad; ?>" params='tipo-textores' omodal="1">Texto</button>
      <button class="btn btn-warning btn-lg" type="button" is="b-link" des="a_actividades_e/contexto_editar" id1="0" id2="<?php echo $idactividad; ?>" id3="<?php echo $idsubactividad; ?>" params='tipo-fecha' omodal="1">Fecha</button>
      <button class="btn btn-warning btn-lg" type="button" is="b-link" des="a_actividades_e/contexto_editar" id1="0" id2="<?php echo $idactividad; ?>" id3="<?php echo $idsubactividad; ?>" params='tipo-archivores' omodal="1">Archivo</button>
    </div>
    <div class="card-footer">
      <button class="btn btn-warning btn-lg" type="button" is="b-link" des="a_actividades/actividad_ver" cmodal="1">Regresar</button>
    </div>
  </div>
