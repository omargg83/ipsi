<?php
	session_name("salud_publica#&%1");
	@session_start();

	
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;

	require_once("../init.php");
    
	class XPIKA{
		public function __construct(){
			date_default_timezone_set("America/Mexico_City");
			try{
				$this->dbh = new PDO("mysql:host=".SERVIDOR.";dbname=".BDD, MYSQLUSER, MYSQLPASS);
				$this->dbh->query("SET NAMES 'utf8'");
			}
			catch(PDOException $e){
				return "Database access FAILED!";
			}
		}
    }

    $db = new XPIKA();
    

    $sql="SELECT * FROM correo where config='cita'";
    $sth = $db->dbh->query($sql);
    $correo=$sth->fetch(PDO::FETCH_OBJ);		
    
    echo $correo->tiempo;

    $sql="SELECT * FROM citas where TIMEDIFF(now(),desde)<$correo->tiempo";
    $sth = $db->dbh->query($sql);
    $correo=$sth->fetch(PDO::FETCH_OBJ);		

    


?>

