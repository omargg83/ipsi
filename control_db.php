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
	$_SESSION['horas_confirma']=24;
	/*
		if($_SESSION['nivel']==1){
			$_SESSION['tipo_user'] = "Admin General";
		}
		if($_SESSION['nivel']==2){
			$_SESSION['tipo_user'] = "Terapeuta";
		}
		if($_SESSION['nivel']==3){
			$_SESSION['tipo_user'] = "Admin Sucursal";
		if($_SESSION['nivel']==4){
			$_SESSION['tipo_user'] = "Secretaria";
		}

		if($key->nivel==1) echo "Admin General";
		if($key->nivel==2) echo "Terapeuta";
		if($key->nivel==3) echo "Admin Sucursal";
		if($key->nivel==4) echo "Secretaria";
	*/

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

		public function correo($correo_send, $ccp ,$variables, $tipo){
			/////////////////////////////////////////////Correo
			$sql="SELECT * FROM correo where config='$tipo'";
			$sth = $this->dbh->query($sql);
			$correo=$sth->fetch(PDO::FETCH_OBJ);
			
			$texto=$correo->texto;
			
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
			$mail->addAddress($correo_send);

			foreach($ccp as $key){
			 	$mail->addCC($key);
			}
			

			$mail->msgHTML($texto);
			$arreglo=array();

			if (!$mail->send()) {
				$arreglo+=array('id'=>0);
				$arreglo+=array('error'=>1);
				$arreglo+=array('terror'=>$mail->ErrorInfo);
				return json_encode($arreglo);
			} else {
				$arreglo+=array('id'=>0);
				$arreglo+=array('error'=>0);
				$arreglo+=array('terror'=>'Se nofiticó al correo: '.$correo_send.' la nueva contraseña');
				return json_encode($arreglo);
			}
		}
		public function paginar($paginas,$pag,$pagx,$des,$div){
			echo "<div class='pag_sagyc'>";
				echo "<div class='paginas'>";
			    echo "<a is='b-link' title='Editar' des='$des' dix='$div'><i class='fas fa-angle-double-left'></i></a>";
					$max=$pag+4;
					$min=$pag-4;

					$pre=0;
					$pos=0;
					for($i=0;$i<$paginas;$i++){
						////////para las anteriores a la selecionada
						$ant=$pag-1;
						$desp=$pag+1;

						$b=$i+1;

						if($i==0 or $i==($paginas-1) or $ant==$i or $desp==$i or $pag==$i or $paginas<7){
							echo "<a class='"; if($pag==$i){ echo " active";} echo "' is='b-link' title='Editar' des='$des' dix='$div' v_pag='$i'>$b</a>";
						}
						else{
							if(($pre==0) or ($pos==0 and $pre==1 and $i>$pag)){
								echo "<a>...</a>";
								if($pre==0)
								$pre=1;
								if ($pos==0 and $pre==1 and $i>$pag){
									$pos=1;
								}
							}
						}
					}
			    echo "<a class='paginacion-item' is='b-link' title='Editar' des='$des' dix='$div' v_pag='$pagx'><i class='fas fa-angle-double-right'></i></a>";
				echo "</div>";
			echo "</div>";
		}
		public function paginar_x($paginas,$pag_actual,$des,$div,$var){
			$pagx=$paginas-1;
			echo "<div class='pag_sagyc'>";
				echo "<div class='paginas'>";
			    echo "<a is='b-link' title='Editar' des='$des' dix='$div'";
					foreach($var as $key => $value){
  					$mykey = $key;
						echo " v_".$key."='".$value."'";
					}
					echo "><i class='fas fa-angle-double-left'></i></a>";
					$max=$pag_actual+4;
					$min=$pag_actual-4;

					$pre=0;
					$pos=0;
					for($i=0;$i<$paginas;$i++){
						////////para las anteriores a la selecionada
						$ant=$pag_actual-1;
						$desp=$pag_actual+1;

						$b=$i+1;

							if($i==0 or $i==($paginas-1) or $ant==$i or $desp==$i or $pag_actual==$i or $paginas<7){
								echo "<a class='"; if($pag_actual==$i){ echo " active";} echo "' is='b-link' title='Editar' des='$des' dix='$div' v_pagina='$i' ";
								foreach($var as $key => $value){
			  					$mykey = $key;
									echo " v_".$key."='".$value."'";
								}
								echo ">$b</a>";
							}
							else{
								if(($pre==0) or ($pos==0 and $pre==1 and $i>$pag_actual)){
									echo "<a>...</a>";
									if($pre==0)
									$pre=1;
									if ($pos==0 and $pre==1 and $i>$pag_actual){
										$pos=1;
									}
								}
							}

					}
			    echo "<a class='paginacion-item' is='b-link' title='Editar' des='$des' dix='$div' v_pagina='$pagx' ";
					foreach($var as $key => $value){
  					$mykey = $key;
						echo " v_".$key."='".$value."'";
					}
					echo "><i class='fas fa-angle-double-right'></i></a>";
				echo "</div>";
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


?>
