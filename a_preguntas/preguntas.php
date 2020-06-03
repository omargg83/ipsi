
  <?php
    require_once("db_.php");
    $id=$_REQUEST['id'];
    $idcuest=$_REQUEST['param1'];

    $row=$db->pregunta_edit($idcuest);
  ?>

  <form id='form_comision' action='' data-lugar='a_preguntas/db_'  data-funcion='guarda_pregunta'>
    <input class='form-control' type='hidden' id='id' NAME='id' value='<?php echo $id; ?>' >
    <input class='form-control' type='hidden' id='id2' NAME='id2' value='<?php echo $idcuest; ?>' >
    <div class='container'>
      <div class='row'>
        <div class='col-2'>
          <label>Orden</label>
          <input type='text' class='form-control' id='orden' name='orden' placeholder='Orden' value='<?php echo $row->orden; ?>' required>
        </div>

        <div class='col-6'>
          <label>Pregunta</label>
          <input type='text' class='form-control' id='pregunta' name='pregunta' placeholder='Texto de la pregunta' value='<?php echo $row->pregunta; ?>' required>
        </div>

        <div class='col-4'>
          <label>Pregunta</label>
          <select class='form-control' id='tipo' name='tipo' onchange='pregunta_tipo()' required>
          <option value='radio'>Opcion unica</option>
          <option value='caja'>Opcion multiple</option>
          <option value='respuesta'>Respuesta abierta</option>
          </select>
        </div>
      </div>

      <div class='row'>
        <div class='col-12'>
          <button type='submit' class='btn btn-outline-secondary btn-sm'><i class='far fa-save'></i> Guardar</button>
        </div>
      </div>
    </form>

    <hr>
      <div class='col-12' id='pregunta'>
      </div>
      <form id='form_pregunta' action='' data-lugar='db_'  data-funcion='guarda_respuesta'>
        <input class='form-control' type='text' id='id' NAME='id' value='<?php echo $id; ?>' >
        <input class='form-control' type='text' id='id2' NAME='id2' value='<?php echo $idcuest; ?>' >
        <div class='row' id='respuesta'>
          <div class='col-6'>
            <label>Respuesta</label>
            <input type='text' class='form-control' id='respuesta' name='respuesta' aria-describedby='emailHelp' placeholder='Texto de la pregunta'>
          </div>

          <div class='col-6'>
            <label>Valor</label>
            <input type='text' class='form-control' id='valor' name='valor' aria-describedby='emailHelp' placeholder='Texto de la pregunta'>
          </div>
        </div>

        <div class='row'>
          <div class='col-12'>
            <button type='submit' class='btn btn-outline-secondary btn-sm'><i class='far fa-save'></i> Guardar</button>
          </div>
        </div>
      </form>

    </div>
  </form>


</body>


 </html>
