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
      <button class="btn btn-warning btn-lg" type="button" is="b-link" des="a_pacientes_e/contexto_editar" v_idcontexto="0" v_idactividad="<?php echo $idactividad; ?>" v_idsubactividad="<?php echo $idsubactividad; ?>" v_tipo='pregunta' v_idpaciente="<?php echo $idpaciente; ?>" omodal="1">Inciso</button>
    </div>
    <div class="card-footer">
      <button class="btn btn-warning btn-lg" type="button" is="b-link" des="a_pacientes/actividad_ver" cmodal="1">Regresar</button>
    </div>
  </div>
