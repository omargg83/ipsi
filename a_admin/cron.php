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

	function fecha($fecha,$key=""){
		$mesn=["","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
		if(strlen($fecha)>0){
			$fecha = new DateTime($fecha);
			if ($key==""){
				return $fecha->format('d-m-Y');
			}
			if($key==1){
				$mes=$fecha->format('n');
				return $fecha->format('d')." de $mesn[$mes] de ".$fecha->format('Y');
			}
			if($key==2){
				return $fecha->format('d-m-Y H:i:s');
			}
			if($key==3){
				$mes=$fecha->format('n');
				return $fecha->format('d')." de ". $mesn[$mes] ." de ".$fecha->format('Y')." ".$fecha->format('H:i:s');
			}
			if ($key=="4"){
				return $fecha->format('d/m/Y');
			}
			if ($key=="5"){
				$mes=$fecha->format('n');
				return $fecha->format('d')." de $mesn[$mes]";
			}
		}
	}
    

    $sql="SELECT * FROM correo where config='cita'";
    $sth = $db->dbh->query($sql);
    $correo=$sth->fetch(PDO::FETCH_OBJ);		
    
    $sql="SELECT * FROM citas where TIMEDIFF(now(),desde)<$correo->tiempo  and estatus='Aprobada' and notifica is null limit 1";
    $sth = $db->dbh->query($sql);
    $citas=$sth->fetch(PDO::FETCH_OBJ);	

	if($sth->rowCount()){
	
		$sql="SELECT * FROM usuarios where idusuario=$citas->idusuario";
		$sth = $db->dbh->query($sql);
		$terap=$sth->fetch(PDO::FETCH_OBJ);	


		$sql="SELECT * FROM clientes where id=$citas->idpaciente";
		$sth = $db->dbh->query($sql);
		$cliente=$sth->fetch(PDO::FETCH_OBJ);	


		$correo_usr=$cliente->correo;
		$correo_ter=$terap->correo;

		$asunto="asunto";
		$texto=$correo->texto;

		$variables=array();
		$variables+=array("terapeuta"=>$terap->nombre." ".$terap->apellidop." ".$terap->apellidom);
		$variables+=array("fecha"=>fecha($citas->desde,3));
		$variables+=array("cita"=>"#".$citas->idcita);

		foreach($variables as $f => $key){
			$texto=str_replace("%".$f,$key,$texto);
		}
		
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
		
		if($_SESSION['des']==1)
			$mail->addAddress("omargg83@gmail.com");
		else
			$mail->addAddress($correo_usr);



		if($_SESSION['des']==1)
			$mail->addAddress("omargg83@gmail.com");
		else
			$mail->addAddress($correo_usr);

		if($_SESSION['des']==1)
			$mail->addCC($correo_ter);
		else
			$mail->addCC($key);


		$mail->msgHTML($texto);
		$arreglo=array();

		if ($mail->send()) {
			$fecha=date("Y-m-d H:m:i");
			$sql="update citas set notifica=1, fecha_notif='$fecha' where idcita='$citas->idcita'";
			$sth = $db->dbh->query($sql);
		}
	}
?>

