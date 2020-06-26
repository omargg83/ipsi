
  <?php
    require_once("db_.php");
    $id=$_REQUEST['id'];
    $idcuest=$_REQUEST['idcuest'];
    $orden="";
    $pregunta="";
    $tipo="";
    if($id>0){
      $row=$db->pregunta_edit($id);
      $orden=$row->orden;
      $pregunta=$row->pregunta;
      $tipo=$row->tipo;
    }
  ?>

    <div class='container'>
      <form id='form_comision' action='' data-lugar='a_actividades/db_'  data-funcion='guarda_pregunta'>
        <input class='form-control' type='hidden' id='id' NAME='id' value='<?php echo $id; ?>' >
        <input class='form-control' type='hidden' id='id2' NAME='id2' value='<?php echo $idcuest; ?>' >
        <div class='card'>
          <div class='card-header'>
              Preguntas
          </div>
            <div class='card-body'>
              <div class='row'>
                <div class='col-2'>
                  <label>Orden</label>
                  <input type='text' class='form-control' id='orden' name='orden' placeholder='Orden' value='<?php echo $orden; ?>' required>
                </div>

                <div class='col-6'>
                  <label>Pregunta</label>
                  <input type='text' class='form-control' id='pregunta' name='pregunta' placeholder='Texto de la pregunta' value='<?php echo $pregunta; ?>' required>
                </div>

                <div class='col-4'>
                  <label>Pregunta</label>
                  <select class='form-control' id='tipo' name='tipo' onchange='pregunta_tipo()' required>
                  <option value='radio' <?php if($tipo=="radio"){ echo " selected"; } ?>>Opcion unica</option>
                  <option value='caja' <?php if($tipo=="caja"){ echo " selected"; } ?>>Opcion multiple</option>
                  <option value='respuesta' <?php if($tipo=="respuesta"){ echo " selected"; } ?>>Respuesta abierta</option>
                  </select>
                </div>
              </div>
            </div>
            <div class='card-footer'>
              <div class='row'>
                <div class='col-12'>
                  <div class='btn-group'>
                    <button type='submit' class='btn btn-outline-secondary btn-sm'><i class='far fa-save'></i> Guardar</button>
                    <button type='button' class='btn btn-outline-secondary btn-sm' onclick='cuestionario(<?php echo $idcuest; ?>)'><i class='fas fa-undo-alt'></i> Regresar</button>
                  </div>
                </div>
              </div>
            </div>
        </div>
      </form>
      <hr>
      <form id='form_pregunta' action='' data-lugar='a_actividades/db_'  data-funcion='guarda_respuesta'>
        <input class='form-control' type='hidden' id='id' NAME='id' value='<?php echo $id; ?>' >
        <input class='form-control' type='hidden' id='id2' NAME='id2' value='<?php echo $idcuest; ?>' >

        <div class='card'>
          <div class='card-header'>
            Respuestas
          </div>
          <div class='card-body'>
            <div class='row' id='respuesta'>
              <div class='col-6'>
                <label>Opción</label>
                <input type='text' class='form-control' id='respuesta' name='respuesta' aria-describedby='emailHelp' placeholder='Texto de la pregunta'>
              </div>

              <div class='col-6'>
                <label>Valor</label>
                <input type='text' class='form-control' id='valor' name='valor' aria-describedby='emailHelp' placeholder='Texto de la pregunta'>
              </div>
            </div>
          </div>
          <div class='card-footer'>
            <div class='row'>
              <div class='col-12'>
                <button type='submit' class='btn btn-outline-secondary btn-sm'><i class='far fa-save'></i> Guardar</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
