<?php
	if (!isset($_SESSION)) { session_start(); }
	if (isset($_REQUEST['function'])){$function=$_REQUEST['function'];}	else{ $function="";}
	if (isset($_REQUEST['ctrl'])){$ctrl=$_REQUEST['ctrl'];}	else{ $ctrl="";}

	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	date_default_timezone_set("America/Mexico_City");
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;

	class ipsi{
		public $nivel_personal;
		public $nivel_captura;
		public $personas;
		public $arreglo;
		public $limite=300;

		public function __construct(){
			date_default_timezone_set("America/Mexico_City");
			try{
				$_SESSION['mysqluser']="sagyccom_esponda";
				$_SESSION['mysqlpass']="esponda123$";
				$_SESSION['servidor'] ="sagyc.com.mx";
				$_SESSION['bdd']="sagycrmr_txpika";
				$this->dbh = new PDO("mysql:host=".$_SESSION['servidor'].";dbname=".$_SESSION['bdd']."", $_SESSION['mysqluser'], $_SESSION['mysqlpass']);
				self::set_names();
			}
			catch(PDOException $e){
				return "Database access FAILED!".$e->getMessage();
			}
		}
		public function set_names(){
			return $this->dbh->query("SET NAMES 'utf8'");
		}
		public function acceso(){
			try{
				$userPOST = htmlspecialchars($_REQUEST["userAcceso"]);
				$passPOST=$_REQUEST["passAcceso"];
				$sql="SELECT* FROM usuarios where (usuario=:usuario) and (UPPER(pass)=UPPER(:pass)) and autoriza=1";
				$sth = $this->dbh->prepare($sql);
				$sth->bindValue(":usuario",$userPOST);
				$sth->bindValue(":pass",$passPOST);
				$sth->execute();

				 if ($sth->rowCount()>0){
					$suma=1;
					$CLAVE=$sth->fetch();
					$_SESSION['autoriza']=1;
					$_SESSION['nombre']=$CLAVE['nombre'];
					$_SESSION['usuario'] = $CLAVE['usuario'];
					$_SESSION['pass'] = $CLAVE['pass'];
					$_SESSION['nivel'] = $CLAVE['nivel'];
					$_SESSION['pagnivel']=40;
					$_SESSION['idusuario']=$CLAVE['idusuario'];
					$_SESSION['remoto']=0;

					$_SESSION['anio']=date("Y");
					$_SESSION['mes']=date("m");
					$_SESSION['dia']=date("d");
					$_SESSION['hasta']=2016;
					$_SESSION['foco']=mktime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"));
					$_SESSION['cfondo']="white";
					$arr=array();
					$arr=array('acceso'=>1,'idpersona'=>$_SESSION['idusuario']);
					return json_encode($arr);
				}
				else {
					$arr=array();
					$arr=array('acceso'=>0,'idpersona'=>0);
					return json_encode($arr);
				}
				return $obj;
			}
			catch(PDOException $e){
				return "Database access FAILED!".$e->getMessage();
			}
		}
		public function login(){
			$arreglo=array();
			if(!isset($_SESSION['idfondo'])){
				$_SESSION['idfondo']="";
			}
			if(isset($_SESSION['idusuario']) and $_SESSION['autoriza'] == 1) {
				///////////////////////////sesion abierta
				$valor=$_SESSION['idfondo'];
				$x="";
				$x.="<nav class='navbar navbar-expand-sm navbar-dark fixed-top bg-dark' style='opacity:1;'>";
					$x.="<button class='btn btn-outline-secondary' type='button' id='sidebarCollapse'>";
						$x.="<span class='navbar-toggler-icon'></span>";
					$x.="</button>";

					$x.="<a class='navbar-brand' href='#escritorio/dashboard' style='font-size:10px'>Tic Shop ASASD</a>";

					$x.="<button class='navbar-toggler navbar-toggler-right' type='button' data-toggle='collapse' data-target='#principal' aria-controls='principal' aria-expanded='false' aria-label='Toggle navigation'>";
						$x.="<i class='fab fa-rocketchat'></i>";
					$x.="</button>";

					$x.="<div class='collapse navbar-collapse' id='principal'>";
						$x.="<ul class='navbar-nav mr-auto'>";
							$x.="<li class='nav-item dropdown'>";
								$x.="<a class='nav-link navbar-brand' href='#' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'></a>";
							$x.="</li>";
						$x.="</ul>";
						$x.="<ul class='nav navbar-nav navbar-right' id='notificaciones'></ul>";

						$x.="<ul class='nav navbar-nav navbar-right' id='fondo'></ul>";
						$x.="<ul class='nav navbar-nav navbar-right'>";
							$x.="<li class='nav-item dropdown'>";
								$x.="<a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>";
									$x.="<i class='fas fa-user-check'></i>";
									$x.=$_SESSION['nombre'];
								$x.="</a>";

								$x.="<div class='dropdown-menu' aria-labelledby='navbarDropdown'>";
									$x.="<a class='dropdown-item' id='winmodal_pass' data-id='".$_SESSION['idusuario']."' data-lugar='a_usuarios/form_pass' title='Cambiar contraseña' ><i class='fas fa-key'></i>Contraseña</a>";
								$x.="</div>";
							$x.="</li>";
						$x.="</ul>";
						$x.="<ul class='nav navbar-nav navbar-right'>";
							$x.="<li class='nav-item'>";
								$x.="<a class='nav-link pull-left' onclick='salir()'>";
									$x.="<i class='fas fa-door-open' style='color:red;'></i>Salir";
								$x.="</a>";
							$x.="</li>";
						$x.="</ul>";
					$x.="</div>";
				$x.="</nav>";

				$y="";
				/////////////fin del header
				$y.="<div class='wrapper'>";
					$y.="<div class='content navbar-default'>";
						$y.="<div class='container-fluid'>";
							$y.="<div class='sidebar sidenav' id='navx'>";
								$y.="<a href='#escritorio/dashboard' class='activeside'><i class='fas fa-home'></i> <span>Inicio</span></a>";
								$y.="<a href='#a_productos/index' title='Productos'><i class='fas fa-users '></i> <span>Productos</span></a>";				/////////////// listo
							$y.="</div>";
						$y.="</div>";
						$y.="<div class='fijaproceso main' id='contenido'>";
						$y.="</div>";
					$y.="</div>";
				$y.="</div>";

				$admin=0;
				$arreglo=array('sess'=>"abierta", 'fondo'=>$valor, 'header'=>$x, 'cuerpo'=>$y, 'admin'=>$admin);
				///////////////////////////fin sesion abierta
			}
			else {
				///////////////////////////login
				$valor=$_SESSION['idfondo'];
				$arreglo=array('sess'=>"cerrada", 'fondo'=>$valor);
				//////////////////////////fin login
			}
			return json_encode($arreglo);
		}
		public function salir(){
			$_SESSION['autoriza'] = 0;
			$_SESSION['idusuario']="";
		}
		public function ses(){
			if(isset($_SESSION['autoriza']) and isset($_SESSION['idusuario']) and ($_SESSION['autoriza']==1 and strlen($_SESSION['idusuario'])>0)){
				$arr=array();
				$arr=array('sess'=>"abierta");
				return json_encode($arr);
			}
			else{
				$arr=array();
				$arr=array('sess'=>"cerrada");
				return json_encode($arr);
			}
		}

		public function insert($DbTableName, $values = array()){
			$arreglo=array();
			try{
				self::set_names();
				$this->dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

				foreach ($values as $field => $v)
				$ins[] = ':' . $field;

				$ins = implode(',', $ins);
				$fields = implode(',', array_keys($values));
				$sql="INSERT INTO $DbTableName ($fields) VALUES ($ins)";
				$sth = $this->dbh->prepare($sql);
				foreach ($values as $f => $v){
					$sth->bindValue(':' . $f, $v);
				}
				if ($sth->execute()){
					$arreglo+=array('id'=>$this->lastId = $this->dbh->lastInsertId());
					$arreglo+=array('error'=>0);
					$arreglo+=array('terror'=>'');
					$arreglo+=array('param1'=>'');
					$arreglo+=array('param2'=>'');
					$arreglo+=array('param3'=>'');
					return json_encode($arreglo);
				}
			}
			catch(PDOException $e){
				$arreglo+=array('id'=>0);
				$arreglo+=array('error'=>1);
				$arreglo+=array('terror'=>$e->getMessage());
				return json_encode($arreglo);
			}
		}
		public function update($DbTableName, $id = array(), $values = array()){
			$arreglo=array();
			try{
				self::set_names();
				$this->dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
				$x="";
				$idx="";
				foreach ($id as $field => $v){
					$condicion[] = $field.'= :' . $field."_c";
				}
				$condicion = implode(' and ', $condicion);
				foreach ($values as $field => $v){
					$ins[] = $field.'= :' . $field;
				}
				$ins = implode(',', $ins);

				$sql2="update $DbTableName set $ins where $condicion";
				$sth = $this->dbh->prepare($sql2);
				foreach ($values as $f => $v){
					$sth->bindValue(':' . $f, $v);
				}
				foreach ($id as $f => $v){
					if(strlen($idx)==0){
						$idx=$v;
					}
					$sth->bindValue(':' . $f."_c", $v);
				}
				if($sth->execute()){
					$arreglo+=array('id'=>$idx);
					$arreglo+=array('error'=>0);
					$arreglo+=array('terror'=>'');
					$arreglo+=array('param1'=>'');
					$arreglo+=array('param2'=>'');
					$arreglo+=array('param3'=>'');
					return json_encode($arreglo);
				}
			}
			catch(PDOException $e){
				$arreglo+=array('id'=>0);
				$arreglo+=array('error'=>1);
				$arreglo+=array('terror'=>$e->getMessage());
				return json_encode($arreglo);
			}
		}

		public function borrar($DbTableName, $key, $id){
			$arreglo=array();
			try{
				self::set_names();
				$sql="delete from $DbTableName where $key=$id";
				$sth = $this->dbh->prepare($sql);
				$a=$sth->execute();
				if($a){
					$arreglo+=array('id'=>$id);
					$arreglo+=array('error'=>0);
					$arreglo+=array('terror'=>'');
					$arreglo+=array('param1'=>'');
					$arreglo+=array('param2'=>'');
					$arreglo+=array('param3'=>'');
					return json_encode($arreglo);
				}
				else{
					$arreglo+=array('id'=>$id);
					$arreglo+=array('error'=>1);
					$arreglo+=array('terror'=>$sql.$sth->errorInfo());
					$arreglo+=array('param1'=>'');
					$arreglo+=array('param2'=>'');
					$arreglo+=array('param3'=>'');
					return json_encode($arreglo);
				}
			}
			catch(PDOException $e){
				$arreglo+=array('id'=>0);
				$arreglo+=array('error'=>1);
				$arreglo+=array('terror'=>$e->getMessage());
				return json_encode($arreglo);
			}
		}
		public function general($sql,$key=""){
			try{
				self::set_names();
				$sth = $this->dbh->prepare($sql);
				$sth->execute();
				if(strlen($key)==0){
					return $sth->fetchAll();
				}
				else{
					return $sth->fetch();
				}
			}
			catch(PDOException $e){
				return "Database access FAILED!".$e->getMessage();
			}
		}

		public function fondo(){
			$_SESSION['idfondo']=$_REQUEST['imagen'];
			$this->update('usuarios',array('idpersona'=>$_SESSION['idusuario']), array('idfondo'=>$_SESSION['idfondo']));
		}
		public function fondo_carga(){
			$x="";
			$directory="fondo/";
			$dirint = dir($directory);
			$x.= "<ul class='nav navbar-nav navbar-right'>";
				$x.= "<li class='nav-item dropdown'>";
					$x.= "<a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><i class='fas fa-desktop'></i>Fondos</a>";
					$x.= "<div class='dropdown-menu' aria-labelledby='navbarDropdown' style='width: 200px;max-height: 400px !important;overflow: scroll;overflow-x: scroll;overflow-x: hidden;'>";
						while (($archivo = $dirint->read()) !== false){
							if ($archivo != "." && $archivo != ".." && $archivo != "" && substr($archivo,-4)==".jpg"){
								$x.= "<a class='dropdown-item' href='#' id='fondocambia' title='Click para aplicar el fondo'><img src='$directory".$archivo."' alt='Fondo' class='rounded' style='width:140px;height:80px'></a>";
							}
						}
					$x.= "</div>";
				$x.= "</li>";
			$x.= "</ul>";
			$dirint->close();
			return $x;
		}
		public function leerfondo(){
			return $_SESSION['idfondo'];
		}
		public function subir_file(){
			$contarx=0;
			$arr=array();

			foreach ($_FILES as $key){
				$extension = pathinfo($key['name'], PATHINFO_EXTENSION);
				$n = $key['name'];
				$s = $key['size'];
				$string = trim($n);
				$string = str_replace( $extension,"", $string);
				$string = str_replace( array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'), array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'), $string );
				$string = str_replace( array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'), array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'), $string );
				$string = str_replace( array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'), array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'), $string );
				$string = str_replace( array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'), array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'), $string );
				$string = str_replace( array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'), array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'), $string );
				$string = str_replace( array('ñ', 'Ñ', 'ç', 'Ç'), array('n', 'N', 'c', 'C',), $string );
				$string = str_replace( array(' '), array('_'), $string);
				$string = str_replace(array("\\","¨","º","-","~","#","@","|","!","\"","·","$","%","&","/","(",")","?","'","¡","¿","[","^","`","]","+","}","{","¨","´",">","<",";",",",":","."),'', $string );
				$string.=".".$extension;
				$n_nombre=date("YmdHis")."_".$contarx."_".rand(1,1983).".".$extension;
				$destino="historial/".$n_nombre;

				if(move_uploaded_file($key['tmp_name'],$destino)){
					chmod($destino,0666);
					$arr[$contarx] = array("archivo" => $n_nombre);
				}
				else{

				}
				$contarx++;
			}
			$myJSON = json_encode($arr);
			return $myJSON;
		}
		public function guardar_file(){
			$arreglo =array();
			$x="";
			if (isset($_REQUEST['id'])){$id=$_REQUEST['id'];}
			if (isset($_REQUEST['ruta'])){$ruta=$_REQUEST['ruta'];}
			if (isset($_REQUEST['tipo'])){$tipo=$_REQUEST['tipo'];}
			if (isset($_REQUEST['ext'])){$ext=$_REQUEST['ext'];}
			if (isset($_REQUEST['tabla'])){$tabla=$_REQUEST['tabla'];}
			if (isset($_REQUEST['campo'])){$campo=$_REQUEST['campo'];}
			if (isset($_REQUEST['direccion'])){$direccion=$_REQUEST['direccion'];}
			if (isset($_REQUEST['keyt'])){$keyt=$_REQUEST['keyt'];}
			if($tipo==1){	//////////////update
				$arreglo+=array($campo=>$direccion);
				$x=$this->update($tabla,array($keyt=>$id), $arreglo);
				rename("historial/$direccion", "$ruta/$direccion");
			}
			else{
				$arreglo+=array($campo=>$direccion);
				$arreglo+=array($keyt=>$id);
				$x=$this->insert($tabla, $arreglo);
				rename("historial/$direccion", "$ruta/$direccion");
			}
			return $x;
		}
		public function eliminar_file(){
			$arreglo =array();
			$x="";
			if (isset($_REQUEST['ruta'])){$ruta=$_REQUEST['ruta'];}
			if (isset($_REQUEST['key'])){$key=$_REQUEST['key'];}
			if (isset($_REQUEST['keyt'])){$keyt=$_REQUEST['keyt'];}
			if (isset($_REQUEST['tabla'])){$tabla=$_REQUEST['tabla'];}
			if (isset($_REQUEST['campo'])){$campo=$_REQUEST['campo'];}
			if (isset($_REQUEST['tipo'])){$tipo=$_REQUEST['tipo'];}
			if (isset($_REQUEST['borrafile'])){$borrafile=$_REQUEST['borrafile'];}

			if($borrafile==1){
				if ( file_exists($_REQUEST['ruta']) ) {
					unlink($_REQUEST['ruta']);
				}
				else{
				}
			}
			if($tipo==1){ ////////////////actualizar tabla
				$arreglo+=array($campo=>"");
				$x.=$this->update($tabla,array($keyt=>$key), $arreglo);
			}
			if($tipo==2){
				$x.=$this->borrar($tabla,$keyt,$key);
			}
			return "$x";
		}
		public function recuperar(){
			$x="";
			if (isset($_REQUEST['telefono'])){$texto=$_REQUEST['telefono'];}
			$sql="select * from usuarios where usuario='$texto' or correo='$texto'";
			$res=$this->general($sql);
			if(count($res)>0){
				if(strlen($res[0]['correo'])>0){


					$pass=$this->genera_random(8);
					$passg=md5(trim($pass));

					$sql="update usuarios set pass=:pass where idpersona=:id";
					$sth = $this->dbh->prepare($sql);
					$sth->bindValue(":pass",$passg);
					$sth->bindValue(":id",$res[0]['idpersona']);
					$sth->execute();

					$texto="La nueva contraseña es: <br> $pass";
					$texto.="<br></a>";

					$asunto= "Recuperar contraseña";
					return $this->correo($res[0]['correo'], $texto, $asunto);
				}
				else{
					$arreglo+=array('id'=>0);
					$arreglo+=array('error'=>0);
					$arreglo+=array('terror'=>"no tiene correo registrado en la plantilla");
					return json_encode($arreglo);
				}
			}
			else{
				return 0;
			}
		}
		public function genera_random($length = 8) {
			return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
		}
		public function correo($correo, $texto, $asunto){
			/////////////////////////////////////////////Correo
			require '../vendor/autoload.php';
			$mail = new PHPMailer;
			$mail->CharSet = 'UTF-8';

			$mail->Body    = $asunto;
			$mail->Subject = $asunto;
			$mail->AltBody = $asunto;

			$mail->isSMTP();
			$mail->Host = "smtp.gmail.com";						  // Specify main and backup SMTP servers
			$mail->SMTPAuth = true;                               // Enable SMTP authentication
			$mail->Username = "tic.shop.adm@gmail.com";       // SMTP username
			$mail->Password = "ticshop2020";                       // SMTP password
			$mail->SMTPSecure = "ssl";                            // Enable TLS encryption, `ssl` also accepted
			$mail->Port = 465;                                    // TCP port to connect to
			$mail->CharSet = 'UTF-8';
			//$mail->From = "tic.shop.adm@gmail.com";
			$mail->From = "ventas@tic-shop.com.mx";
			$mail->FromName = "TIC-SHOP";

			$mail->IsHTML(true);
			$mail->addAddress($correo);
			$mail->addBCC("ventas@tic-shop.com.mx");

			$mail->msgHTML($texto);
			$arreglo=array();
			//send the message, check for errors
			if (!$mail->send()) {
				$arreglo+=array('id'=>0);
				$arreglo+=array('error'=>1);
				$arreglo+=array('terror'=>$mail->ErrorInfo);
				$arreglo+=array('param1'=>'');
				$arreglo+=array('param2'=>'');
				$arreglo+=array('param3'=>'');
				return json_encode($arreglo);
			} else {
				$arreglo+=array('id'=>0);
				$arreglo+=array('error'=>0);
				$arreglo+=array('terror'=>'');
				$arreglo+=array('param1'=>'');
				$arreglo+=array('param2'=>'');
				$arreglo+=array('param3'=>'');
				return json_encode($arreglo);
			}
		}
}
	if(strlen($ctrl)>0){
		$db = new ipsi();
		if(strlen($function)>0){
			echo $db->$function();
		}
	}
	function moneda($valor){
		return "$ ".number_format( $valor, 2, "." , "," );
	}
	function fecha($fecha,$key=""){
		$fecha = new DateTime($fecha);
		if($key==1){
			$mes=$fecha->format('m');
			if ($mes==1){ $mes="Enero";}
			if ($mes==2){ $mes="Febrero";}
			if ($mes==3){ $mes="Marzo";}
			if ($mes==4){ $mes="Abril";}
			if ($mes==5){ $mes="Mayo";}
			if ($mes==6){ $mes="Junio";}
			if ($mes==7){ $mes="Julio";}
			if ($mes==8){ $mes="Agosto";}
			if ($mes==9){ $mes="Septiembre";}
			if ($mes==10){ $mes="Octubre";}
			if ($mes==11){ $mes="Noviembre";}
			if ($mes==12){ $mes="Diciembre";}

			return $fecha->format('d')." de $mes de ".$fecha->format('Y');
		}
		if($key==2){
			return $fecha->format('d-m-Y H:i:s');
		}
		else{
			return $fecha->format('d-m-Y');
		}
	}


?>
