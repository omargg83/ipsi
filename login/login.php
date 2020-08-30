<?php @session_start();

	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	date_default_timezone_set("America/Mexico_City");

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;

	require_once("../init.php");

	class ipsi{
		public $nivel_personal;
		public $nivel_captura;
		public $personas;
		public $arreglo;
		public $limite=300;

		public function __construct(){
			date_default_timezone_set("America/Mexico_City");
			try{
				$this->dbh = new PDO("mysql:host=".SERVIDOR.";dbname=".BDD, MYSQLUSER, MYSQLPASS);
				$this->dbh->query("SET NAMES 'utf8'");
			}
			catch(PDOException $e){
				return "Database access FAILED!".$e->getMessage();
			}
		}
		public function acceso(){
			try{
				if($_SERVER['REQUEST_METHOD']!="POST"){
					return 0;
				}
				$userPOST = clean_var($_REQUEST["inputEmail"]);
				$passPOST=md5(clean_var($_REQUEST["inputPassword"]));

				$sql="SELECT * FROM usuarios where correo=:usuario and pass=:pass and autoriza=1";
				$sth = $this->dbh->prepare($sql);
				$sth->bindValue(":usuario",$userPOST);
				$sth->bindValue(":pass",$passPOST);
				$sth->execute();
				if ($sth->rowCount()>0){
					$suma=1;
					$CLAVE=$sth->fetch(PDO::FETCH_OBJ);
					$_SESSION['autoriza']=1;
					$_SESSION['admin']=1;
					$_SESSION['nombre']=$CLAVE->nombre;
					$_SESSION['nombrec']=$CLAVE->nombre." ".$CLAVE->apellidop;
					$_SESSION['nivel'] = $CLAVE->nivel;
					$_SESSION['tipo_user'] = "Psicólogo";
					$_SESSION['pagnivel']=40;
					$_SESSION['idusuario']=$CLAVE->idusuario;
					$_SESSION['cfondo']="#fff";
					$_SESSION['foto']="a_archivos/terapeuta/".$CLAVE->foto;
					$arr=array();
					$arr=array('acceso'=>1,'idpersona'=>$_SESSION['idusuario']);
					return json_encode($arr);
				}
				else {
					$sql="SELECT * FROM clientes where (correo=:usuario) and (UPPER(pass)=UPPER(:pass)) and autoriza=1";
					$sth = $this->dbh->prepare($sql);
					$sth->bindValue(":usuario",$userPOST);
					$sth->bindValue(":pass",$passPOST);
					$sth->execute();

					if ($sth->rowCount()>0){
						$suma=1;
						$CLAVE=$sth->fetch(PDO::FETCH_OBJ);
						$_SESSION['autoriza']=1;
						$_SESSION['admin']=0;
						$_SESSION['nombre']=$CLAVE->nombre;
						$_SESSION['nombrec']=$CLAVE->nombre." ".$CLAVE->apellidop;
						$_SESSION['nivel'] = 666;
						$_SESSION['tipo_user'] = "Paciente";
						$_SESSION['pagnivel']=40;
						$_SESSION['idusuario']=$CLAVE->id;
						$_SESSION['cfondo']="#fff";
						$_SESSION['foto']="a_archivos/clientes/".$CLAVE->foto;
						$arr=array();
						$arr=array('acceso'=>1,'idpersona'=>$_SESSION['idusuario']);
						return json_encode($arr);
					}
					else{
						$arr=array();
						$arr=array('acceso'=>0,'idpersona'=>0);
						return json_encode($arr);
					}
				}
				return $obj;
			}
			catch(PDOException $e){
				return "Database access FAILED!".$e->getMessage();
			}
		}
  }
	function clean_var($val){
		$val=htmlspecialchars(strip_tags(trim($val)));
		return $val;
	}

	$db = new ipsi();
	echo $db->acceso();


?>
