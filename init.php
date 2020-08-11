<?php
$server=4;
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
else{
  define("MYSQLUSER", "sagyccom_esponda");
  define("MYSQLPASS", "esponda123$");
  define("SERVIDOR", "sagyc.com.mx");
  define("BDD", "sagycrmr_apasear");
}

?>
