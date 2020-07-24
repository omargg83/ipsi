//////////clientes
function paciente(id){
  $.ajax({
    data:{
      "id":id
    },
    url: "a_clientes/paciente.php",
    type: "POST",
    timeout:1000,
    beforeSend: function () {
      $("#cargando").addClass("is-active");
    },
    success:function(response){
      $('#trabajo').html(response);
    }
  });
  $("#cargando").removeClass("is-active");
}
function ficha(id){
  $.ajax({
    data:{
      "id":id
    },
    url: "a_clientes/editar.php",
    type: "POST",
    timeout:1000,
    beforeSend: function () {
      $("#cargando").addClass("is-active");
    },
    success:function(response){
      $('#trabajo').html(response);
    }
  });
  $("#cargando").removeClass("is-active");
}
function buscar_actividad(id){
  var b_actividad=$("#b_actividad").val();
  if(b_actividad.length>=-1){
    $.ajax({
      data:  {
        "b_actividad":b_actividad,
        "id":id,
        "function":"buscar_actividad"
      },
      url:   "a_clientes/db_.php",
      type:  'post',
      beforeSend: function () {
        $("#resultadosx").html("buscando...");
      },
      success:  function (response) {
        $("#resultadosx").html(response);
        $("#prod_venta").val();
      }
    });
  }

}
function actividad_addv(actividad,id){
  $.ajax({
    data:  {
      "actividad":actividad,
      "id":id,
      "function":"agrega_actividad"
    },
    url:   "a_clientes/db_.php",
    type:  'post',
    beforeSend: function () {
      $("#resultadosx").html("buscando...");
    },
    success:  function (response) {
      console.log(response);
    }
  });
}

/////////////actividades
function actividad_editar(idactividad){
  $.ajax({
    data:{
      "idactividad":idactividad
    },
    url: "a_actividades/actividad_editar.php",
    type: "POST",
    timeout:1000,
    beforeSend: function () {
      $("#cargando").addClass("is-active");
    },
    success:function(response){
      $('#trabajo').html(response);
    }
  });
  $("#cargando").removeClass("is-active");
}
function actividad_ver(idactividad){
  $.ajax({
    data:{
      "idactividad":idactividad
    },
    url: "a_actividades/actividad_ver.php",
    type: "POST",
    timeout:1000,
    beforeSend: function () {
      $("#cargando").addClass("is-active");
    },
    success:function(response){
      $('#trabajo').html(response);
    }
  });
  $("#cargando").removeClass("is-active");
}
function eliminar_act(idactividad){
  $.confirm({
    title: 'Eliminar',
    content: '¿Desea borrar la actividad seleccionada?',
    buttons: {
      Aceptar: function () {
        var parametros={
          "idactividad":idactividad,
          "function":"actividad_del"
        };
        $.ajax({
          data:  parametros,
          url: "a_actividades/db_.php",
          type:  'post',
          timeout:10000,
          success:  function (response) {
            $('#trabajo').load("a_actividades/lista.php");
          },
          error: function(jqXHR, textStatus, errorThrown) {

          }
        });
      },
      Cancelar: function () {

      }
    }
  });
}

function subactividad_editar(id,idactividad,tipo){
  $.ajax({
    data:{
      "id":id,
      "idactividad":idactividad,
      "tipo":tipo
    },
    url: "a_actividades/subactividad_editar.php",
    type: "POST",
    timeout:1000,
    beforeSend: function () {
      $("#cargando").addClass("is-active");
    },
    success:function(response){
      $('#subactividad').html(response);
    }
  });
  $("#cargando").removeClass("is-active");
}
function subactividad_ver(id,idactividad,tipo){
  $.ajax({
    data:{
      "id":id,
      "idactividad":idactividad,
      "tipo":tipo
    },
    url: "a_actividades/subactividad_ver.php",
    type: "POST",
    timeout:1000,
    beforeSend: function () {
      $("#cargando").addClass("is-active");
    },
    success:function(response){
      $('#subactividad').html(response);
    }
  });
  $("#cargando").removeClass("is-active");
}
function eliminar_subact(id){
  $.confirm({
    title: 'Eliminar',
    content: '¿Desea borrar la actividad seleccionada?',
    buttons: {
      Aceptar: function () {
        var parametros={
          "id":id,
          "function":"subactividad_del"
        };
        $.ajax({
          data:  parametros,
          url: "a_actividades/db_.php",
          type:  'post',
          timeout:10000,
          success:  function (response) {
            $('#trabajo').load("a_actividades/lista.php");
          },
          error: function(jqXHR, textStatus, errorThrown) {

          }
        });
      },
      Cancelar: function () {

      }
    }
  });
}

function respuestas_editar(id,idactividad,idsubactividad){
  $.ajax({
    data:{
      "id":id,
      "idactividad":idactividad,
      "idsubactividad":idsubactividad
    },
    url: "a_actividades/respuesta_editar.php",
    type: "POST",
    timeout:1000,
    beforeSend: function () {
      $("#cargando").addClass("is-active");
    },
    success:function(response){
      $('#respuestas').html(response);
    }
  });
  $("#cargando").removeClass("is-active");
}
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
