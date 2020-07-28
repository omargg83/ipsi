<?php
  require_once("db_.php");

  $idpregunta=$_REQUEST['id1'];
  $idactividad=$_REQUEST['id2'];
  $idrespuesta=$_REQUEST['id3'];
  $orden="";
  $respuesta="";
  $valor="";

  if($idrespuesta>0){
    $row=$db->respuesta_edit($idrespuesta);
    $orden=$row->orden;
    $respuesta=$row->respuesta;
    $valor=$row->valor;
  }
    echo "<div class='container'>";
    $cuest=$db->actividad_editar($idactividad);
    echo "<div class='card'>";
      echo "<div class='card-header'>";
        echo "Actividad";
      echo "</div>";
      echo "<div class='card-body'>";
        echo "<div class='row'>";
          echo "<div class='col-12'>";
            echo $cuest->nombre;
            echo "<br>";
            echo $cuest->observaciones;
          echo "</div>";
        echo "</div>";
      echo "</div>";
    echo "</div>";
    echo "<br>";

    $pregunta=$db->pregunta_edit($idpregunta);
    echo "<div class='card'>";
      echo "<div class='card-header'>";
        echo "Subactividad";
      echo "</div>";
      echo "<div class='card-body'>";
        echo "<div class='row'>";
          echo "<div class='col-12'>";
            echo $pregunta->orden." - ";
            echo $pregunta->pregunta;
          echo "</div>";
        echo "</div>";
      echo "</div>";
    echo "</div>";
    echo "<br>";

?>

  <form id='form_pregunta' action='' data-lugar='a_actividades/db_'  data-funcion='guarda_respuesta'>
    <input class='form-control' type='hidden' id='id' NAME='id' value='<?php echo $idrespuesta; ?>' >
    <input class='form-control' type='hidden' id='id2' NAME='id2' value='<?php echo $idpregunta; ?>' >

    <div class='card'>
      <div class='card-header'>
        Respuestas
      </div>
      <div class='card-body'>
        <div class='row' id='respuesta'>
          <div class='col-2'>
            <label>Orden</label>
            <input type='text' class='form-control' id='orden' name='orden' value='<?php echo $orden; ?>' placeholder='Orden'>
          </div>

          <div class='col-8'>
            <label>Opción</label>
            <input type='text' class='form-control' id='respuesta' name='respuesta' value='<?php echo $respuesta; ?>' placeholder='Texto de la respuesta'>
          </div>

          <div class='col-2'>
            <label>Valor</label>
            <input type='text' class='form-control' id='valor' name='valor' value='<?php echo $valor; ?>' placeholder='Valor para evaluar'>
          </div>
        </div>
      </div>
      <div class='card-footer'>
        <div class='row'>
          <div class='col-12'>
            <div class='btn-group'>
            <?php
              echo "<button type='submit' class='btn btn-warning '><i class='far fa-save'></i> Guardar</button>";
              echo "<button type='button' class='btn btn-warning ' onclick='preguntas($idactividad,$idpregunta)'><i class='fas fa-undo-alt'></i> Regresar</button>";
            ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
