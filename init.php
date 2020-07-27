<?php

$server=1;

if($server==1){
  define("MYSQLUSER", "wwipsi_wwipsi");
  define("MYSQLPASS", "wwipsi123$");
  define("SERVIDOR", "ipsiapp.com");
  define("BDD", "wwipsi_actividades");
}
else if($server==2){
  define("MYSQLUSER", "root");
  define("MYSQLPASS", "root");
  define("SERVIDOR", "localhost");
  define("BDD", "wwipsi_actividades");
}
else{
  define("MYSQLUSER", "saludpublica");
  define("MYSQLPASS", "saludp123$");
  define("SERVIDOR", "192.168.100.15");
  define("BDD", "wwipsi_actividades");
}

?>
