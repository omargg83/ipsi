<?php
$server=1;
if($server==1){
  /////////remoto
  define("MYSQLUSER", "wwipsi_wwipsi");
  define("MYSQLPASS", "wwipsi123$");
  define("SERVIDOR", "ipsiapp.com");
  define("BDD", "wwipsi_actividades");
}
else if($server==2){
  //////////localhost
  define("MYSQLUSER", "root");
  define("MYSQLPASS", "root");
  define("SERVIDOR", "localhost");
  define("BDD", "wwipsi_actividades");
}
else if($server==3){
  //////////localhost 2
  define("MYSQLUSER", "saludpublica");
  define("MYSQLPASS", "saludp123$");
  define("SERVIDOR", "192.168.100.15");
  define("BDD", "wwipsi_actividades");
}



///////////////////contraseñas
/////////// USAR EL SERVER 4 *TEMPORALMENTE
////EN LOS ARCHIVOS DB_.PHP ACTIVAR PARA VER PATH
//// Cuentas

//    User: paciente@correo.com
//    PAss: 123
///   TErapeuta:  terapeuta@correo.com
///   pass:  123
//  suma
///// correcto/incorrecto

?>
