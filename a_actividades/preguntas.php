  <?php
    require_once("db_.php");
    $idactividad=$_REQUEST['idactividad'];
    $idpregunta=$_REQUEST['idpregunta'];

    $orden="";
    $pregunta="";
    $tipo="";
    if($idpregunta>0){
      $row=$db->pregunta_edit($idpregunta);
      $orden=$row->orden;
      $pregunta=$row->pregunta;
      $tipo=$row->tipo;
    }
    echo "<div class='container'>";
      echo "<nav aria-label='breadcrumb'>";
        echo "<ol class='breadcrumb'>";
          echo "<li class='breadcrumb-item' >Actividades</li>";
          echo "<li class='breadcrumb-item' onclick='actividad($idactividad)'>Actividad</li>";
          echo "<li class='breadcrumb-item active' aria-current='page'>Subactividad</li>";
        echo "</ol>";
      echo "</nav>";

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
  ?>

      <form id='form_comision' action='' data-lugar='a_actividades/db_'  data-funcion='guarda_pregunta'>
        <input class='form-control' type='hidden' id='id' NAME='id' value='<?php echo $idpregunta; ?>' >
        <input class='form-control' type='hidden' id='id2' NAME='id2' value='<?php echo $idactividad; ?>' >
        <div class='card'>
          <div class='card-header'>
            Subactividad
          </div>
          <div class='card-body'>
            <div class='row'>
              <div class='col-2'>
                <label>Orden</label>
                <input type='text' class='form-control' id='orden' name='orden' placeholder='Orden' value='<?php echo $orden; ?>' required>
              </div>

              <div class='col-4'>
                <label>Pregunta</label>
                <select class='form-control' id='tipo' name='tipo' onchange='pregunta_tipo()' required>
                <option value='radio' <?php if($tipo=="radio"){ echo " selected"; } ?>>Opcion unica</option>
                <option value='caja' <?php if($tipo=="caja"){ echo " selected"; } ?>>Opcion multiple</option>
                <option value='respuesta' <?php if($tipo=="respuesta"){ echo " selected"; } ?>>Respuesta abierta</option>
                </select>
              </div>

              <div class='col-12'>
                <label>Pregunta</label>
                <input type='text' class='form-control' id='pregunta' name='pregunta' placeholder='Texto de la pregunta' value='<?php echo $pregunta; ?>' required>
              </div>
            </div>
          </div>

          <div class='card-footer'>
            <div class='row'>
              <div class='col-12'>
                <div class='btn-group'>
                  <?php
                    echo "<button type='submit' class='btn btn-outline-secondary btn-sm'><i class='far fa-save'></i> Guardar</button>";
                    echo "<button type='button' class='btn btn-outline-secondary btn-sm' onclick='respuestas($idactividad,document.getElementById(\"id\").value,0)'><i class='fas fa-plus'></i> Respuesta</button>";
                    echo "<button type='button' class='btn btn-outline-secondary btn-sm' onclick='actividad($idactividad)'><i class='fas fa-undo-alt'></i> Regresar</button>";
                  ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
      <br>
      <?php
        if($idpregunta>0){
      ?>

      <div class='card'>
        <div class='card-header'>
          Respuestas
        </div>
        <div class='card-body'>
        <?php
          $row=$db->respuestas($idpregunta);
          foreach($row as $key){
            echo "<div id='".$key->id."''  class='row edit-t'>";

              echo "<div class='col-1'>";
                echo "<div class='btn-group'>";
                echo "<button class='btn btn-outline-primary btn-sm' onclick='respuestas($idactividad,$idpregunta,$key->id)'><i class='fas fa-pencil-alt'></i></button>";
                echo "</div>";
              echo "</div>";

              echo "<div class='col-10'>".$key->orden.".-".$key->respuesta."</div>";
            echo "</div>";
          }
        ?>
        </div>
      </div>

      <?php
        }
      ?>
    </div>
