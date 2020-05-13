<!DOCTYPE HTML>
<html lang="es">
<head>
</head>
<body>
  <?php
    $id=0;
    $idcuestionario=1;
  ?>

  <form id='form_comision' action='' data-lugar='db_'  data-funcion='guarda_pregunta'>
    <input class='form-control' type='text' id='id' NAME='id' value='<?php echo $id; ?>' >
    <input class='form-control' type='text' id='id2' NAME='id2' value='<?php echo $idcuestionario; ?>' >
    <div class='container'>
      <div class='row'>
        <div class='col-2'>
          <label>Orden</label>
          <input type='text' class='form-control' id='exampleInputEmail1' aria-describedby='emailHelp' placeholder='Orden' required>
        </div>

        <div class='col-6'>
          <label>Pregunta</label>
          <input type='text' class='form-control' id='exampleInputEmail1' aria-describedby='emailHelp' placeholder='Texto de la pregunta' required>
        </div>

        <div class='col-4'>
          <label>Pregunta</label>
          <select class='form-control' id='tipo' name='tipo' onchange='pregunta_tipo()' required>
          <option value='opciones'>Opciones</option>
          <option value='casillas'>Casillas</option>
          <option value='respuesta'>Respuesta</option>
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

    </div>
  </form>


</body>

 <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>
 <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />


 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
 <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

 <script>
    function pregunta_tipo(){
      var tipo=$('#tipo').val();
     $.ajax({
       data:{
         "function":"pregunta_tipo",
         "tipo":tipo
       },
       url: "db_.php",
       type: "POST",
       timeout:1000,
       beforeSend: function () {

       },
       success:function(response){
         $('#pregunta').html(response);
       }
     });
    }
 </script>

 </html>
