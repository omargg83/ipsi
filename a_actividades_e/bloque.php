<?php
	require_once("../a_actividades/db_.php");
  $idactividad=clean_var($_REQUEST['idactividad']);
  $idsubactividad=clean_var($_REQUEST['idsubactividad']);
  $tipo=clean_var($_REQUEST['tipo']);

	$actividad=$db->actividad_editar($idactividad);

	$tipo_actividad=$actividad->tipo;

  $paciente=0;
  if(isset($_REQUEST['idpaciente'])){
    $idpaciente=$_REQUEST['idpaciente'];
    $paciente=1;
  }
?>
  <div class="card">
    <?php
      echo "<div class='card-header'>";
        echo "Bloque contexto";
      echo "</div>";
      echo "<div class='card-body text-center'>";

        echo "<button class='btn btn-warning btn-lg btn-constructor' type='button' is='b-link' des='a_actividades_e/contexto_editar' v_idcontexto='0' v_idactividad='$idactividad' v_idsubactividad='$idsubactividad' "; if($paciente==1){ echo " v_idpaciente='$idpaciente' ";} echo " v_tipo='texto' omodal='1'> <i class='fas fa-font'></i><br>Texto</button>";
        echo "<button class='btn btn-warning btn-lg btn-constructor' type='button' is='b-link' des='a_actividades_e/contexto_editar' v_idcontexto='0' v_idactividad='$idactividad' v_idsubactividad='$idsubactividad' "; if($paciente==1){ echo " v_idpaciente='$idpaciente' ";} echo " v_tipo='imagen' omodal='1' > <i class='far fa-image'></i><br> Imagen</button>";
        echo "<button class='btn btn-warning btn-lg btn-constructor' type='button' is='b-link' des='a_actividades_e/contexto_editar' v_idcontexto='0' v_idactividad='$idactividad' v_idsubactividad='$idsubactividad' "; if($paciente==1){ echo " v_idpaciente='$idpaciente' ";} echo " v_tipo='video' omodal='1'> <i class='fab fa-youtube'></i><br> Video</button>";
        echo "<button class='btn btn-warning btn-lg btn-constructor' type='button' is='b-link' des='a_actividades_e/contexto_editar' v_idcontexto='0' v_idactividad='$idactividad' v_idsubactividad='$idsubactividad' "; if($paciente==1){ echo " v_idpaciente='$idpaciente' ";} echo " v_tipo='archivo' omodal='1'> <i class='far fa-file'></i><br> Archivo</button>";
      echo "</div>";
      echo "<div class='card-header'>";
        echo "Bloque Respuesta";
      echo "</div>";
      echo "<div class='card-body text-center'>";
        echo "<button class='btn btn-warning btn-lg btn-constructor' type='button' is='b-link' des='a_actividades_e/contexto_editar' v_idcontexto='0' v_idactividad='$idactividad' v_idsubactividad='$idsubactividad' "; if($paciente==1){ echo " v_idpaciente='$idpaciente' ";} echo " v_tipo='pregunta' omodal='1'> <i class='fas fa-tasks'></i><br> Inciso</button>";

				if($actividad->tipo!="evaluacion"){
	        echo "<button class='btn btn-warning btn-lg btn-constructor' type='button' is='b-link' des='a_actividades_e/contexto_editar' v_idcontexto='0' v_idactividad='$idactividad' v_idsubactividad='$idsubactividad' "; if($paciente==1){ echo " v_idpaciente='$idpaciente' ";} echo " v_tipo='textores' omodal='1'><i class='fas fa-font'></i><br> Texto</button>";
	        echo "<button class='btn btn-warning btn-lg btn-constructor' type='button' is='b-link' des='a_actividades_e/contexto_editar' v_idcontexto='0' v_idactividad='$idactividad' v_idsubactividad='$idsubactividad' "; if($paciente==1){ echo " v_idpaciente='$idpaciente' ";} echo " v_tipo='fecha' omodal='1'> <i class='far fa-calendar-alt'></i> <br>Fecha</button>";
	        echo "<button class='btn btn-warning btn-lg btn-constructor' type='button' is='b-link' des='a_actividades_e/contexto_editar' v_idcontexto='0' v_idactividad='$idactividad' v_idsubactividad='$idsubactividad' "; if($paciente==1){ echo " v_idpaciente='$idpaciente' ";} echo " v_tipo='archivores' omodal='1'><i class='far fa-file'></i><br> Archivo</button>";
				}
      echo "</div>";

    ?>
    <div class="card-footer">
      <button class="btn btn-warning btn-lg" type="button" is="b-link" cmodal="1"> <i class="far fa-arrow-alt-circle-left"></i>Regresar</button>
    </div>
  </div>
