<?php
	require_once("../a_actividades/db_.php");
  $idactividad=clean_var($_REQUEST['idactividad']);
  $idsubactividad=clean_var($_REQUEST['idsubactividad']);
  $tipo=clean_var($_REQUEST['tipo']);

  $paciente=0;
  if(isset($_REQUEST['idpaciente'])){
    $idpaciente=$_REQUEST['idpaciente'];
    $paciente=1;
  }
?>
  <div class="card">
    <?php
    if($tipo=="normal"){
      echo "<div class='card-header'>";
        echo "Bloque contexto";
      echo "</div>";
      echo "<div class='card-body text-center'>";
        echo "<button class='btn btn-warning btn-lg' type='button' is='b-link' des='a_actividades_e/contexto_editar' v_idcontexto='0' v_idactividad='$idactividad' v_idsubactividad='$idsubactividad' "; if($paciente==1){ echo " v_idpaciente='$idpaciente' ";} echo " v_tipo='imagen' omodal='1' >Imagen</button>";
        echo "<button class='btn btn-warning btn-lg' type='button' is='b-link' des='a_actividades_e/contexto_editar' v_idcontexto='0' v_idactividad='$idactividad' v_idsubactividad='$idsubactividad' "; if($paciente==1){ echo " v_idpaciente='$idpaciente' ";} echo " v_tipo='texto' omodal='1'>Texto</button>";
        echo "<button class='btn btn-warning btn-lg' type='button' is='b-link' des='a_actividades_e/contexto_editar' v_idcontexto='0' v_idactividad='$idactividad' v_idsubactividad='$idsubactividad' "; if($paciente==1){ echo " v_idpaciente='$idpaciente' ";} echo " v_tipo='video' omodal='1'>Video</button>";
        echo "<button class='btn btn-warning btn-lg' type='button' is='b-link' des='a_actividades_e/contexto_editar' v_idcontexto='0' v_idactividad='$idactividad' v_idsubactividad='$idsubactividad' "; if($paciente==1){ echo " v_idpaciente='$idpaciente' ";} echo " v_tipo='archivo' omodal='1'>Archivo</button>";
      echo "</div>";
      echo "<div class='card-header'>";
        echo "Bloque Respuesta";
      echo "</div>";
      echo "<div class='card-body text-center'>";
        echo "<button class='btn btn-warning btn-lg' type='button' is='b-link' des='a_actividades_e/contexto_editar' v_idcontexto='0' v_idactividad='$idactividad' v_idsubactividad='$idsubactividad' "; if($paciente==1){ echo " v_idpaciente='$idpaciente' ";} echo " v_tipo='pregunta' omodal='1'>Inciso</button>";
        echo "<button class='btn btn-warning btn-lg' type='button' is='b-link' des='a_actividades_e/contexto_editar' v_idcontexto='0' v_idactividad='$idactividad' v_idsubactividad='$idsubactividad' "; if($paciente==1){ echo " v_idpaciente='$idpaciente' ";} echo " v_tipo='textores' omodal='1'>Texto</button>";
        echo "<button class='btn btn-warning btn-lg' type='button' is='b-link' des='a_actividades_e/contexto_editar' v_idcontexto='0' v_idactividad='$idactividad' v_idsubactividad='$idsubactividad' "; if($paciente==1){ echo " v_idpaciente='$idpaciente' ";} echo " v_tipo='fecha' omodal='1'>Fecha</button>";
        echo "<button class='btn btn-warning btn-lg' type='button' is='b-link' des='a_actividades_e/contexto_editar' v_idcontexto='0' v_idactividad='$idactividad' v_idsubactividad='$idsubactividad' "; if($paciente==1){ echo " v_idpaciente='$idpaciente' ";} echo " v_tipo='archivores' omodal='1'>Archivo</button>";
      echo "</div>";
    }
    else{
      echo "<div class='card-header'>";
        echo "Agregar inciso";
      echo "</div>";
      echo "<div class='card-body text-center'>";
        echo "<button class='btn btn-warning btn-lg' type='button' is='b-link' des='a_actividades_e/contexto_editar' v_idcontexto='0' v_idactividad='$idactividad' v_idsubactividad='$idsubactividad' "; if($paciente==1){ echo " v_idpaciente='$idpaciente' ";} echo " v_tipo='pregunta' omodal='1'>Inciso</button>";
      echo "</div>";
    }
    ?>
    <div class="card-footer">
      <button class="btn btn-warning btn-lg" type="button" is="b-link" cmodal="1">Regresar</button>
    </div>
  </div>
