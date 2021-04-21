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
    
    $sql="SELECT * FROM citas where TIMEDIFF(now(),desde)<$correo->tiempo  and estatus='Aprobada' limit 1";
    $sth = $db->dbh->query($sql);
    $citas=$sth->fetch(PDO::FETCH_OBJ);	


	$sql="SELECT * FROM usuarios where idusuario=$citas->idusuario";
	echo $sql;
    $sth = $db->dbh->query($sql);
    $usuario=$sth->fetch(PDO::FETCH_OBJ);	


	$correo_usr=$usuario->correo;


	$asunto="asunto";
	$texto=$correo->texto;
    
	require '../vendor/autoload.php';
	$mail = new PHPMailer;
	$mail->CharSet = 'UTF-8';

	$asunto=$correo->asunto;
	$mail->Body    = $asunto;
	$mail->Subject = $asunto;
	$mail->AltBody = $asunto;

	$mail->isSMTP();

	////////////cambiar esta configuracion
		$mail->Host = $correo->host;						  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication

		$mail->Username = $correo->user;       // SMTP username
		$mail->Password = $correo->pass;


		$mail->SMTPSecure = $correo->smptsecure;                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = $correo->port;                                    // TCP port to connect to
		$mail->CharSet = 'UTF-8';

		$mail->From = $correo->user;   //////////esto solo muestra el remitente
		$mail->FromName = $asunto;			//////////// remitente
	//////////hasta aca

	$mail->IsHTML(true);
	$mail->addAddress($correo_usr);
	//$mail->addAddress("omargg83@gmail.com");

	$mail->msgHTML($texto);
	$arreglo=array();

	echo $mail->send();
?>

