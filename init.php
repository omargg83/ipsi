<?php
$server=4;
$_SESSION['des']=1;   ///////////////cambiar esta para acceder a modo desarrollador
if($server==1){
  /////////remoto
  define("MYSQLUSER", "wwipsi_wwipsi");
  define("MYSQLPASS", "wwipsi123$");
  define("SERVIDOR", "ipsiapp.com");
  define("BDD", "wwipsi_actividades");
  define("PORT", "3306");
}
else if($server==2){
  //////////localhost
  define("MYSQLUSER", "root");
  define("MYSQLPASS", "root");
  define("SERVIDOR", "localhost");
  define("BDD", "wwipsi_actividades");
  define("PORT", "3306");
}
else if($server==3){
  //////////localhost 2
  define("MYSQLUSER", "saludpublica");
  define("MYSQLPASS", "saludp123$");
  define("SERVIDOR", "192.168.100.15");
  define("BDD", "wwipsi_actividades");
  define("PORT", "3306");
}
else if($server==4){
  //////////localhost 2
  define("MYSQLUSER", "root");
  define("MYSQLPASS", "root");
  define("SERVIDOR", "localhost");
  define("BDD", "wwipsi_actividades");
  define("PORT", "8889");
}

///////////////////contraseñas
/////////// USAR EL SERVER 1
////EN LOS ARCHIVOS DB_.PHP ACTIVAR PARA VER PATH
//// Cuentas

//    User: paciente@correo.com
//    PAss: 123
///   TErapeuta:  terapeuta@correo.com
///   pass:  123
//  suma
///// correcto/incorrecto

?>
