$(document).on('submit','#acceso',function(e){
  e.preventDefault();
  var userAcceso=document.getElementById("inputEmail").value;
  var passAcceso=document.getElementById("inputPassword").value;

  $.ajax({
    url: "login.php",
    type: "POST",
    data: {
      "userAcceso":userAcceso,
      "passAcceso":passAcceso
    },
    success: function( response ) {
      console.log(response);
      var data = JSON.parse(response);
      if (data.acceso==1){
        $(location).attr('href','../');
      }
      else{
        Swal.fire({
            type: 'error',
            title: 'Usuario o contraseña incorrecta',
            showConfirmButton: false,
            timer: 1000
        })
      }
    }
  });
});
