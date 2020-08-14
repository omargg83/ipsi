<?php
  $idactividad=$_REQUEST['idactividad'];
  $idsubactividad=$_REQUEST['idsubactividad'];
  $idpaciente=$_REQUEST['idpaciente'];
?>

  <div class="card">
    <div class="card-header">
      Bloque contexto
    </div>
    <div class="card-body text-center">
      <button class="btn btn-warning btn-lg" type="button" is="b-link" des="a_pacientes_e/contexto_editar" v_idcontexto="0" v_idactividad="<?php echo $idactividad; ?>" v_idsubactividad="<?php echo $idsubactividad; ?>" v_tipo='imagen' v_idpaciente="<?php echo $idpaciente; ?>" omodal="1" >Imagen</button>

      <button class="btn btn-warning btn-lg" type="button" is="b-link" des="a_pacientes_e/contexto_editar" v_idcontexto="0" v_idactividad="<?php echo $idactividad; ?>" v_idsubactividad="<?php echo $idsubactividad; ?>" v_tipo='texto' v_idpaciente="<?php echo $idpaciente; ?>" omodal="1">Texto</button>

      <button class="btn btn-warning btn-lg" type="button" is="b-link" des="a_pacientes_e/contexto_editar" v_idcontexto="0" v_idactividad="<?php echo $idactividad; ?>" v_idsubactividad="<?php echo $idsubactividad; ?>" v_tipo='video' v_idpaciente="<?php echo $idpaciente; ?>" omodal="1">Video</button>

      <button class="btn btn-warning btn-lg" type="button" is="b-link" des="a_pacientes_e/contexto_editar" v_idcontexto="0" v_idactividad="<?php echo $idactividad; ?>" v_idsubactividad="<?php echo $idsubactividad; ?>" v_tipo='archivo' v_idpaciente="<?php echo $idpaciente; ?>"  omodal="1">Archivo</button>
    </div>
    <div class="card-header">
      Bloque Respuesta
    </div>
    <div class="card-body text-center">
      <button class="btn btn-warning btn-lg" type="button" is="b-link" des="a_pacientes_e/contexto_editar" v_idcontexto="0" v_idactividad="<?php echo $idactividad; ?>" v_idsubactividad="<?php echo $idsubactividad; ?>" v_tipo='pregunta' v_idpaciente="<?php echo $idpaciente; ?>" omodal="1">Inciso</button>

      <button class="btn btn-warning btn-lg" type="button" is="b-link" des="a_pacientes_e/contexto_editar" v_idcontexto="0" v_idactividad="<?php echo $idactividad; ?>" v_idsubactividad="<?php echo $idsubactividad; ?>" v_tipo='textores' v_idpaciente="<?php echo $idpaciente; ?>" omodal="1">Texto</button>

      <button class="btn btn-warning btn-lg" type="button" is="b-link" des="a_pacientes_e/contexto_editar" v_idcontexto="0" v_idactividad="<?php echo $idactividad; ?>" v_idsubactividad="<?php echo $idsubactividad; ?>" v_tipo='fecha' v_idpaciente="<?php echo $idpaciente; ?>" omodal="1">Fecha</button>

      <button class="btn btn-warning btn-lg" type="button" is="b-link" des="a_pacientes_e/contexto_editar" v_idcontexto="0" v_idactividad="<?php echo $idactividad; ?>" v_idsubactividad="<?php echo $idsubactividad; ?>" v_tipo='archivores' v_idpaciente="<?php echo $idpaciente; ?>" omodal="1">Archivo</button>
    </div>
    <div class="card-footer">
      <button class="btn btn-warning btn-lg" type="button" is="b-link" des="a_pacientes/actividad_ver" cmodal="1">Regresar</button>
    </div>
  </div>
