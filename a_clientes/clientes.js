export const PI=3.14;
export function mundo(){
  console.log("hola mundo");
}
export function paciente(id){
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
export function ficha(id){
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
export function buscar_actividad(id){
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
export function actividad_addv(actividad,id){
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
