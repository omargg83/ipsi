<?php
	session_name("ipsi_online#&%1");
	@session_start();
	if (isset($_REQUEST['function'])){$function=clean_var($_REQUEST['function']);}	else{ $function="";}
	if (isset($_REQUEST['ctrl'])){$ctrl=clean_var($_REQUEST['ctrl']);}	else{ $ctrl="";}

	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	date_default_timezone_set("America/Mexico_City");

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;

	require_once("init.php");
	class ipsi{
		public $nivel_personal;
		public $nivel_captura;
		public $personas;
		public $arreglo;
		public $limite=300;

		public function __construct(){
			date_default_timezone_set("America/Mexico_City");
			try{
				$this->dbh = new PDO("mysql:host=".SERVIDOR.";port=".PORT.";dbname=".BDD, MYSQLUSER, MYSQLPASS);
				$this->dbh->query("SET NAMES 'utf8'");
			}
			catch(PDOException $e){
				return "Database access FAILED!".$e->getMessage();
			}
		}
		public function salir(){
			$_SESSION['autoriza'] = 0;
			$_SESSION['idusuario']="";
			$_SESSION = array();
			session_unset();
			session_destroy();
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
					$arreglo+=array('id1'=>$this->lastId = $this->dbh->lastInsertId());
					$arreglo+=array('id2'=>'');
					$arreglo+=array('id3'=>'');
					$arreglo+=array('error'=>0);
					$arreglo+=array('terror'=>'');
					return json_encode($arreglo);
				}
			}
			catch(PDOException $e){
				$arreglo+=array('id1'=>0);
				$arreglo+=array('error'=>1);
				$arreglo+=array('terror'=>$e->getMessage());
				return json_encode($arreglo);
			}
		}
		public function update($DbTableName, $id = array(), $values = array()){
			$arreglo=array();
			try{

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
					$arreglo+=array('id1'=>$idx);
					$arreglo+=array('error'=>0);
					$arreglo+=array('terror'=>'');
					$arreglo+=array('id2'=>'');
					$arreglo+=array('id3'=>'');
					return json_encode($arreglo);
				}
			}
			catch(PDOException $e){
				$arreglo+=array('id1'=>0);
				$arreglo+=array('error'=>1);
				$arreglo+=array('terror'=>$e->getMessage());
				return json_encode($arreglo);
			}
		}

		public function borrar($DbTableName, $key, $id){
			$arreglo=array();
			try{
				$sql="delete from $DbTableName where $key=$id";
				$sth = $this->dbh->prepare($sql);
				$a=$sth->execute();
				if($a){
					$arreglo+=array('id1'=>$id);
					$arreglo+=array('error'=>0);
					$arreglo+=array('terror'=>'');
					$arreglo+=array('id2'=>'');
					$arreglo+=array('id3'=>'');
					return json_encode($arreglo);
				}
				else{
					$arreglo+=array('id1'=>$id);
					$arreglo+=array('error'=>1);
					$b=$sth->errorInfo();
					$arreglo+=array('terror'=>$b[2]);
					$arreglo+=array('id2'=>'');
					$arreglo+=array('id3'=>'');
					return json_encode($arreglo);
				}
			}
			catch(PDOException $e){
				$arreglo+=array('id1'=>0);
				$arreglo+=array('error'=>1);
				$arreglo+=array('terror'=>$e->getMessage());
				return json_encode($arreglo);
			}
		}
		public function general($sql,$key=""){
			try{

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

		////////////////////////////funciones

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
					$arreglo+=array('id1'=>0);
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
				$arreglo+=array('id1'=>0);
				$arreglo+=array('error'=>1);
				$arreglo+=array('terror'=>$mail->ErrorInfo);
				$arreglo+=array('id2'=>'');
				$arreglo+=array('id3'=>'');
				return json_encode($arreglo);
			} else {
				$arreglo+=array('id1'=>0);
				$arreglo+=array('error'=>0);
				$arreglo+=array('terror'=>'');
				$arreglo+=array('id2'=>'');
				$arreglo+=array('id3'=>'');
				return json_encode($arreglo);
			}
		}

		public function contexto_carga($idcontexto, $actividad){

			$sql="select * from contexto where id=:id";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":id",$idcontexto);
			$sth->execute();
			$row=$sth->fetch(PDO::FETCH_OBJ);

			$sql="select * from contexto_resp where idcontexto=:id";
			$contx = $this->dbh->prepare($sql);
			$contx->bindValue(":id",$row->id);
			$contx->execute();
			$texto="";
			$fecha="";
			$archivo="";
			$marca="";
			if($contx->rowCount()>0){
				$contexto_resp=$contx->fetch(PDO::FETCH_OBJ);
				$texto=$contexto_resp->texto;
				$fecha=$contexto_resp->fecha;
				$archivo=$contexto_resp->archivo;
				$marca=$contexto_resp->marca;
			}

			if(strlen($marca)!=0){
				echo "<div class='text-right'>";
						echo "<i class='fas fa-check'></i>";
				echo "</div>";
			}

			if(strlen($row->observaciones)>0){
				echo "<div class='mb-3'>";
					echo $row->observaciones;
				echo "</div>";
				echo "<hr>";
			}

			echo "<div class='mb-3'>";

				if($row->tipo=="imagen"){
					echo "<img src='".$db->doc.$row->texto."'/>";
				}
				else if($row->tipo=="texto"){
					echo $row->texto;
				}
				else if($row->tipo=="video"){
					echo $row->texto;
				}
				else if($row->tipo=="archivo"){
					echo "<a href='".$db->doc.$row->texto."' download='$row->texto'>Descargar</a>";
				}
				else if($row->tipo=="textores"){
					echo "<div id='div_$row->id' name='div_$row->id' onclick='editable(this)' style='width:100%; height: 200px; border:1px solid silver'>$texto</div>";
					echo "<small>De clic para editar</small>";

					//echo "<textarea class='texto' id='texto_$row->id' name='texto_$row->id' rows=5 placeholder=''>$texto</textarea>";
				}
				else if($row->tipo=="textocorto"){
					echo "<textarea class='form-control' id='texto_$row->id' name='texto_$row->id' rows=5 placeholder=''>$texto</textarea>";
				}
				else if($row->tipo=="fecha"){
					echo "<input type='date' name='texto' id='texto' value='$fecha' class='form-control'>";
				}
				else if($row->tipo=="archivores"){
					if(strlen($archivo)>0){
						echo "<a href='".$db->resp.$archivo."' download='$archivo'>Ver</a>";
					}
					echo "<input type='file' name='archivo' id='archivo' class='form-control'>";
				}
				else if($row->tipo=="pregunta"){
					echo $row->texto;

					///////////<!-- Respuestas  -->
					echo "<div class='container-fluid'>";
						$rx=$this->respuestas_ver($row->id);
						foreach ($rx as $respuesta) {
							$texto_resp="";
							$valor_resp="";
							$resp_idrespuesta="";

							echo "<div class='row'>";

								//////////////////para obtener Respuestas
								$sql="select * from contexto_resp where idcontexto=:id and idrespuesta=:idrespuesta";
								$contx = $this->dbh->prepare($sql);
								$contx->bindValue(":id",$row->id);
								$contx->bindValue(":idrespuesta",$respuesta->id);
								$contx->execute();
								$resp=$contx->fetch(PDO::FETCH_OBJ);
								$correcta=0;
								$texto_resp="";
								if($contx->rowCount()>0){
									$correcta=1;
									$texto_resp=$resp->texto;
									$valor_resp=$resp->valor;
								}

								echo "<div class='col-1'>";
									if($row->incisos==1){
										$idx="";
										echo "<input type='checkbox' name='checkbox_".$respuesta->id."' value='$respuesta->id' ";
										if($correcta){ echo " checked";}
										echo ">";
									}
									else{
										$idx=$row->id;
										echo "<input type='radio' name='radio_".$idx."' value='$respuesta->id' ";
											if($correcta){
												echo " checked";
											}
										echo ">";
									}
								echo "</div>";

								if(strlen($respuesta->imagen)>0){
									echo "<div class='col-1'>";
											echo "<img src=".$db->doc.$respuesta->imagen." alt='' width='20px'>";
									echo "</div>";
								}

								echo "<div class='col-6'>";
									echo $respuesta->nombre;
								echo "</div>";

								///////////////////////////////////aca el valor
								if($actividad->tipo=="evaluacion"){
									echo "<div class='col-1'>";
										echo $respuesta->valor;
									echo "</div>";
								}

								echo "<div class='col-3'>";
									if($row->usuario==1){
										echo "<input type='text' name='resp_".$respuesta->id."' id='resp_".$respuesta->id."' value='$texto_resp' placeholder='Define..' class='form-control form-control-sm'>";
									}
								echo "</div>";
							echo "</div>";
						}

						if($row->personalizado==1){
							$texto="";
							$otro=0;

							$sql="select * from contexto_resp where idcontexto=$row->id and valor='OTRO'";
							$contx = $db->dbh->prepare($sql);
							$contx->execute();
							if($contx->rowCount()>0){
								$resp=$contx->fetch(PDO::FETCH_OBJ);
								$texto=$resp->texto;
								$otro=1;
							}

							echo "<div class='row'>";
								echo "<div class='col-3'>";
								echo "</div>";
								if($row->incisos==1){
										echo "<div class='col-1'>";
											echo "<input type='checkbox' name='checkbox_otro'";
											if($otro==1){
												echo " checked";
											}
											echo " value='otro'>";
										echo "</div>";
										echo "<div class='col-6'>";
											echo "<input type='text' name='resp_otro' id='resp_otro' value='$texto' class='form-control form-control-sm' placeholder='Otro'>";
										echo "</div>";
									}
									else{
										echo "<div class='col-1'>";
											echo "<input type='radio' name='radio_".$idx."' value='otro'";
											if($otro==1){
												echo " checked";
											}
											echo ">";
										echo "</div>";
										echo "<div class='col-6'>";
											echo "<input type='text' name='resp_otro' id='per_".$row->id."' value='$texto' class='form-control form-control-sm' placeholder='otro'>";
										echo "</div>";
								}
							echo "</div>";
						}
					echo "</div>";
				}
			echo "</div>";
		}

	}
	function clean_var($val){
		$val=htmlspecialchars(strip_tags(trim($val)));
		return $val;
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
