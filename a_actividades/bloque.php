<?php
  $idactividad=$_REQUEST['idactividad'];
  $idsubactividad=$_REQUEST['idsubactividad'];
?>

  <div class="card">
    <div class="card-header">
      Bloque contexto
    </div>
    <div class="card-body text-center">
      <button class="btn btn-warning btn-lg" type="button" is="b-link" des="a_actividades_e/contexto_editar" v_idcontexto="0" v_idactividad="<?php echo $idactividad; ?>" v_idsubactividad="<?php echo $idsubactividad; ?>" v_tipo='imagen' omodal="1" >Imagen</button>
      <button class="btn btn-warning btn-lg" type="button" is="b-link" des="a_actividades_e/contexto_editar" v_idcontexto="0" v_idactividad="<?php echo $idactividad; ?>" v_idsubactividad="<?php echo $idsubactividad; ?>" v_tipo='texto' omodal="1">Texto</button>
      <button class="btn btn-warning btn-lg" type="button" is="b-link" des="a_actividades_e/contexto_editar" v_idcontexto="0" v_idactividad="<?php echo $idactividad; ?>" v_idsubactividad="<?php echo $idsubactividad; ?>" v_tipo='video' omodal="1">Video</button>
      <button class="btn btn-warning btn-lg" type="button" is="b-link" des="a_actividades_e/contexto_editar" v_idcontexto="0" v_idactividad="<?php echo $idactividad; ?>" v_idsubactividad="<?php echo $idsubactividad; ?>" v_tipo='archivo' omodal="1">Archivo</button>
    </div>
    <div class="card-header">
      Bloque Respuesta
    </div>
    <div class="card-body text-center">
      <button class="btn btn-warning btn-lg" type="button" is="b-link" des="a_actividades_e/contexto_editar" v_idcontexto="0" v_idactividad="<?php echo $idactividad; ?>" v_idsubactividad="<?php echo $idsubactividad; ?>" v_tipo='pregunta' omodal="1">Inciso</button>
      <button class="btn btn-warning btn-lg" type="button" is="b-link" des="a_actividades_e/contexto_editar" v_idcontexto="0" v_idactividad="<?php echo $idactividad; ?>" v_idsubactividad="<?php echo $idsubactividad; ?>" v_tipo='textores' omodal="1">Texto</button>
      <button class="btn btn-warning btn-lg" type="button" is="b-link" des="a_actividades_e/contexto_editar" v_idcontexto="0" v_idactividad="<?php echo $idactividad; ?>" v_idsubactividad="<?php echo $idsubactividad; ?>" v_tipo='fecha' omodal="1">Fecha</button>
      <button class="btn btn-warning btn-lg" type="button" is="b-link" des="a_actividades_e/contexto_editar" v_idcontexto="0" v_idactividad="<?php echo $idactividad; ?>" v_idsubactividad="<?php echo $idsubactividad; ?>" v_tipo='archivores' omodal="1">Archivo</button>
    </div>
    <div class="card-footer">
      <button class="btn btn-warning btn-lg" type="button" is="b-link" cmodal="1">Regresar</button>
    </div>
  </div>
